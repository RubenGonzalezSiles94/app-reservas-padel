<?php

namespace App\Mail;

use App\Models\Setting;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use SerializesModels;
    public $user;

    /**
     * Crear una nueva instancia de mensaje.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Construir el mensaje.
     *
     * @return $this
     */
    public function build()
    {

        return $this->from(Setting::getValue('email'))
                    ->subject('Email de bienvenida')
                    ->with(['user' => $this->user])
                    ->view('emails.welcome');
    }
}
