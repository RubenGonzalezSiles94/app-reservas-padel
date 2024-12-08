<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';
    protected $fillable = ['key', 'value', 'description', 'type'];
    public $timestamps = false;

    public static function getValue(string $key): ?string
    {
        return static::where('key', $key)->value('value');
    }

    public static function getBoolValue(string $key): bool
    {
        return (bool) static::where('key', $key)->value('value');
    }

    public function isToggleSetting(): bool
    {
        return in_array($this->key, ['days_active', 'max_reservation_active']);
    }
    
    public static function isActiveLimitDays()
    {
        return static::getBoolValue('days_active');
    }

    public static function isMaxReservationActive()
    {
        return static::getBoolValue('max_reservation_active');
    }

    public static function getMaxReservation()
    {
        return static::getValue('max_reservation');
    }

    public static function getLimitDays()
    {
        return static::getValue('days_enabled');
    }
}
