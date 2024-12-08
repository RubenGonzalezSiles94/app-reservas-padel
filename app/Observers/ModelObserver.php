<?php

namespace App\Observers;

use App\Models\ChangeLog;

class ModelObserver
{
    public function created($model)
    {
        ChangeLog::create([
            'user_id' => auth()->id(),
            'model_type' => get_class($model),
            'action' => 'create',
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
        ]);
    }

    public function updated($model)
    {
        ChangeLog::create([
            'user_id' => auth()->id(),
            'model_type' => get_class($model),
            'action' => 'update',
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
        ]);
    }

    public function deleted($model)
    {
        ChangeLog::create([
            'user_id' => auth()->id(),
            'model_type' => get_class($model),
            'action' => 'delete',
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
        ]);
    }
}
