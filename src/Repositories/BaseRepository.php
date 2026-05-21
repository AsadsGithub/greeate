<?php

namespace Greeate\Greeate\Repositories;

use Greeate\Greeate\Contracts\BaseRepositoryInterface;
use Greeate\Greeate\Traits\RepositoryOperations;
use Greeate\Greeate\Traits\TranslationTrait;
use Greeate\Greeate\Traits\UploadTrait;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements BaseRepositoryInterface
{
    use RepositoryOperations;
    use TranslationTrait;
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
