<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            [
                'key' => 'name',
                'value' => 'Mi Sitio Web',
                'type' => 'string',
                'description' => 'El nombre de tu sitio web.',
            ],
            [
                'key' => 'description',
                'value' => 'La mejor página para tus necesidades.',
                'type' => 'string',
                'description' => 'La descripción de tu sitio web.',
            ],
            [
                'key' => 'logo',
                'value' => 'logos/logo.png',
                'type' => 'image',
                'description' => 'El logo de tu sitio web.',
            ],
            [
                'key' => 'email',
                'value' => 'admin@misitio.com',
                'type' => 'string',
                'description' => 'El correo electrónico de contacto de tu sitio web.',
            ],
            [
                'key' => 'phone',
                'value' => '+34 123 456 789',
                'type' => 'string',
                'description' => 'El teléfono de contacto de tu sitio web.',
            ],
            [
                'key' => 'address',
                'value' => 'Calle Ejemplo, 123, Ciudad, País',
                'type' => 'string',
                'description' => 'La dirección de tu sitio web.',
            ],
            [
                'key' => 'maintenance_mode',
                'value' => '0',
                'type' => 'boolean',
                'description' => 'Modo mantenimiento de tu sitio web.',
            ],
            [
                'key' => 'days_active',
                'value' => '0',
                'type' => 'boolean',
                'description' => 'Activar/Desactivar el límite de días para reservar.',
            ],
            [
                'key' => 'days_enabled',
                'value' => '3',
                'type' => 'integer',
                'description' => 'Días habilitados para la reserva de la pista.',
            ],
            [
                'key' => 'max_reservation_active',
                'value' => '0',
                'type' => 'boolean',
                'description' => 'Activar/Desactivar el límite de reservas por usuario.',
            ],
            [
                'key' => 'max_reservation',
                'value' => '3',
                'type' => 'integer',
                'description' => 'Máximo de reservas activas por usuario.',
            ],
        ];

        // Insertar los datos en la tabla settings
        DB::table('settings')->insert($settings);
    }
}
