<?php

namespace Greeate\Greeate\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeviceToken extends Model
{
    protected $table = 'greeate_device_tokens';

    protected $fillable = ['admin_id', 'token', 'platform', 'topics'];

    protected function casts(): array
    {
        return ['topics' => 'array'];
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
}
