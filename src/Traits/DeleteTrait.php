<?php

namespace Greeate\Greeate\Traits;

use Illuminate\Database\Eloquent\Model;

trait DeleteTrait
{
    public function delete(int $id): bool
    {
        return $this->withTransaction(function () use ($id) {
            $record = $this->findOrFail($id);
            $this->beforeDelete($record);
            $deleted = $record->delete();
            $this->afterDelete($record);

            return $deleted;
        });
    }

    public function restore(int $id): bool
    {
        return $this->withTransaction(function () use ($id) {
            $record = $this->model->newQuery()->withTrashed()->findOrFail($id);

            return $record->restore();
        });
    }

    public function forceDelete(int $id): bool
    {
        return $this->withTransaction(function () use ($id) {
            $record = $this->model->newQuery()->withTrashed()->findOrFail($id);

            return $record->forceDelete();
        });
    }

    public function bulkDelete(array $ids): int
    {
        return $this->withTransaction(function () use ($ids) {
            return $this->model->newQuery()->whereIn('id', $ids)->delete();
        });
    }

    protected function beforeDelete(Model $record): void {}

    protected function afterDelete(Model $record): void {}
}
