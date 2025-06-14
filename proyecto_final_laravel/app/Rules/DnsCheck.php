<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DnsCheck implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Obtener el dominio del correo electrónico
        $domain = substr(strrchr($value, "@"), 1);

        // Verificar si el dominio tiene un registro MX (Mail Exchange)
       
        if (!checkdnsrr($domain, "MX")) {
            // Si no tiene un servidor de correo válido, fallamos la validación
            $fail("El dominio del correo electrónico no tiene un servidor de correo válido.");
        }
    }
}

