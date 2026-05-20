<?php

namespace Greeate\Greeate\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class GreeateNotification extends Model
{
    protected $table = 'greeate_notifications';

    protected $fillable = [
        'notifiable_type', 'notifiable_id', 'type', 'title', 'body',
        'data', 'channel', 'read_at', 'sent_at',
    ];

    protected function casts(): array
    {
        return [
            'data' => 'array',
            'read_at' => 'datetime',
            'sent_at' => 'datetime',
        ];
    }

    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }

    public function markAsRead(): void
    {
        $this->update(['read_at' => now()]);
    }
}
