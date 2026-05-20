<?php

namespace Greeate\Greeate\Models;

use Greeate\Greeate\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
    use LogsActivityTrait, SoftDeletes;

    protected $table = 'greeate_languages';

    protected $fillable = [
        'name', 'code', 'native_name', 'direction', 'flag',
        'is_default', 'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_default' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function isRtl(): bool
    {
        return $this->direction === 'rtl';
    }
}
