<?php

namespace Greeate\Greeate\Models;

use Greeate\Greeate\Traits\LogsActivityTrait;
use Greeate\Greeate\Database\Factories\AdminFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles, LogsActivityTrait, Notifiable, SoftDeletes;

    protected $table = 'greeate_admins';

    protected $guard_name = 'web';

    protected $fillable = [
        'uuid', 'name', 'email', 'phone', 'avatar', 'password',
        'status', 'language', 'timezone', 'last_login_at', 'last_login_ip',
        'email_verified_at', 'two_factor_secret', 'two_factor_recovery_codes',
        'two_factor_confirmed_at',
    ];

    protected $hidden = ['password', 'remember_token', 'two_factor_secret', 'two_factor_recovery_codes'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'two_factor_confirmed_at' => 'datetime',
            'password' => 'hashed',
            'status' => 'string',
        ];
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole(config('greeate.super_admin_role', 'super-admin'));
    }

    protected static function newFactory(): AdminFactory
    {
        return AdminFactory::new();
    }
}
