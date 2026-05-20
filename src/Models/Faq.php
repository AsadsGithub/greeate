<?php

namespace Greeate\Greeate\Models;

use Greeate\Greeate\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use LogsActivityTrait, SoftDeletes;

    protected $table = 'greeate_faqs';

    protected $fillable = [
        'question', 'answer', 'sort_order', 'status', 'category',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }
}
