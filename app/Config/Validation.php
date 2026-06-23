<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules para nutricheck
    // --------------------------------------------------------------------

    // 1. Grupo: Registro
    public $registro = [
        // alpha_space: Solo letras y espacios. min_length[8]: Obliga a nombre y apellido.
        'name'    => 'required|alpha_space|min_length[8]|max_length[20]',
        
        // valid_email ya verifica el @ y el formato de dominio correctamente.
        'email'    => 'required|valid_email|is_unique[users.email]',
        
        // regex_match: Exige obligatoriamente al menos una letra y un número.
        'password'  => 'required|min_length[6]|regex_match[/^(?=.*[a-zA-Z])(?=.*\d)/]',
        
        'cpassword' => 'required|matches[password]' 
    ];

    // Mensajes personalizados para el Registro
    public $registro_errors = [
        'name' => [
            'required'    => 'El nombre y apellido son obligatorios.',
            'alpha_space' => 'El nombre solo puede contener letras y espacios.',
            'min_length'  => 'Por favor ingresa tu nombre y apellido (mínimo 8 caracteres).',
            'max_length'  => 'El nombre no puede exceder los 20 caracteres.'
        ],
        'email' => [
            'required'    => 'El correo electrónico es obligatorio.',
            'valid_email' => 'Debes ingresar un formato de correo válido (ejemplo@correo.com).',
            'is_unique'   => 'Este correo ya está registrado. Por favor, inicia sesión.'
        ],
        'password' => [
            'required'    => 'La contraseña es obligatoria.',
            'min_length'  => 'Por seguridad, la contraseña debe tener al menos 6 caracteres.',
            'regex_match' => 'La contraseña debe contener al menos una letra y un número.'
        ],
        'cpassword' => [
            'required' => 'Debes confirmar tu contraseña.',
            'matches'  => 'Las contraseñas no coinciden.'
        ]

    ];

    // 2. Grupo: Login
    public $login = [
        'email'   => 'required|valid_email',
        'password' => 'required|min_length[6]'
    ];

    // Mensajes personalizados para el Login
    public $login_errors = [
        'email' => [
            'required'    => 'El correo electrónico es obligatorio.',
            'valid_email' => 'Debes ingresar un formato de correo válido.'
        ],
        'password' => [
            'required'   => 'La contraseña es obligatoria.',
            'min_length' => 'La contraseña debe tener al menos 6 caracteres.'
        ]
    ];

    // 3. Grupo IMC

    public $calculoImc = [
        'sexo'    => 'required|in_list[M,F]',
        'altura'  => 'required|numeric|greater_than_equal_to[50]|less_than_equal_to[250]',
        'peso'    => 'required|numeric|greater_than_equal_to[10]|less_than_equal_to[300]',
        'cintura' => 'required|numeric|greater_than_equal_to[30]|less_than_equal_to[200]'
    ];

    public $calculoImc_errors = [
        'sexo' => [
            'required' => 'Debes seleccionar tu sexo biológico.',
            'in_list'  => 'El sexo seleccionado no es válido.'
        ],
        'altura' => [
            'required'              => 'La altura es obligatoria.',
            'numeric'               => 'La altura debe ser un número.',
            'greater_than_equal_to' => 'La altura ingresada es demasiado baja.',
            'less_than_equal_to'    => 'La altura excede el límite realista (250 cm).'
        ],
        'peso' => [
            'required'              => 'El peso es obligatorio.',
            'numeric'               => 'El peso debe ser un número.',
            'greater_than_equal_to' => 'El peso ingresado es demasiado bajo.',
            'less_than_equal_to'    => 'El peso excede el límite realista (300 kg).'
        ],
        'cintura' => [
            'required'              => 'La medida de la cintura es obligatoria.',
            'numeric'               => 'La cintura debe ser un número.',
            'greater_than_equal_to' => 'La cintura es demasiado baja.',
            'less_than_equal_to'    => 'La cintura excede el límite realista (200 cm).'
        ]
    ];
    
    // Reglas para el Newspaper
    public $crearPost = [
        'title'    => 'required|min_length[5]|max_length[150]',
        'category' => 'required|in_list[general,eventos,recetas]',
        'contents' => 'required|min_length[15]'
    ];


}
