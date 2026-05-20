<?php

namespace Greeate\Greeate\Repositories;

use Greeate\Greeate\Contracts\BaseRepositoryInterface;
use Greeate\Greeate\Traits\CreateTrait;
use Greeate\Greeate\Traits\DeleteTrait;
use Greeate\Greeate\Traits\FilterTrait;
use Greeate\Greeate\Traits\PaginationTrait;
use Greeate\Greeate\Traits\SearchTrait;
use Greeate\Greeate\Traits\SortTrait;
use Greeate\Greeate\Traits\StatusTrait;
use Greeate\Greeate\Traits\TranslationTrait;
use Greeate\Greeate\Traits\UpdateTrait;
use Greeate\Greeate\Traits\UploadTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements BaseRepositoryInterface
{
    use CreateTrait;
    use DeleteTrait;
    use FilterTrait;
    use PaginationTrait;
    use SearchTrait;
    use SortTrait;
    use StatusTrait;
    use TranslationTrait;
    use UpdateTrait;
    use UploadTrait;

    protected Model $model;

    protected array $searchableFields = [];

    protected array $filterableFields = [];

    protected array $relationships = [];

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->searchableFields = $this->getSearchableFields();
        $this->filterableFields = $this->getFilterableFields();
        $this->relationships = $this->getDefaultRelationships();
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

    protected function getSearchableFields(): array
    {
        return $this->searchableFields ?: ($this->model->getFillable() ?? []);
    }

    protected function getFilterableFields(): array
    {
        return $this->filterableFields ?: ($this->model->getFillable() ?? []);
    }

    protected function getDefaultRelationships(): array
    {
        return $this->relationships;
    }
}
