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
        // Permite letras (con tildes y ñ), espacios y puntos. min_length[8]: Obliga a nombre y apellido.
        'name'    => 'required|regex_match[/^[a-zA-ZÁÉÍÓÚÜÑáéíóúüñ.\s]+$/u]|min_length[8]|max_length[20]',
        
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
            'regex_match' => 'El nombre solo puede contener letras (con acentos y ñ), puntos y espacios.',
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

    // Reglas para Actualizar el Perfil
    public $actualizarPerfil = [
        'name'       => 'required|regex_match[/^[a-zA-ZÁÉÍÓÚÜÑáéíóúüñ.\s]+$/u]|min_length[5]|max_length[50]',
        'password'   => 'permit_empty|min_length[6]|regex_match[/^(?=.*[a-zA-Z])(?=.*\d)/]',
        'weight_kg'  => 'permit_empty|numeric|greater_than[19]|less_than_equal_to[300]',
        'height_cm'  => 'permit_empty|numeric|greater_than[49]|less_than_equal_to[250]',
    ];

    public $actualizarPerfil_errors = [
        'name' => [
            'required'    => 'El nombre es obligatorio.',
            'regex_match' => 'El nombre solo debe contener letras (con acentos y ñ), puntos y espacios.',
            'min_length'  => 'El nombre debe tener al menos 5 caracteres.',
            'max_length'  => 'El nombre no puede superar los 50 caracteres.'
        ],
        'password' => [
            'min_length'  => 'La nueva contraseña debe tener al menos 6 caracteres.',
            'regex_match' => 'La nueva contraseña debe contener letras y números.'
        ],
        'weight_kg' => [
            'numeric'              => 'El peso debe ser un valor numérico.',
            'greater_than'         => 'El peso no puede ser negativo ni inferior que 20kg',
            'less_than_equal_to'   => 'El peso ingresado excede el límite permitido (300kg).'
        ],
        'height_cm' => [
            'numeric'              => 'La altura debe ser un valor numérico.',
            'greater_than'         => 'La altura no puede ser negativa ni inferior que 50 cm.',
            'less_than_equal_to'   => 'La altura ingresada excede el límite permitido (250cm).'
        ]
    ];

    // Reglas para el Cuadro Clinico
    public $catalogoMedico = [
        'name' => 'required|min_length[3]|max_length[100]',
        'type' => 'required|in_list[pathology,allergy]'
    ];

    public $catalogoMedico_errors = [
        'name' => [
            'required'   => 'El nombre de la condición es obligatorio.',
            'min_length' => 'El nombre debe tener al menos 3 caracteres.',
            'max_length' => 'El nombre no puede exceder los 100 caracteres.'
        ],
        'type' => [
            'required' => 'Debes seleccionar una clasificación válida (Patología o Alergia).',
            'in_list'  => 'La clasificación seleccionada ha sido alterada y no es válida.'
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
    
    
    // Reglas para Reporte de Pagos
    public $reportePago = [
        'amount'           => 'required|numeric|greater_than[0]',
        'payment_method'   => 'required|in_list[pago_movil,zelle]',
        'reference_number' => 'required|min_length[4]|max_length[20]'
    ];

    public $reportePago_errors = [
        'amount' => [
            'required' => 'El monto es obligatorio.',
            'numeric'  => 'El monto debe ser numérico.',
            'greater_than' => 'El monto debe ser mayor a 0.'
        ],
        'payment_method' => [
            'required' => 'Debes seleccionar un método de pago.',
            'in_list'  => 'Método de pago no válido.'
        ],
        'reference_number' => [
            'required'   => 'El número de referencia es obligatorio.',
            'min_length' => 'La referencia debe tener al menos los últimos 4 dígitos.'
        ]
    ];
    
    // --------------------------------------------------------------------
    // Reglas para Buscador de Recetas
    // --------------------------------------------------------------------
    public $buscarRecetas = [
        'filtro_ingrediente' => [
            'rules'  => 'permit_empty|regex_match[/^[a-zA-ZÁÉÍÓÚÜÑáéíóúüñ\s]+$/u]',
            'errors' => [
                'regex_match' => 'El buscador de ingredientes solo permite letras y espacios.'
            ]
        ]
    ];

    // --------------------------------------------------------------------
    // Reglas para Racha de Comidas (MealLogs)
    // --------------------------------------------------------------------
    public $registroComida = [
        'meal_date' => [
            'rules'  => 'required|valid_date[Y-m-d]',
            'errors' => [
                'required'   => 'La fecha es obligatoria.',
                'valid_date' => 'La fecha ingresada no es válida.'
            ]
        ],
        'meal_time' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'La hora es obligatoria.'
            ]
        ],
        'meal_type' => [
            'rules'  => 'required|in_list[breakfast,lunch,dinner,snack]',
            'errors' => [
                'required' => 'Selecciona un tipo de comida.',
                'in_list'  => 'El tipo de comida seleccionado no es válido.'
            ]
        ],
        'description' => [
            // Permite letras (con tildes y ñ), números y espacios; bloquea símbolos/caracteres especiales
            'rules'  => 'required|min_length[2]|max_length[255]|regex_match[/^[a-zA-Z0-9ÁÉÍÓÚÜÑáéíóúüñ\s]+$/u]',
            'errors' => [
                'required'    => 'La descripción de la comida es obligatoria.',
                'min_length'  => 'Escribe al menos 2 caracteres en la descripción.',
                'max_length'  => 'La descripción no puede superar los 255 caracteres.',
                'regex_match' => 'La descripción solo puede contener letras, números y espacios (sin símbolos ni caracteres especiales).'
            ]
        ]
    ];
    
    // --------------------------------------------------------------------
    // Reglas para el Newspaper
    // --------------------------------------------------------------------
    public $crearPost = [
        'title' => [
            // Permite letras (con tildes/ñ), números, espacios y signos básicos; evita símbolos raros
            'rules'  => 'required|min_length[5]|max_length[150]|regex_match[/^[a-zA-Z0-9ÁÉÍÓÚÜÑáéíóúüñ\s.,:¡!¿?\-()]+$/u]',
            'errors' => [
                'required'    => 'El título del artículo es obligatorio.',
                'min_length'  => 'El título debe tener al menos 5 caracteres.',
                'max_length'  => 'El título no puede superar los 150 caracteres.',
                'regex_match' => 'El título solo puede contener letras, números, espacios y puntuación básica.'
            ]
        ],
        'category' => [
            'rules'  => 'required|in_list[general,eventos,recetas,novedades]',
            'errors' => [
                'required' => 'Debes seleccionar una categoría.',
                'in_list'  => 'La categoría seleccionada no es válida.'
            ]
        ],
        'contents' => [
            'rules'  => 'required|min_length[15]',
            'errors' => [
                'required'   => 'El contenido de la publicación es obligatorio.',
                'min_length' => 'El contenido debe tener al menos 15 caracteres.'
            ]
        ]
    ];

}