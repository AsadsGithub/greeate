<?php

namespace Greeate\Greeate\Traits;

use Illuminate\Database\Eloquent\Model;

trait StatusTrait
{
    public function toggleStatus(int $id, string $field = 'status'): Model
    {
        return $this->withTransaction(function () use ($id, $field) {
            $record = $this->findOrFail($id);

            $current = $record->{$field};
            $record->{$field} = is_bool($current) ? ! $current : ($current === 'active' ? 'inactive' : 'active');
            $record->save();

            return $record->fresh($this->relationships);
        });
    }
}
