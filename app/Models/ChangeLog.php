<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChangeLog extends Model
{
    protected $table = 'change_logs';

    protected $fillable = [
        'user_id',
        'model_type',
        'action',
        'ip_address',
        'user_agent',
        'created_at',
    ];

    /**
     * Relación con el modelo User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
