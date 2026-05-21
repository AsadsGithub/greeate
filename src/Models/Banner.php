<?php

namespace Greeate\Greeate\Models;

use Greeate\Greeate\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use LogsActivity, SoftDeletes;

    protected $table = 'greeate_banners';

    protected $fillable = [
        'title', 'subtitle', 'image', 'link', 'sort_order', 'status',
        'starts_at', 'ends_at',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'sort_order' => 'integer',
        ];
    }
}
