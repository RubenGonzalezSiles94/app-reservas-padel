<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\CronLog;
use App\Models\Reservation;
use Illuminate\Console\Command;

class ActualizarEstadoReservas extends Command
{
    protected $signature = 'reservas:actualizar-estados';
    protected $description = 'Actualiza el estado de las reservas a "Completado" si ya han pasado';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $now = Carbon::now();

        $this->info("Ultima actualizacion: {$now->format('d-m-Y H:i:s')}");

        $reservations = Reservation::join('schedules', 'reservations.schedule_id', '=', 'schedules.id')
            ->where('reservations.status', 'Reservado')
            ->whereRaw("CONCAT(reservations.reservation_date, ' ', schedules.end_time) <= ?", [$now->format('Y-m-d H:i:s')])
            ->select('reservations.id', 'reservations.status')
            ->get();

        foreach ($reservations as $reservation) {
            $previous_status = $reservation->status;
            $reservation->status = 'Completado';
            $reservation->save();

            CronLog::create([
                'fecha_actualizacion' => now(),
                'tipo_actualizacion' => 'update',
                'reserva_id' => $reservation->id,
                'estado_anterior' => $previous_status,
                'estado_nuevo' => $reservation->status,
                'mensaje' => 'CRON',
            ]);
        }
    }
}
