<?php

namespace Greeate\Greeate\Models;

use Greeate\Greeate\Traits\HasTranslations;
use Greeate\Greeate\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Broadcast extends Model
{
    use HasTranslations, LogsActivity, SoftDeletes;

    protected $table = 'greeate_broadcasts';

    protected $fillable = [
        'title', 'body', 'target_type', 'target_value',
        'scheduled_at', 'sent_at', 'status', 'created_by',
    ];

    protected function casts(): array
    {
        return [
            'title' => 'array',
            'body' => 'array',
            'scheduled_at' => 'datetime',
            'sent_at' => 'datetime',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
