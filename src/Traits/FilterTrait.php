<?php

namespace Greeate\Greeate\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

trait FilterTrait
{
    public function filter(Request $request): LengthAwarePaginator
    {
        $query = $this->model->newQuery();
        $query = $this->applyFilters($query, $request);

        if (! empty($this->relationships)) {
            $query->with($this->relationships);
        }

        return $query->paginate($request->integer('per_page', config('greeate.pagination.per_page', 15)));
    }

    protected function applyFilters(Builder $query, Request $request): Builder
    {
        $filters = $request->get('filters', []);

        foreach ($filters as $field => $value) {
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
            } else {
                $query->whereIn($field, $value);
            }
        } else {
            $query->where($field, $value);
        }
    }
}
