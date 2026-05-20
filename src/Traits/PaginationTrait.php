<?php

namespace Greeate\Greeate\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

trait PaginationTrait
{
    public function all(array $columns = ['*']): Collection
    {
        $query = $this->model->newQuery();

        if (! empty($this->relationships)) {
            $query->with($this->relationships);
        }

        return $query->get($columns);
    }

    public function paginate(Request $request, int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        $perPage = min(
            $request->integer('per_page', $perPage),
            config('greeate.pagination.max_per_page', 100)
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

        return $query->paginate($perPage, $columns);
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

    protected function applyRelationships($query, Request $request)
    {
        $with = $request->get('with', []);
        if (! empty($with) && is_array($with)) {
            $query->with($with);
        }

        return $query;
    }
}
