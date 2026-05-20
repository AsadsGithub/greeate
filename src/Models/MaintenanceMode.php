<?php

namespace Greeate\Greeate\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceMode extends Model
{
    protected $table = 'greeate_maintenance_modes';

    protected $fillable = [
        'is_enabled', 'title', 'description', 'starts_at', 'ends_at',
        'allowed_roles', 'ip_whitelist', 'show_countdown',
    ];

    protected function casts(): array
    {
        return [
            'is_enabled' => 'boolean',
            'show_countdown' => 'boolean',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'allowed_roles' => 'array',
            'ip_whitelist' => 'array',
        ];
    }
}
