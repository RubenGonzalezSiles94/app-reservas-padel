<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CronLog extends Model
{
    protected $table = 'cron_logs';

    protected $fillable = [
        'fecha_actualizacion',
        'tipo_actualizacion',
        'reserva_id',
        'estado_anterior',
        'estado_nuevo',
        'mensaje',
    ];

    /**
     * Relación con el modelo Reservation.
     */
    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reserva_id');
    }
}
