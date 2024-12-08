<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;

class CheckMaintenanceMode
{
    /**
     * Maneja la solicitud entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verifica si el sitio está en modo mantenimiento
        if (Setting::getValue('maintenance_mode') == 1) {
            
            // Si el usuario no tiene rol de super admin, redirige a la vista de mantenimiento
            if (auth()->check() && !auth()->user()->hasRole('super_admin')) {
                return redirect()->route('maintenance');
            }
        }

        // Si no está en mantenimiento, deja que la solicitud siga su curso
        return $next($request);
    }
}
