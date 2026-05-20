<?php

namespace Greeate\Greeate\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

trait SortTrait
{
    public function sort(Request $request): LengthAwarePaginator
    {
        $query = $this->model->newQuery();
        $query = $this->applySorting($query, $request);

        if (! empty($this->relationships)) {
            $query->with($this->relationships);
        }

        return $query->paginate($request->integer('per_page', config('greeate.pagination.per_page', 15)));
    }

    protected function applySorting(Builder $query, Request $request): Builder
    {
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = strtolower($request->get('sort_order', 'desc')) === 'asc' ? 'asc' : 'desc';

        $allowed = array_merge(
            $this->model->getFillable(),
            ['id', 'created_at', 'updated_at', 'deleted_at']
        );

        if (in_array($sortBy, $allowed, true)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        return $query;
    }
}
