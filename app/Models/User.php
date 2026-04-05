<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use BezhanSalleh\FilamentShield\Contracts\HasFilamentShield;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable implements HasFilamentShield
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles, LogsActivity;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    protected $appends = ['roles_list', 'permissions_list'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'is_active', 'last_login_at'])
            ->logFillable()
            ->setDescriptionForEvent(fn(string $eventName) => "User {$eventName}");
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function getRolesListAttribute(): array
    {
        return $this->roles->pluck('name')->toArray();
    }

    public function getPermissionsListAttribute(): array
    {
        return $this->getAllPermissions()->pluck('name')->toArray();
    }

    public function hasPermissionTo($permission, $guardName = null): bool
    {
        if ($this->hasRole('super_admin')) {
            return true;
        }
        
        return parent::hasPermissionTo($permission, $guardName);
    }
}
