<?php

namespace App\Controllers;

/**
 * Controlador de la Calculadora de Evaluación Física (IMC, Cintura e ICE).
 * Aplica rangos OMS/NICE para adultos, valida coherencia anatómica, persiste la última
 * evaluación por usuario en sesión (Post-Redirect-Get) y genera orientación personalizada.
 */
class Imc extends BaseController
{
    private const SESSION_KEY = 'imc_ultima_evaluacion';

    public function index()
    {
        $userId          = (int) session()->get('loggedUser');
        $errores         = session()->getFlashdata('imc_errors');
        $errorCoherencia = session()->getFlashdata('imc_error_coherencia');
        $inputsError     = session()->getFlashdata('imc_input_error');
        $recienCalculado = (bool) session()->getFlashdata('imc_recien_calculado');

        $data = [
            'recienCalculado' => $recienCalculado,
        ];

        // Si hubo error de validación o de coherencia en el envío actual, mostramos el aviso y los datos tecleados
        if (is_array($errores) && !empty($errores)) {
            $data['erroresValidacion'] = $errores;
            if (is_array($inputsError)) {
                $data = array_merge($data, $inputsError);
            }
            return view('imc/index', $data);
        }

        if (!empty($errorCoherencia)) {
            $data['errorCoherencia'] = (string) $errorCoherencia;
            if (is_array($inputsError)) {
                $data = array_merge($data, $inputsError);
            }
            return view('imc/index', $data);
        }

        // Recuperar la última evaluación guardada en sesión para el usuario actual
        $guardada = session()->get(self::SESSION_KEY);
        if (is_array($guardada)) {
            if ((int) ($guardada['user_id'] ?? 0) === $userId && is_array($guardada['data'] ?? null)) {
                $data = array_merge($guardada['data'], $data);
            } else {
                // Evita mostrar datos de otro usuario que haya usado el mismo navegador
                session()->remove(self::SESSION_KEY);
            }
        }

        return view('imc/index', $data);
    }

    public function calcular()
    {
        $pesoPost    = $this->request->getPost('peso');
        $alturaPost  = $this->request->getPost('altura');
        $cinturaPost = $this->request->getPost('cintura');
        $sexoPost    = $this->request->getPost('sexo');

        $inputsEnviados = [
            'pesoGuardado'    => $pesoPost,
            'alturaGuardada'  => $alturaPost,
            'cinturaGuardada' => $cinturaPost,
            'sexoGuardado'    => $sexoPost,
        ];

        // 1. Validar rangos numéricos mediante Validation.php
        if (!$this->validate('calculoImc')) {
            return redirect()->to(base_url('imc'))
                             ->with('imc_errors', $this->validator->getErrors())
                             ->with('imc_input_error', $inputsEnviados);
        }

        $peso     = (float) $pesoPost;
        $alturaCm = (float) $alturaPost;
        $cintura  = (float) $cinturaPost;
        $sexo     = (string) $sexoPost;

        // 2. Cálculos base (IMC, Rango de Peso Saludable e Índice Cintura-Estatura)
        $alturaMetros = $alturaCm / 100;
        $imc          = round($peso / ($alturaMetros * $alturaMetros), 2);
        $iceReal      = $cintura / $alturaCm;
        $ice          = round($iceReal, 2);

        // 3. Filtro de coherencia anatómica para evitar diagnósticos contradictorios por error de tipeo
        $errorCoherencia = $this->verificarCoherencia($imc, $iceReal);
        if ($errorCoherencia !== null) {
            return redirect()->to(base_url('imc'))
                             ->with('imc_error_coherencia', $errorCoherencia)
                             ->with('imc_input_error', $inputsEnviados)
                             ->with('imc_recien_calculado', true);
        }

        // 4. Rango de peso saludable según estatura (OMS: IMC 18.5 a 24.9)
        $pesoMinSaludable = round(18.5 * $alturaMetros * $alturaMetros, 1);
        $pesoMaxSaludable = round(24.9 * $alturaMetros * $alturaMetros, 1);

        if ($peso < $pesoMinSaludable) {
            $diferenciaPeso = round($pesoMinSaludable - $peso, 1);
            $textoPesoRef   = "Estás {$diferenciaPeso} kg por debajo del límite inferior de tu rango saludable.";
        } elseif ($peso > $pesoMaxSaludable) {
            $diferenciaPeso = round($peso - $pesoMaxSaludable, 1);
            $textoPesoRef   = "Estás {$diferenciaPeso} kg por encima del límite superior de tu rango saludable.";
        } else {
            $textoPesoRef   = 'Tu peso actual se encuentra dentro del rango saludable estimado para tu estatura.';
        }

        // 5. Clasificación detallada de IMC (OMS) sin brechas decimales
        if ($imc < 16.5) {
            $nivelImc    = 'bajo_severo';
            $categoria   = 'Bajo peso severo';
            $claseAlerta = 'imc-tone-danger';
        } elseif ($imc < 18.5) {
            $nivelImc    = 'bajo';
            $categoria   = 'Bajo peso';
            $claseAlerta = 'imc-tone-warning';
        } elseif ($imc < 25.0) {
            $nivelImc    = 'normal';
            $categoria   = 'Peso normal';
            $claseAlerta = 'imc-tone-success';
        } elseif ($imc < 30.0) {
            $nivelImc    = 'sobrepeso';
            $categoria   = 'Sobrepeso';
            $claseAlerta = 'imc-tone-warning';
        } elseif ($imc < 35.0) {
            $nivelImc    = 'obesidad_1';
            $categoria   = 'Obesidad Grado I';
            $claseAlerta = 'imc-tone-danger';
        } elseif ($imc < 40.0) {
            $nivelImc    = 'obesidad_2';
            $categoria   = 'Obesidad Grado II';
            $claseAlerta = 'imc-tone-danger';
        } else {
            $nivelImc    = 'obesidad_3';
            $categoria   = 'Obesidad Grado III';
            $claseAlerta = 'imc-tone-danger';
        }

        // Posición exacta del indicador sobre la barra visual por tramos (0–20–50–75–100)
        $imcPosicion = $this->calcularPosicionBarra($imc);

        // 6. Evaluación de Perímetro Abdominal (Cortes OMS por sexo biológico)
        if ($sexo === 'M') {
            $referenciaCintura = 'Saludable: < 94 cm | Aumentado: 94 – 101.9 cm | Alto: ≥ 102 cm';
            if ($cintura >= 102) {
                $nivelCintura  = 'alto';
                $riesgoCintura = 'Riesgo cardiovascular alto';
                $claseRiesgo   = 'imc-badge-danger';
            } elseif ($cintura >= 94) {
                $nivelCintura  = 'moderado';
                $riesgoCintura = 'Riesgo cardiovascular aumentado';
                $claseRiesgo   = 'imc-badge-warning';
            } else {
                $nivelCintura  = 'bajo';
                $riesgoCintura = 'Perímetro saludable';
                $claseRiesgo   = 'imc-badge-success';
            }
        } else {
            $referenciaCintura = 'Saludable: < 80 cm | Aumentado: 80 – 87.9 cm | Alto: ≥ 88 cm';
            if ($cintura >= 88) {
                $nivelCintura  = 'alto';
                $riesgoCintura = 'Riesgo cardiovascular alto';
                $claseRiesgo   = 'imc-badge-danger';
            } elseif ($cintura >= 80) {
                $nivelCintura  = 'moderado';
                $riesgoCintura = 'Riesgo cardiovascular aumentado';
                $claseRiesgo   = 'imc-badge-warning';
            } else {
                $nivelCintura  = 'bajo';
                $riesgoCintura = 'Perímetro saludable';
                $claseRiesgo   = 'imc-badge-success';
            }
        }

        // 7. Evaluación de Índice Cintura-Estatura (ICE - Guías NICE)
        if ($iceReal < 0.40) {
            $nivelIce  = 'bajo_deficit';
            $estadoIce = 'Por debajo del rango habitual';
            $claseIce  = 'imc-badge-info';
        } elseif ($iceReal < 0.50) {
            $nivelIce  = 'saludable';
            $estadoIce = 'Proporción saludable';
            $claseIce  = 'imc-badge-success';
        } elseif ($iceReal < 0.60) {
            $nivelIce  = 'moderado';
            $estadoIce = 'Riesgo metabólico aumentado';
            $claseIce  = 'imc-badge-warning';
        } else {
            $nivelIce  = 'alto';
            $estadoIce = 'Riesgo metabólico alto';
            $claseIce  = 'imc-badge-danger';
        }

        // 8. Nivel combinado de grasa abdominal y recomendaciones personalizadas
        $riesgoAbdominal = 'bajo';
        if ($nivelCintura === 'alto' || $nivelIce === 'alto') {
            $riesgoAbdominal = 'alto';
        } elseif ($nivelCintura === 'moderado' || $nivelIce === 'moderado') {
            $riesgoAbdominal = 'moderado';
        }

        $recomendaciones = $this->generarRecomendaciones($nivelImc, $riesgoAbdominal);

        $resultado = [
            'imc'               => $imc,
            'imcPosicion'       => $imcPosicion,
            'categoria'         => $categoria,
            'claseAlerta'       => $claseAlerta,
            'pesoMinSaludable'  => $pesoMinSaludable,
            'pesoMaxSaludable'  => $pesoMaxSaludable,
            'textoPesoRef'      => $textoPesoRef,
            'riesgoCintura'     => $riesgoCintura,
            'referenciaCintura' => $referenciaCintura,
            'claseRiesgo'       => $claseRiesgo,
            'ice'               => $ice,
            'estadoIce'         => $estadoIce,
            'claseIce'          => $claseIce,
            'recomendaciones'   => $recomendaciones,
            'pesoGuardado'      => $pesoPost,
            'alturaGuardada'    => $alturaPost,
            'cinturaGuardada'   => $cinturaPost,
            'sexoGuardado'      => $sexoPost,
        ];

        // Guardar en sesión asociado al usuario activo y redirigir a GET /imc (Post-Redirect-Get)
        session()->set(self::SESSION_KEY, [
            'user_id' => (int) session()->get('loggedUser'),
            'data'    => $resultado,
        ]);

        return redirect()->to(base_url('imc'))
                         ->with('imc_recien_calculado', true);
    }

    /**
     * Borra la última evaluación guardada en sesión para iniciar desde cero.
     */
    public function limpiar()
    {
        session()->remove(self::SESSION_KEY);

        return redirect()->to(base_url('imc'));
    }

    /**
     * Detecta combinaciones físicamente improbables entre altura, peso y cintura.
     */
    private function verificarCoherencia(float $imc, float $iceReal): ?string
    {
        if ($iceReal < 0.28 || $iceReal > 0.85) {
            return 'La proporción entre tu cintura y tu estatura está fuera de los rangos fisiológicos esperados. Verifica que hayas ingresado ambas medidas en centímetros (por ejemplo, altura 170 cm y cintura 85 cm).';
        }

        if ($imc < 18.5 && $iceReal >= 0.60) {
            return 'Los datos ingresados presentan una inconsistencia importante (bajo peso según tu estatura pero un perímetro de cintura muy elevado). Revisa que el peso esté en kilogramos y la cintura en centímetros antes de calcular nuevamente.';
        }

        if ($imc >= 35.0 && $iceReal < 0.42) {
            return 'Los datos ingresados presentan una inconsistencia importante entre tu peso y la medida de tu cintura. Verifica que todas las medidas correspondan a tu estatura y peso actuales.';
        }

        return null;
    }

    /**
     * Mapea el IMC a una posición porcentual alineada con los 4 tramos de la barra visual.
     */
    private function calcularPosicionBarra(float $imc): float
    {
        if ($imc < 18.5) {
            $pos = (($imc - 14.0) / 4.5) * 20;
            return round(max(2.0, min(19.0, $pos)), 1);
        }

        if ($imc < 25.0) {
            $pos = 20 + (($imc - 18.5) / 6.5) * 30;
            return round(max(20.5, min(49.5, $pos)), 1);
        }

        if ($imc < 30.0) {
            $pos = 50 + (($imc - 25.0) / 5.0) * 25;
            return round(max(50.5, min(74.5, $pos)), 1);
        }

        $pos = 75 + (($imc - 30.0) / 12.0) * 25;
        return round(max(75.5, min(98.0, $pos)), 1);
    }

    /**
     * Construye las recomendaciones combinando categoría de IMC y riesgo abdominal.
     */
    private function generarRecomendaciones(string $nivelImc, string $riesgoAbdominal): array
    {
        if ($nivelImc === 'bajo_severo') {
            return [
                'resumen'          => 'Tu IMC indica un déficit de peso importante. Esta condición puede asociarse con pérdida de masa muscular, fatiga o carencias nutricionales, por lo que requiere valoración profesional pronta.',
                'objetivo_titulo'  => 'Recuperar peso con supervisión',
                'objetivo_texto'   => 'Enfócate en alcanzar progresivamente tu rango de peso saludable sin recurrir a ultraprocesados, priorizando densidad nutricional.',
                'alimentacion'     => 'Realiza 4 a 5 comidas diarias equilibradas que incluyan proteínas de calidad (huevo, pollo, pescado, legumbres), carbohidratos complejos y grasas saludables (aguacate, frutos secos, aceite de oliva).',
                'actividad'        => 'Prioriza actividad suave y entrenamiento de fuerza progresivo una vez que un profesional confirme que es seguro para ti, evitando exceso de cardio de alto gasto calórico.',
                'profesional'      => 'Se recomienda agendar una evaluación médica general y acudir a un nutricionista para descartar causas subyacentes y diseñar un plan de ganancia de peso seguro.',
                'prioridad_texto'  => 'Atención prioritaria',
                'prioridad_clase'  => 'imc-badge-danger',
            ];
        }

        if ($nivelImc === 'bajo') {
            return [
                'resumen'          => 'Tu peso se encuentra por debajo del rango saludable para tu estatura. Fortalecer tus reservas de energía y masa muscular te ayudará a mejorar tu bienestar general.',
                'objetivo_titulo'  => 'Subir de peso saludablemente',
                'objetivo_texto'   => 'Apunta a un aumento gradual de peso enfocado en masa muscular y buenos hábitos, evitando subir a base de azúcares o frituras.',
                'alimentacion'     => 'Aumenta tus porciones de forma moderada añadiendo meriendas nutritivas (yogur con avena, frutos secos, pan integral con aguacate o mantequilla de maní) y suficiente proteína en cada comida.',
                'actividad'        => 'Incorpora entrenamiento de fuerza 2 a 3 veces por semana para estimular el desarrollo muscular y el apetito, manteniendo una buena hidratación y descanso.',
                'profesional'      => 'Consultar con un nutricionista te permitirá calcular tu requerimiento calórico exacto y asegurarte de cubrir todas tus vitaminas y minerales.',
                'prioridad_texto'  => 'Consulta recomendada',
                'prioridad_clase'  => 'imc-badge-warning',
            ];
        }

        if ($nivelImc === 'normal') {
            if ($riesgoAbdominal === 'alto' || $riesgoAbdominal === 'moderado') {
                $esAlto = ($riesgoAbdominal === 'alto');
                return [
                    'resumen'          => 'Aunque tu IMC está en rango normal, tu perímetro abdominal y tu índice cintura-estatura muestran acumulación de grasa visceral. Reducir centímetros en la cintura protege directamente tu salud metabólica.',
                    'objetivo_titulo'  => 'Recomposición corporal',
                    'objetivo_texto'   => 'Mantén un peso estable mientras reduces grasa abdominal y fortaleces tu masa muscular.',
                    'alimentacion'     => 'Limita bebidas azucaradas, harinas refinadas y ultraprocesados. Prioriza vegetales en almuerzo y cena, fibra diaria y una fuente de proteína magra en cada comida.',
                    'actividad'        => 'Combina al menos 150 minutos semanales de actividad aeróbica moderada (caminata rápida, bicicleta, trote suave) con 2 a 3 sesiones de entrenamiento de fuerza.',
                    'profesional'      => $esAlto
                        ? 'Es recomendable consultar con un nutricionista y realizar un chequeo médico preventivo (glucosa, colesterol y presión arterial) para evaluar tu perfil metabólico.'
                        : 'Una consulta con un nutricionista te ayudará a ajustar la distribución de macronutrientes para bajar medidas abdominales sin perder masa muscular.',
                    'prioridad_texto'  => $esAlto ? 'Seguimiento recomendado' : 'Ajuste preventivo',
                    'prioridad_clase'  => $esAlto ? 'imc-badge-danger' : 'imc-badge-warning',
                ];
            }

            return [
                'resumen'          => 'Tu peso, tu perímetro abdominal y tu índice cintura-estatura se encuentran dentro de rangos saludables. Esto refleja un buen equilibrio físico y un bajo riesgo metabólico.',
                'objetivo_titulo'  => 'Mantener peso y hábitos',
                'objetivo_texto'   => 'Conserva tu rango actual enfocándote en sostener una alimentación variada, descanso adecuado y constancia en tu actividad física.',
                'alimentacion'     => 'Mantén el equilibrio en tus platos: mitad vegetales y frutas, un cuarto de proteína magra y un cuarto de carbohidratos integrales, cuidando la hidratación diaria.',
                'actividad'        => 'Realiza entre 150 y 300 minutos semanales de ejercicio aeróbico moderado junto con 2 días de fortalecimiento muscular para preservar salud cardiovascular y ósea.',
                'profesional'      => 'Con controles médicos preventivos periódicos es suficiente. Si buscas metas específicas (rendimiento deportivo o definición), un nutricionista puede personalizar tu plan.',
                'prioridad_texto'  => 'Control preventivo',
                'prioridad_clase'  => 'imc-badge-success',
            ];
        }

        if ($nivelImc === 'sobrepeso') {
            if ($riesgoAbdominal === 'bajo') {
                return [
                    'resumen'          => 'Tu IMC marca sobrepeso leve, pero tu cintura y tu índice cintura-estatura están en rango saludable. Esto suele indicar menor acumulación de grasa visceral y, en personas activas, puede deberse a contextura o mayor masa muscular.',
                    'objetivo_titulo'  => 'Control preventivo o ajuste ligero',
                    'objetivo_texto'   => 'Evita subir más de peso y evalúa si deseas un descenso moderado sin recurrir a dietas restrictivas.',
                    'alimentacion'     => 'Cuida el tamaño de las porciones y prioriza alimentos frescos, proteína magra y fibra, reduciendo snacks calóricos y bebidas azucaradas.',
                    'actividad'        => 'Mantén una rutina regular combinando ejercicio cardiovascular y entrenamiento de fuerza para conservar tu masa muscular y sensibilidad a la insulina.',
                    'profesional'      => 'Un nutricionista puede medir tu composición corporal real (porcentaje de grasa y músculo) para confirmar si necesitas bajar peso o simplemente mantenerte.',
                    'prioridad_texto'  => 'Seguimiento opcional',
                    'prioridad_clase'  => 'imc-badge-info',
                ];
            }

            $esAlto = ($riesgoAbdominal === 'alto');
            return [
                'resumen'          => $esAlto
                    ? 'Tu IMC indica sobrepeso acompañado de un perímetro abdominal elevado. Bajar peso y reducir cintura disminuirá notablemente tu riesgo cardiovascular y metabólico.'
                    : 'Tu IMC indica sobrepeso y tu índice cintura-estatura muestra riesgo metabólico aumentado. Es un momento ideal para hacer ajustes sostenibles antes de que el peso siga subiendo.',
                'objetivo_titulo'  => 'Bajar de peso gradualmente',
                'objetivo_texto'   => 'Busca una pérdida progresiva y sostenible (entre 0.5 y 1 kg por semana) enfocada en reducir grasa abdominal.',
                'alimentacion'     => 'Aplica un déficit calórico moderado: llena la mitad de tu plato con vegetales, incluye proteína magra en cada comida, elige carbohidratos integrales y evita refrescos, jugos azucarados y ultraprocesados.',
                'actividad'        => 'Procura acumular 150 a 300 minutos semanales de actividad aeróbica moderada (caminata rápida, natación, ciclismo) más 2 sesiones semanales de fuerza para proteger tu masa muscular.',
                'profesional'      => $esAlto
                    ? 'Se recomienda acudir a un nutricionista para un plan estructurado y hacer un chequeo médico preventivo de presión arterial, glucemia y perfil lipídico.'
                    : 'Acudir a un nutricionista te ayudará a lograr un descenso sostenido sin efecto rebote y adaptado a tus gustos y horarios.',
                'prioridad_texto'  => $esAlto ? 'Consulta recomendada' : 'Atención oportuna',
                'prioridad_clase'  => $esAlto ? 'imc-badge-danger' : 'imc-badge-warning',
            ];
        }

        if ($nivelImc === 'obesidad_1') {
            return [
                'resumen'          => 'Tu IMC corresponde a Obesidad Grado I. Reducir entre un 5% y un 10% de tu peso actual ya produce mejoras significativas en la presión arterial, la energía diaria y los indicadores metabólicos.',
                'objetivo_titulo'  => 'Reducir peso de forma guiada',
                'objetivo_texto'   => 'Establece metas realistas y graduales orientadas a bajar grasa corporal y disminuir tu perímetro abdominal de manera constante.',
                'alimentacion'     => 'Organiza horarios de comida regulares, prioriza alimentos naturales con alto poder saciante (vegetales, legumbres, proteínas magras, frutas enteras) y elimina bebidas azucaradas y ultraprocesados.',
                'actividad'        => 'Inicia o mantén actividad aeróbica de bajo impacto (caminata rápida, bicicleta estática, natación) 4 a 5 días por semana, sumando ejercicios de fuerza progresivos 2 veces por semana.',
                'profesional'      => 'Es muy recomendable consultar con un nutricionista para seguir un plan personalizado y realizar controles médicos preventivos (perfil lipídico, glucosa en ayunas y tensión arterial).',
                'prioridad_texto'  => 'Consulta recomendada',
                'prioridad_clase'  => 'imc-badge-danger',
            ];
        }

        // Obesidad Grado II y Grado III
        return [
            'resumen'          => 'Tu evaluación refleja un grado de obesidad asociado con un riesgo cardiovascular, metabólico y articular elevado. El acompañamiento profesional hace que el proceso sea mucho más seguro y efectivo.',
            'objetivo_titulo'  => 'Descenso de peso supervisado',
            'objetivo_texto'   => 'Prioriza cambios sostenibles supervisados por especialistas; incluso una reducción inicial moderada del 5% al 10% genera beneficios clínicos comprobados.',
            'alimentacion'     => 'Evita dietas extremas por cuenta propia. Enfócate en comidas completas basadas en vegetales, proteínas magras y agua como bebida principal, reduciendo azúcares añadidos y grasas saturadas.',
            'actividad'        => 'Comienza con movimiento diario de bajo impacto para proteger las articulaciones (caminatas cortas progresivas, natación, ejercicios de movilidad o bicicleta reclinada) aumentando la intensidad gradualmente.',
            'profesional'      => 'Se aconseja una evaluación conjunta con médico y nutricionista para revisar tu salud metabólica completa y construir un plan integral adaptado a tu condición.',
            'prioridad_texto'  => 'Atención prioritaria',
            'prioridad_clase'  => 'imc-badge-danger',
        ];
    }
}