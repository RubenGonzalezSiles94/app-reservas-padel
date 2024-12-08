<?php

namespace App\Mail;

use App\Models\Setting;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
{
    use SerializesModels;

    /**
     * Crear una nueva instancia de mensaje.
     *
     * @return void
     */
    public function __construct()
    {
        // Puedes pasar datos aquí si es necesario
    }

    /**
     * Construir el mensaje.
     *
     * @return $this
     */
    public function build()
    {

        return $this->from(Setting::getValue('email'))  // Establecer el remitente dinámicamente
                    ->subject('Correo de prueba')
                    ->view('emails.test');  // Nombre 
    }
}
