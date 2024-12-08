<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GestionController extends Controller
{
    protected $limiter;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    public function verifyEmail(Request $request, $token)
    {
        // Limitar intentos por IP
        $key = 'verify-email-'.$request->ip();
        if ($this->limiter->tooManyAttempts($key, 5)) { // 5 intentos máximo
            return redirect()->route('login')
                ->with('error', 'Demasiados intentos. Por favor, espera unos minutos.');
        }
        
        $this->limiter->hit($key);

        // Buscar usuario con el token de verificación
        $user = User::where('verification_token', $token)->first();

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'El enlace de verificación no es válido.');
        }

        try {
            DB::transaction(function () use ($user) {
                $user->email_verified_at = now();
                $user->verification_token = null;
                $user->save();
            });

            Auth::login($user);
            return redirect(route('dashboard', absolute: false))->with('success', '¡Su cuenta se ha verificado correctamente!');

        } catch (\Exception $e) {
            report($e);
            return redirect()->route('login')
                ->with('error', 'Ha ocurrido un error al verificar tu correo electrónico.');
        }
    }
}
