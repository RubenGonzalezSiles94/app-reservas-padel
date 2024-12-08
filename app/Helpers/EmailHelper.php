<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailHelper
{
    /**
     * Configuración por defecto para los emails
     */
    private readonly array $defaultConfig;

    /**
     * Constructor con configuración inicial
     */
    public function __construct()
    {
        $this->defaultConfig = [
            'from' => [
                'address' => config('mail.from.address'),
                'name' => config('mail.from.name')
            ],
            'replyTo' => config('mail.reply_to.address'),
        ];
    }

    public static function sendVerifyEmail(User $user)
    {
        $verificationUrl = route('verify.email.token', [
            'token' => $user->verification_token
        ]);

        $expirationTime = now()->addHours(24)->format('Y-m-d H:i:s');

        Mail::send('emails.welcome', [
            'user' => $user, 
            'url' => $verificationUrl,
            'expirationTime' => $expirationTime
        ], function ($message) use ($user) {
            $message->to($user->email, $user->name)
                ->subject('Verifica tu correo electrónico');
        });
    }

    public static function sendResetPasswordEmail(User $user)
    {
        $resetPasswordUrl = route('password.reset.token', [
            'token' => $user->reset_password_token
        ]);

        Mail::send('emails.reset-password', [
            'user' => $user, 
            'url' => $resetPasswordUrl
        ], function ($message) use ($user) {
            $message->to($user->email, $user->name)
                ->subject('Restablece tu contraseña');
        });
    }

    public static function sendDeleteEmail(User $user)
    {
        Mail::send('emails.delete', [
            'user' => $user, 
        ], function ($message) use ($user) {
            $message->to($user->email, $user->name)
                ->subject('Tu cuenta ha sido eliminada');
        });
    }
}
