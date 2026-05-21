<?php

namespace Greeate\Greeate\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

trait RepositoryOperations
{
    public function all(array $columns = ['*']): Collection
    {
        $query = $this->model->newQuery();

        if (! empty($this->relationships)) {
            $query->with($this->relationships);
        }

        return $query->get($columns);
    }

    public function create(array $data): Model
    {
        return $this->withTransaction(function () use ($data) {
            $data = $this->beforeCreate($data);
            $record = $this->model->create($data);
            $this->afterCreate($record, $data);
            $this->logOperation('created', ['id' => $record->id]);

            return $record->fresh($this->relationships);
        });
    }

    public function update(int $id, array $data): Model
    {
        return $this->withTransaction(function () use ($id, $data) {
            $record = $this->findOrFail($id);
            $data = $this->beforeUpdate($record, $data);
            $record->update($data);
            $this->afterUpdate($record, $data);
            $this->logOperation('updated', ['id' => $record->id]);

            return $record->fresh($this->relationships);
        });
    }

    public function delete(int $id): bool
    {
        return $this->withTransaction(function () use ($id) {
            $record = $this->findOrFail($id);
            $this->beforeDelete($record);
            $deleted = $record->delete();
            $this->afterDelete($record);
            $this->logOperation('deleted', ['id' => $id]);

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

    public function bulkUpdate(array $ids, array $data): int
    {
        return $this->withTransaction(function () use ($ids, $data) {
            return $this->model->newQuery()->whereIn('id', $ids)->update($data);
        });
    }

    public function toggleStatus(int $id, string $field = 'status'): Model
    {
        return $this->withTransaction(function () use ($id, $field) {
            $record = $this->findOrFail($id);
            $current = $record->{$field};
            $record->{$field} = is_bool($current)
                ? ! $current
                : ($current === 'active' || $current === true || $current === 1 ? 'inactive' : 'active');
            $record->save();

            return $record->fresh($this->relationships);
        });
    }

    public function find(int $id): ?Model
    {
        $query = $this->model->newQuery();

        if (! empty($this->relationships)) {
            $query->with($this->relationships);
        }

        return $query->find($id);
    }

    public function findOrFail(int $id): Model
    {
        $query = $this->model->newQuery();

        if (! empty($this->relationships)) {
            $query->with($this->relationships);
        }

        return $query->findOrFail($id);
    }

    public function findBy(array $criteria, ?int $limit = null): Model|Collection|null
    {
        $query = $this->model->newQuery()->where($criteria);

        if ($limit === null) {
            return $query->first();
        }

        return $query->limit($limit)->get();
    }

    public function paginate(Request $request, int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        $perPage = min(
            $request->integer('per_page', $perPage),
            (int) config('greeate.pagination.max_per_page', 100)
        );

        $query = $this->model->newQuery();

        if ($columns !== ['*']) {
            $query->select($columns);
        }

        if (! empty($this->relationships)) {
            $query->with($this->relationships);
        }

        $query = $this->applyFilters($query, $request);
        $query = $this->applySearch($query, $request);
        $query = $this->applySorting($query, $request);
        $query = $this->applyRelationships($query, $request);

        if ($this->shouldUseSimplePagination($request)) {
            return $query->simplePaginate($perPage, $columns);
        }

        return $query->paginate($perPage, $columns);
    }

    public function search(Request $request): LengthAwarePaginator
    {
        return $this->paginate($request);
    }

    public function filter(Request $request): LengthAwarePaginator
    {
        return $this->paginate($request);
    }

    public function sort(Request $request): LengthAwarePaginator
    {
        return $this->paginate($request);
    }

    public function count(?Request $request = null): int
    {
        $query = $this->model->newQuery();

        if ($request) {
            $query = $this->applyFilters($query, $request);
            $query = $this->applySearch($query, $request);
        }

        return $query->count();
    }

    public function exists(array $criteria): bool
    {
        return $this->model->newQuery()->where($criteria)->exists();
    }

    protected function withTransaction(callable $function): mixed
    {
        try {
            DB::beginTransaction();
            $result = $function();
            DB::commit();

            return $result;
        } catch (Throwable $th) {
            DB::rollBack();
            Log::error('Repository transaction failed', [
                'repository' => class_basename($this),
                'model' => class_basename($this->model),
                'message' => $th->getMessage(),
            ]);
            throw $th;
        }
    }

    protected function shouldUseSimplePagination(Request $request): bool
    {
        return $request->boolean('simple_pagination') || $request->integer('page', 1) > 100;
    }

    protected function applyFilters(Builder $query, Request $request): Builder
    {
        foreach ($request->get('filters', []) as $field => $value) {
            if ($value === null || $value === '') {
                continue;
            }
            if (! in_array($field, $this->filterableFields, true)) {
                continue;
            }
            $this->applyFilter($query, $field, $value);
        }

        if (method_exists($this, 'applyCustomFilters')) {
            $query = $this->applyCustomFilters($query, $request);
        }

        return $query;
    }

    protected function applyFilter(Builder $query, string $field, mixed $value): void
    {
        if (is_array($value)) {
            if (isset($value['from'], $value['to'])) {
                $query->whereBetween($field, [$value['from'], $value['to']]);
            } elseif (isset($value['min'], $value['max'])) {
                $query->whereBetween($field, [$value['min'], $value['max']]);
            } elseif (isset($value['from'])) {
                $query->where($field, '>=', $value['from']);
            } elseif (isset($value['to'])) {
                $query->where($field, '<=', $value['to']);
            } else {
                $query->whereIn($field, $value);
            }
        } else {
            $query->where($field, $value);
        }
    }

    protected function applySearch(Builder $query, Request $request): Builder
    {
        $search = $request->get('search');

        if (empty($search) || empty($this->searchableFields)) {
            return $query;
        }

        try {
            if ($this->useFullTextSearch() && config('database.default') === 'mysql') {
                $searchFields = implode(',', $this->searchableFields);
                if ($this->containsSpecialCharacters($search)) {
                    return $query->whereRaw("MATCH({$searchFields}) AGAINST(? IN NATURAL LANGUAGE MODE)", [$search]);
                }

                return $query->whereRaw("MATCH({$searchFields}) AGAINST(? IN BOOLEAN MODE)", [$search.'*']);
            }

            $escaped = str_replace(['%', '_', '\\'], ['\\%', '\\_', '\\\\'], $search);
            $query->where(function (Builder $q) use ($escaped) {
                foreach ($this->searchableFields as $field) {
                    $q->orWhere($field, 'LIKE', "%{$escaped}%");
                }
            });
        } catch (\Exception $e) {
            $escaped = str_replace(['%', '_', '\\'], ['\\%', '\\_', '\\\\'], $search);
            $query->where(function (Builder $q) use ($escaped) {
                foreach ($this->searchableFields as $field) {
                    $q->orWhere($field, 'LIKE', "%{$escaped}%");
                }
            });
        }

        return $query;
    }

    protected function containsSpecialCharacters(string $search): bool
    {
        foreach (['@', '+', '-', '>', '<', '(', ')', '~', '*', '"', '\\'] as $char) {
            if (str_contains($search, $char)) {
                return true;
            }
        }

        return false;
    }

    protected function useFullTextSearch(): bool
    {
        return false;
    }

    protected function applySorting(Builder $query, Request $request): Builder
    {
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = strtolower($request->get('sort_order', $request->get('sort_dir', 'desc'))) === 'asc' ? 'asc' : 'desc';

        $allowed = array_merge($this->model->getFillable(), ['id', 'created_at', 'updated_at', 'deleted_at']);

        if (in_array($sortBy, $allowed, true)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        return $query;
    }

    protected function applyRelationships(Builder $query, Request $request): Builder
    {
        $with = $request->get('with', []);
        if (! empty($with) && is_array($with)) {
            $query->with($with);
        }

        foreach ($request->get('has', []) as $relation => $value) {
            if (! empty($value)) {
                $query->whereHas($relation, fn (Builder $q) => $q->where('name', $value));
            }
        }

        foreach ($request->get('whereHas', []) as $relation => $conditions) {
            if (! empty($conditions) && is_array($conditions)) {
                $query->whereHas($relation, function (Builder $q) use ($conditions) {
                    foreach ($conditions as $field => $value) {
                        if ($value !== null && $value !== '') {
                            $q->where($field, $value);
                        }
                    }
                });
            }
        }

        return $query;
    }

    protected function beforeCreate(array $data): array
    {
        return $data;
    }

    protected function afterCreate(Model $record, array $data): void {}

    protected function beforeUpdate(Model $record, array $data): array
    {
        return $data;
    }

    protected function afterUpdate(Model $record, array $data): void {}

    protected function beforeDelete(Model $record): void {}

    protected function afterDelete(Model $record): void {}

    protected function logOperation(string $operation, array $context = []): void
    {
        Log::info(class_basename($this->model).' '.$operation, array_merge([
            'repository' => class_basename($this),
        ], $context));
    }
}
