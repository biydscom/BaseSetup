<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Role extends SpatieRole
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'guard_name',
        'description',
        'is_system',
    ];

    protected $casts = [
        'is_system' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'guard_name', 'description', 'is_system'])
            ->logFillable()
            ->setDescriptionForEvent(fn(string $eventName) => "Role {$eventName}");
    }
}
