<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'schedule_id',
        'reservation_date',
        'status'
    ];

    protected $casts = [
        'reservation_date' => 'datetime'
    ];

    // Relación con usuario
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relación con horario
    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function scopeReservedOnDate($query, $scheduleId, $date)
    {
        return $query->where('schedule_id', $scheduleId)
                     ->whereDate('reservation_date', $date)
                     ->where('status', 'Reservado');
    }
}
