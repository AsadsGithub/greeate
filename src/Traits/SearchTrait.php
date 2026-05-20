<?php

namespace Greeate\Greeate\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

trait SearchTrait
{
    public function search(Request $request): LengthAwarePaginator
    {
        $query = $this->model->newQuery();
        $query = $this->applySearch($query, $request);
        $query = $this->applySorting($query, $request);

        if (! empty($this->relationships)) {
            $query->with($this->relationships);
        }

        return $query->paginate($request->integer('per_page', config('greeate.pagination.per_page', 15)));
    }

    protected function applySearch(Builder $query, Request $request): Builder
    {
        $search = $request->get('search');

        if (empty($search) || empty($this->searchableFields)) {
            return $query;
        }

        $escaped = str_replace(['%', '_', '\\'], ['\\%', '\\_', '\\\\'], $search);

        $query->where(function (Builder $q) use ($escaped) {
            foreach ($this->searchableFields as $field) {
                $q->orWhere($field, 'LIKE', "%{$escaped}%");
            }
        });

        return $query;
    }
}
