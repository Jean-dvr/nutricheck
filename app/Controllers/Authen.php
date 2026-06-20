<?php 
namespace App\Controllers;

use App\Models\UserModel;

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
        $userModel = new UserModel(); 

        // 3. Preparamos e insertamos en un solo paso (El Hash se aplica en línea)
        $insercion = $userModel->insert([
            'name'   => trim($this->request->getPost('name')),
            'email'   => trim($this->request->getPost('email')),
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
        $email   = trim($this->request->getPost('email'));
        $password = $this->request->getPost('password');

        // 3. Buscamos al usuario en la base de datos por su correo
        $userModel = new UserModel();

        $user = $userModel->where('email', $email)->first(); 

        // 4. EL PORTERO: Verificamos si el correo no existe
        if (!$user) {
            return redirect()->to(base_url('login'))->withInput()->with('fail', 
            'Este correo no se encuentra registrado. Por favor, regístrate.');
        }

        // 5. Verificamos la contraseña usando la función de Hash personalizada

        if (!Hash::check($password, $user['password'])) {
            return redirect()->to(base_url('login'))->withInput()->with('fail', 
            'Contraseña incorrecta. Intenta de nuevo.');
        }

        // 6. Iniciamos sesión y guardamos datos esenciales en la sesión
        session()->set([
            'loggedUser' => $user['id'], //
            'name'     => $user['name'],  // Guardamos el nombre para la interfaz
            'rol'       => $user['rol'], // Guardamos el rol para el control de acceso
            'isLoggedIn' => true                 // Bandera explícita de seguridad
        ]);
        
        return redirect()->to(base_url('dashboard'));
    }

    /**
     * Cierra la sesión del usuario.
     * Ruta: GET /logout
     */
    public function logout() 
    {
        // Destruimos la sesión completa por seguridad
        session()->destroy();
        
        // Redirigimos al login
        return redirect()->to(base_url('login'))->with('success', 'Has cerrado sesión exitosamente. ¡Hasta pronto!');
    }



}



