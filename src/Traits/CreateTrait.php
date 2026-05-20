<?php

namespace Greeate\Greeate\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Throwable;

trait CreateTrait
{
    public function create(array $data): Model
    {
        return $this->withTransaction(function () use ($data) {
            $data = $this->beforeCreate($data);
            $record = $this->model->create($data);
            $this->afterCreate($record, $data);

            return $record->fresh($this->relationships);
        });
    }

    protected function beforeCreate(array $data): array
    {
        return $data;
    }

    protected function afterCreate(Model $record, array $data): void {}

    protected function withTransaction(callable $callback): mixed
    {
        try {
            DB::beginTransaction();
            $result = $callback();
            DB::commit();

            return $result;
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
