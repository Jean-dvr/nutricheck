<?php
namespace App\Controllers;

use App\Models\PaymentsModel;

class Payments extends BaseController
{
    public function checkout()
    {
        // Si ya es premium, lo regresamos al inicio
        if (session()->get('rol') !== 'free') {
            return redirect()->to(base_url('dashboard'))->with('success', '¡Ya disfrutas de todos los beneficios de NutriCheck!');
        }

        // NUEVO: Verificamos si ya tiene un pago pendiente
        $paymentsModel = new \App\Models\PaymentsModel();
        $pagoPendiente = $paymentsModel->where('user_id', session()->get('loggedUser'))
                                       ->where('status', 'pending')
                                       ->first();

        // Le enviamos a la vista la variable para ocultar o mostrar el formulario
        return view('payments/checkout', ['pagoPendiente' => $pagoPendiente]);
    }

    public function reportar()
    {
        if (session()->get('rol') !== 'free') {
            return redirect()->to(base_url('dashboard'));
        }

        $paymentsModel = new \App\Models\PaymentsModel();

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

        // 3. Guardar en Base de Datos
        $paymentsModel->insert([
            'user_id'          => session()->get('loggedUser'),
            'amount'           => $this->request->getPost('amount'),
            'payment_method'   => $this->request->getPost('payment_method'),
            'reference_number' => trim($this->request->getPost('reference_number')),
            'receipt_image'    => $nombreFoto,
            'status'           => 'pending' // Entra a revisión del admin
        ]);

        return redirect()->to(base_url('dashboard'))->with('success', '¡Pago reportado con éxito! Un administrador validará tu transferencia en breve para activar tu cuenta Premium.');
    }

    // 1. Mostrar lista de pagos pendientes al Admin
    public function lista()
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->to(base_url('dashboard'));
        }

        $paymentsModel = new \App\Models\PaymentsModel();
        
        // Hacemos un JOIN con la tabla de usuarios para saber el nombre y correo de quien pagó
        $pagosPendientes = $paymentsModel->select('payments.*, users.name as user_name, users.email as user_email')
                                         ->join('users', 'users.id = payments.user_id')
                                         ->where('payments.status', 'pending')
                                         ->orderBy('payments.created_at', 'ASC')
                                         ->findAll();

        return view('payments/lista', ['pagos' => $pagosPendientes]);
    }

    // 2. Aprobar Pago y otorgar Rol Premium
    public function aprobar($id)
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->to(base_url('dashboard'));
        }

        $paymentsModel = new \App\Models\PaymentsModel();
        $userModel = new \App\Models\UserModel();

        $pago = $paymentsModel->find($id);

        if ($pago) {
            $db = \Config\Database::connect();
            $db->transStart(); // INICIO DE TRANSACCIÓN

            // A. Cambiamos el estatus del pago a aprobado
            $paymentsModel->update($id, ['status' => 'approved']);

            // NUEVO: B. Convertimos al usuario en miembro Premium y le sumamos 1 MES de vigencia
            $fechaExpiracion = date('Y-m-d H:i:s', strtotime('+1 month'));
            
            $userModel->update($pago['user_id'], [
                'rol' => 'premium',
                'premium_expires_at' => $fechaExpiracion
            ]);

            $db->transComplete(); // FIN DE TRANSACCIÓN

            if ($db->transStatus() === false) {
                return redirect()->back()->with('fail', 'Error crítico de base de datos al procesar la suscripción.');
            }

            return redirect()->back()->with('success', '¡Pago aprobado! El usuario ahora es miembro Premium por 1 mes.');
        }

        return redirect()->back()->with('fail', 'El registro de pago no existe.');
    }

    // 3. Rechazar Pago
    public function rechazar($id)
    {
        if (session()->get('rol') !== 'admin') {
            return redirect()->to(base_url('dashboard'));
        }

        $paymentsModel = new \App\Models\PaymentsModel();
        
        if ($paymentsModel->find($id)) {
            $paymentsModel->update($id, ['status' => 'rejected']);
            return redirect()->back()->with('success', 'El reporte de pago ha sido marcado como rechazado.');
        }

        return redirect()->back()->with('fail', 'El registro de pago no existe.');
    }
}