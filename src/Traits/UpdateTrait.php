<?php

namespace Greeate\Greeate\Traits;

use Illuminate\Database\Eloquent\Model;

trait UpdateTrait
{
    public function update(int $id, array $data): Model
    {
        return $this->withTransaction(function () use ($id, $data) {
            $record = $this->findOrFail($id);
            $data = $this->beforeUpdate($record, $data);
            $record->update($data);
            $this->afterUpdate($record, $data);

            return $record->fresh($this->relationships);
        });
    }

    public function bulkUpdate(array $ids, array $data): int
    {
        return $this->withTransaction(function () use ($ids, $data) {
            return $this->model->newQuery()->whereIn('id', $ids)->update($data);
        });
    }

    protected function beforeUpdate(Model $record, array $data): array
    {
        return $data;
    }

    protected function afterUpdate(Model $record, array $data): void {}
}
