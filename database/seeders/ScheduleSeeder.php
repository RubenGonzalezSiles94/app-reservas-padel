<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        // Array asociativo de días
        $dias = [
            1 => 'Lunes',
            2 => 'Martes',
            3 => 'Miércoles',
            4 => 'Jueves',
            5 => 'Viernes',
            6 => 'Sábado',
            7 => 'Domingo'
        ];

        // Horarios de Lunes a Viernes (16:00 - 22:00 con intervalos de 1.5 horas)
        $timeSlots = [
            ['start' => '16:00:00', 'end' => '17:30:00'],
            ['start' => '17:30:00', 'end' => '19:00:00'],
            ['start' => '19:00:00', 'end' => '20:30:00'],
            ['start' => '20:30:00', 'end' => '22:00:00']
        ];

        // Horarios de Lunes a Viernes
        for ($day = 1; $day <= 5; $day++) {  // Lunes a Viernes
            foreach ($timeSlots as $slot) {
                Schedule::create([
                    'day_of_week' => $dias[$day],
                    'start_time' => $slot['start'],
                    'end_time' => $slot['end'],
                    'is_active' => true, // Considera cambiar el nombre de esta columna si es necesario
                ]);
            }
        }

        // Horarios Sábado (9:00 - 14:00 y 16:00 - 22:00 con intervalos de 1.5 horas)
        $saturdayTimeSlots = [
            ['start' => '09:00:00', 'end' => '10:30:00'],
            ['start' => '10:30:00', 'end' => '12:00:00'],
            ['start' => '12:00:00', 'end' => '13:30:00'],
            ['start' => '16:00:00', 'end' => '17:30:00'],
            ['start' => '17:30:00', 'end' => '19:00:00'],
            ['start' => '19:00:00', 'end' => '20:30:00'],
            ['start' => '20:30:00', 'end' => '22:00:00']
        ];

        foreach ($saturdayTimeSlots as $slot) {
            Schedule::create([
                'day_of_week' => $dias[6], // 'Sábado'
                'start_time' => $slot['start'],
                'end_time' => $slot['end'],
                'is_active' => true
            ]);
        }

        // Horarios Domingo (9:00 - 14:00 con intervalos de 1.5 horas)
        $sundayTimeSlots = [
            ['start' => '09:00:00', 'end' => '10:30:00'],
            ['start' => '10:30:00', 'end' => '12:00:00'],
            ['start' => '12:00:00', 'end' => '13:30:00']
        ];

        foreach ($sundayTimeSlots as $slot) {
            Schedule::create([
                'day_of_week' => $dias[7], // 'Domingo'
                'start_time' => $slot['start'],
                'end_time' => $slot['end'],
                'is_active' => true
            ]);
        }
    }
}
