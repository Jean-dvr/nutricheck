<?php

namespace App\Controllers;

class Imc extends BaseController
{
    public function index()
    {
        return view('imc/index');
    }

    public function calcular()
    {
        // 1. Delegamos la validación al archivo Validation.php
        if (!$this->validate('calculoImc')) {
            // Si falla, recargamos la vista pasándole los errores y los datos que intentó enviar
            $data = [
                'validation'      => $this->validator,
                'pesoGuardado'    => $this->request->getPost('peso'),
                'alturaGuardada'  => $this->request->getPost('altura'),
                'cinturaGuardada' => $this->request->getPost('cintura'),
                'sexoGuardado'    => $this->request->getPost('sexo')
            ];
            return view('imc/index', $data);
        }

        // 2. Si pasa la validación, trabajamos con datos 100% seguros
        $peso = $this->request->getPost('peso');
        $alturaCm = $this->request->getPost('altura');
        $cintura = $this->request->getPost('cintura');
        $sexo = $this->request->getPost('sexo');

        // 3. Cálculo Matemático
        $alturaMetros = $alturaCm / 100;
        $imc = round($peso / ($alturaMetros * $alturaMetros), 2);

        // 4. Evaluar Categoría
        if ($imc < 18.5) {
            $categoria = 'Bajo peso';
            $claseAlerta = 'alert-warning';
        } elseif ($imc >= 18.5 && $imc <= 24.9) {
            $categoria = 'Peso normal';
            $claseAlerta = 'alert-success';
        } elseif ($imc >= 25.0 && $imc <= 29.9) {
            $categoria = 'Sobrepeso';
            $claseAlerta = 'alert-warning';
        } else {
            $categoria = 'Obesidad';
            $claseAlerta = 'alert-danger';
        }

        // 5. Evaluar Riesgo Metabólico (Cintura)
        $riesgoCintura = 'Riesgo bajo/normal';
        $claseRiesgo = 'text-success';

        if ($sexo === 'M') {
            if ($cintura > 102) {
                $riesgoCintura = 'Riesgo cardiovascular sustancialmente incrementado';
                $claseRiesgo = 'text-danger font-weight-bold';
            } elseif ($cintura >= 94) {
                $riesgoCintura = 'Riesgo cardiovascular incrementado';
                $claseRiesgo = 'text-warning font-weight-bold';
            }
        } elseif ($sexo === 'F') {
            if ($cintura > 88) {
                $riesgoCintura = 'Riesgo cardiovascular sustancialmente incrementado';
                $claseRiesgo = 'text-danger font-weight-bold';
            } elseif ($cintura >= 80) {
                $riesgoCintura = 'Riesgo cardiovascular incrementado';
                $claseRiesgo = 'text-warning font-weight-bold';
            }
        }

        // 6. Empaquetar y enviar a la vista
        $data = [
            'imc'             => $imc,
            'categoria'       => $categoria,
            'claseAlerta'     => $claseAlerta,
            'riesgoCintura'   => $riesgoCintura,
            'claseRiesgo'     => $claseRiesgo,
            'pesoGuardado'    => $peso,
            'alturaGuardada'  => $alturaCm,
            'cinturaGuardada' => $cintura,
            'sexoGuardado'    => $sexo
        ];

        return view('imc/index', $data);
    }
}