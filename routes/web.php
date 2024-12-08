<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\CheckMaintenanceMode;

// Ruta para la página de mantenimiento
Route::view('/maintenance', 'maintenance')->name('maintenance');

Route::middleware([CheckMaintenanceMode::class])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::get('/reservas', function () {
        return view('reservas');
    })->middleware(['auth', 'verified'])->name('reservas');

    // Rutas de perfil, protegidas por autenticación
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

require __DIR__.'/auth.php';
