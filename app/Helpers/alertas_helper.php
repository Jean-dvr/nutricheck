<?php

/**
 * Retorna el mensaje de error de un campo específico tras fallar la validación.
 *
 * @param \CodeIgniter\Validation\Validation $validation El objeto de validación
 * @param string $field El nombre del input/campo a verificar
 * @return string|false El mensaje de error, o false si no hay errores
 */
if (!function_exists('display_error')) {
    
    function display_error($validation, $field) {
        
        // Operador Ternario: ¿Tiene error? (?) devuelve el error : (:) si no, devuelve false
        return $validation->hasError($field) ? $validation->getError($field) : false;
        
    }
}
?>