<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DniOrNie implements Rule
{
    /**
     * Determine if the given value is valid.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Validar el formato de DNI (8 números seguidos de una letra)
        if (preg_match('/^\d{8}[A-Za-z]$/', $value)) {
            return $this->validateDni($value);
        }

        // Validar el formato de NIE (letra X/Y/Z seguida de 7 números y una letra)
        if (preg_match('/^[XYZ]\d{7}[A-Za-z]$/', $value)) {
            return $this->validateNie($value);
        }

        return false;
    }

    /**
     * Validar un DNI español.
     *
     * @param  string  $value
     * @return bool
     */
    private function validateDni($value)
    {
        // Extraemos los 8 primeros dígitos
        $dniNumber = substr($value, 0, 8);
        // Extraemos la letra
        $dniLetter = strtoupper(substr($value, 8, 1));

        // Letras válidas según los 8 primeros números
        $letters = 'TRWAGMYFPDXBNJZSQVHLCKE';
        $calculatedLetter = $letters[$dniNumber % 23];

        return $dniLetter === $calculatedLetter;
    }

    /**
     * Validar un NIE español.
     *
     * @param  string  $value
     * @return bool
     */
    private function validateNie($value)
    {
        // Reemplazar la primera letra del NIE por su valor numérico
        $letterMapping = [
            'X' => 0,
            'Y' => 1,
            'Z' => 2,
        ];

        // Obtener la letra inicial y el número de 7 dígitos
        $firstLetter = strtoupper(substr($value, 0, 1));
        $nieNumber = $letterMapping[$firstLetter] . substr($value, 1, 7); // Convertimos el NIE a un número comparable

        // Comprobar que la letra final sea válida
        $nieLetter = strtoupper(substr($value, 8, 1));

        // El cálculo de la letra se realiza igual que en el DNI
        $letters = 'TRWAGMYFPDXBNJZSQVHLCKE';
        $calculatedLetter = $letters[$nieNumber % 23];

        return $nieLetter === $calculatedLetter;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El DNI o NIE proporcionado no es válido.';
    }
}
