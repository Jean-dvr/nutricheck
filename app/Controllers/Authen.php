<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\UsuarioModel;

use App\Libraries\Hash;

class Authen extends BaseController{

/**
     * Constructor del controlador Authen.
     * Carga los helpers necesarios para todas las funciones de este archivo.
     */
    public function __construct() {
        // Asumo que 'alertas' es un helper personalizado tuyo.
        helper(['alertas', 'url', 'form']); 
    }

    /**
     * Muestra la vista principal del inicio de sesión.
     * Ruta: GET /login
     */

    public function index(){

        return view('authen/login');
    }

    /**
     * Muestra la vista del formulario de registro de nuevos usuarios.
     * Ruta: GET /register
     */
    
    public function register(){


        return view('authen/register');
    }


   /**
     * Procesa los datos del formulario de registro.
     * Valida la información, encripta la contraseña e inserta el registro en la base de datos.
     * Ruta: POST /register/guardar
     */
    public function guardar() {
        
        // 1. Validación (Manejada desde app/Config/Validation.php)
        if (!$this->validate('registro')) {
            return view('authen/register', ['validation' => $this->validator]);
        }
        
        // 2. Instanciamos el modelo de base de datos
        $usuarioModel = new UsuarioModel(); 

        // 3. Preparamos e insertamos en un solo paso (El Hash se aplica en línea)
        $insercion = $usuarioModel->insert([
            'nombre'   => $this->request->getPost('nombre'),
            'correo'   => $this->request->getPost('correo'),
            'password' => Hash::make($this->request->getPost('password'))
        ]);

        // 4. Evaluamos si ocurrió un error interno en la Base de Datos
        if (!$insercion) {
            return redirect()->to(base_url('register'))->withInput()->with('fail', 'Ocurrió un error interno al guardar el usuario. Intenta de nuevo.');
        } 
        
        return redirect()->to(base_url('login'))->with('success', '¡Registro exitoso! Ya puedes iniciar sesión.');
    }
    
    /**
     * Procesa la autenticación del usuario.
     * Valida credenciales, comprueba el Hash y genera las variables de sesión globales.
     * Ruta: POST /login/ingresar
     */

    public function ingresar() {

        // 1. Validación de formato de campos (Manejada desde Validation.php)

       if (!$this->validate('login')) 
        {
            return view('authen/login', ['validation' => $this->validator]);
        }

        // 2. Atrapamos los datos limpios enviados por el usuario
        $correo   = $this->request->getPost('correo');
        $password = $this->request->getPost('password');

        // 3. Buscamos al usuario en la base de datos por su correo
        $usuarioModel = new UsuarioModel();

        $usuario = $usuarioModel->where('correo', $correo)->first(); 

        // 4. EL PORTERO: Verificamos si el correo no existe
        if (!$usuario) {
            return redirect()->to(base_url('login'))->withInput()->with('fail', 
            'Este correo no se encuentra registrado. Por favor, regístrate.');
        }

        // 5. Verificamos la contraseña usando la función de Hash personalizada

        if (!Hash::check($password, $usuario['password'])) {
            return redirect()->to(base_url('login'))->withInput()->with('fail', 
            'Contraseña incorrecta. Intenta de nuevo.');
        }

        // 6. Iniciamos sesión y guardamos datos esenciales en la sesión
        session()->set([
            'loggedUser' => $usuario['id_usuario'], //
            'nombre'     => $usuario['nombre'],  // Guardamos el nombre para la interfaz
            'isLoggedIn' => true                 // Bandera explícita de seguridad
        ]);
        
        return redirect()->to(base_url('dashboard'));
    }

}



