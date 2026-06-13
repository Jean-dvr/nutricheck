<?php
namespace App\Libraries;

/**
 * Librería de Criptografía.
 * Centraliza la lógica de encriptación y verificación de contraseñas.
 */
class Hash
{
    /**
     * Encripta una contraseña utilizando el algoritmo más fuerte 
     * disponible en la versión actual de PHP.
     */
    public static function make(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Verifica si una contraseña coincide con su versión encriptada.
     */
    public static function check($entered_password, $db_password)
    {
        // Retornamos directamente el true o false que genera password_verify
        return password_verify($entered_password, $db_password);
    }
}
?>