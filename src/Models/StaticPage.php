<?php

namespace Greeate\Greeate\Models;

use Greeate\Greeate\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaticPage extends Model
{
    use LogsActivityTrait, SoftDeletes;

    protected $table = 'greeate_static_pages';

    protected $fillable = [
        'slug', 'title', 'content', 'meta_title', 'meta_description',
        'meta_keywords', 'status', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }
}
