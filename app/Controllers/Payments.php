<?php
namespace App\Controllers;

use App\Models\PaymentsModel;
use App\Models\UserModel;
use App\Models\NotificationsModel;

class Payments extends BaseController
{
    public function checkout()
    {
        $rol = session()->get('rol');

        // Si es administrador, lo redirigimos directamente al panel de validación de pagos
        if ($rol === 'admin') {
            return redirect()->to(base_url('dashboard/pagos'));
        }

        // Si es nutricionista u otro rol no elegible para compra, lo regresamos al inicio
        if (!in_array($rol, ['free', 'premium', 'pro'], true)) {
            return redirect()->to(base_url('dashboard'))->with('success', '¡Ya disfrutas de todos los beneficios de NutriCheck!');
        }

        $userId = session()->get('loggedUser');

        // Consultamos los datos actuales del usuario para mostrar estado y tiempo restante si es Premium
        $userModel = new UserModel();
        $usuario = $userModel->find($userId);

        $esPremium = in_array($rol, ['premium', 'pro'], true);
        $fechaVencimiento = $usuario['premium_expires_at'] ?? null;
        $diasRestantes = null;

        if ($esPremium && !empty($fechaVencimiento)) {
            $segundosRestantes = strtotime($fechaVencimiento) - time();
            $diasRestantes = max(0, (int) ceil($segundosRestantes / 86400));
        }

        // NUEVO: Verificamos si ya tiene un pago pendiente
        $paymentsModel = new PaymentsModel();
        $pagoPendiente = $paymentsModel->where('user_id', $userId)
                                       ->where('status', 'pending')
                                       ->first();

        // Le enviamos a la vista las variables para mostrar estado del plan y el formulario
        return view('payments/checkout', [
            'pagoPendiente'    => $pagoPendiente,
            'esPremium'        => $esPremium,
            'fechaVencimiento' => $fechaVencimiento,
            'diasRestantes'    => $diasRestantes,
        ]);
    }

    public function reportar()
    {
        if (!in_array(session()->get('rol'), ['free', 'premium', 'pro'], true)) {
            return redirect()->to(base_url('dashboard'));
        }

        $paymentsModel = new PaymentsModel();

        // NUEVO: VALIDACIÓN ANTI-SPAM
        // Si ya tiene un pago pendiente, lo rebotamos para evitar que sature la base de datos
        $existePendiente = $paymentsModel->where('user_id', session()->get('loggedUser'))
                                         ->where('status', 'pending')
                                         ->first();
        if ($existePendiente) {
            return redirect()->to(base_url('dashboard'))->with('fail', 'Ya tienes un reporte de pago en revisión. Por favor espera a que sea validado.');
        }

        // 1. Validación de campos de texto
        if (!$this->validate('reportePago')) {
            $errores = $this->validator->getErrors();
            return redirect()->back()->withInput()->with('fail', reset($errores));
        }

        // 2. Validación y subida de la captura de pantalla
        $archivoRecibo = $this->request->getFile('receipt_image');
        $nombreFoto = null;

        if ($archivoRecibo && $archivoRecibo->isValid() && !$archivoRecibo->hasMoved()) {
            $extension = $archivoRecibo->guessExtension();
            if (in_array($extension, ['png', 'jpg', 'jpeg'])) {
                $nombreFoto = $archivoRecibo->getRandomName();
                
                // Creamos la carpeta de recibos si no existe
                $rutaDestino = FCPATH . 'assets/receipts';
                if (!is_dir($rutaDestino)) { mkdir($rutaDestino, 0777, true); }

                $archivoRecibo->move($rutaDestino, $nombreFoto);
            } else {
                return redirect()->back()->withInput()->with('fail', 'El comprobante debe ser una imagen (JPG/PNG).');
            }
        }

        $referencia = trim((string) $this->request->getPost('reference_number'));

        // 3. Guardar en Base de Datos
        $paymentsModel->insert([
            'user_id'          => session()->get('loggedUser'),
            'amount'           => $this->request->getPost('amount'),
            'payment_method'   => $this->request->getPost('payment_method'),
            'reference_number' => $referencia,
            'receipt_image'    => $nombreFoto,
            'status'           => 'pending' // Entra a revisión del admin
        ]);

        // Notificar a los administradores sobre la nueva solicitud de pago
        $nombreUsuario = (string) (session()->get('name') ?? 'Un usuario');
        $notifModel = new NotificationsModel();
        $notifModel->notificarPorRoles(
            ['admin'],
            'Nueva solicitud de pago',
            "{$nombreUsuario} reportó un pago (Ref. #{$referencia}) pendiente de validación.",
            'dashboard/pagos',
            'pago'
        );

        $mensaje = in_array(session()->get('rol'), ['premium', 'pro'], true)
            ? '¡Renovación reportada con éxito! Un administrador validará tu pago en breve para extender tu suscripción Premium.'
            : '¡Pago reportado con éxito! Un administrador validará tu transferencia en breve para activar tu cuenta Premium.';

        return redirect()->to(base_url('dashboard'))->with('success', $mensaje);
    }

    // 1. Mostrar lista de pagos pendientes al Admin
    public function lista()
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->to(base_url('dashboard'));
        }

        $paymentsModel = new PaymentsModel();
        
        // Hacemos un JOIN con la tabla de usuarios para saber el nombre y correo de quien pagó
        $pagosPendientes = $paymentsModel->select('payments.*, users.name as user_name, users.email as user_email')
                                         ->join('users', 'users.id = payments.user_id')
                                         ->where('payments.status', 'pending')
                                         ->orderBy('payments.created_at', 'ASC')
                                         ->findAll();

        return view('payments/lista', ['pagos' => $pagosPendientes]);
    }

    // 2. Aprobar Pago y otorgar o extender Rol Premium
    public function aprobar(int $id)
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->to(base_url('dashboard'));
        }

        $paymentsModel = new PaymentsModel();
        $userModel = new UserModel();

        $pago = $paymentsModel->find($id);

        if ($pago) {
            $usuario = $userModel->find($pago['user_id']);

            $db = \Config\Database::connect();
            $db->transStart(); // INICIO DE TRANSACCIÓN

            // A. Cambiamos el estatus del pago a aprobado
            $paymentsModel->update($id, ['status' => 'approved']);

            // NUEVO: B. Convertimos al usuario en miembro Premium y le sumamos 1 MES de vigencia
            // Si ya tiene una suscripción vigente a futuro, sumamos 1 mes sobre su fecha de vencimiento actual
            if ($usuario && !empty($usuario['premium_expires_at']) && strtotime($usuario['premium_expires_at']) > time()) {
                $fechaExpiracion = date('Y-m-d H:i:s', strtotime('+1 month', strtotime($usuario['premium_expires_at'])));
            } else {
                $fechaExpiracion = date('Y-m-d H:i:s', strtotime('+1 month'));
            }
            
            $userModel->update($pago['user_id'], [
                'rol' => 'premium',
                'premium_expires_at' => $fechaExpiracion
            ]);

            $db->transComplete(); // FIN DE TRANSACCIÓN

            if ($db->transStatus() === false) {
                return redirect()->back()->with('fail', 'Error crítico de base de datos al procesar la suscripción.');
            }

            // Notificar al usuario sobre la verificación y activación de su plan Premium
            $fechaLegible = date('d/m/Y', strtotime($fechaExpiracion));
            $notifModel = new NotificationsModel();
            $notifModel->notificarUsuario(
                (int) $pago['user_id'],
                '¡Pago Premium verificado!',
                "Tu suscripción NutriCheckPro ha sido aprobada y está vigente hasta el {$fechaLegible}.",
                'premium/checkout',
                'pago'
            );

            return redirect()->back()->with('success', '¡Pago aprobado! La suscripción Premium del usuario se ha actualizado hasta el ' . $fechaLegible . '.');
        }

        return redirect()->back()->with('fail', 'El registro de pago no existe.');
    }

    // 3. Rechazar Pago
    public function rechazar(int $id)
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->to(base_url('dashboard'));
        }

        $paymentsModel = new PaymentsModel();
        $pago = $paymentsModel->find($id);
        
        if ($pago) {
            $paymentsModel->update($id, ['status' => 'rejected']);

            // Notificar al usuario sobre el rechazo de su reporte
            $notifModel = new NotificationsModel();
            $notifModel->notificarUsuario(
                (int) $pago['user_id'],
                'Reporte de pago rechazado',
                "Tu pago con referencia #{$pago['reference_number']} no pudo ser verificado. Puedes enviar un nuevo reporte.",
                'premium/checkout',
                'pago'
            );

            return redirect()->back()->with('success', 'El reporte de pago ha sido marcado como rechazado.');
        }

        return redirect()->back()->with('fail', 'El registro de pago no existe.');
    }
}