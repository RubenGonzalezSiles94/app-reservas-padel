<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Rules\DniOrNie;
use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Helpers\EmailHelper;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'cif' => ['required', 'string', new DniOrNie, 'unique:users,cif,' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => '',
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'cif' => $request->cif,
            'password' => Hash::make($request->password),
            'status' => true,
        ]);

        
        $user->verification_token = Str::random(64);
        $user->save();
        
        EmailHelper::sendVerifyEmail($user);
        
        event(new Registered($user));


        return redirect()->route('login')
        ->with('success', 'Se ha enviado un correo para verificar tu cuenta.');
    }
}
