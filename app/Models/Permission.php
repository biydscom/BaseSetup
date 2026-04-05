<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Permission extends SpatiePermission
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'guard_name',
        'group',
        'description',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'guard_name', 'group', 'description'])
            ->logFillable()
            ->setDescriptionForEvent(fn(string $eventName) => "Permission {$eventName}");
    }
}
