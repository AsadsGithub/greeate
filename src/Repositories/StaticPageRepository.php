<?php

namespace Greeate\Greeate\Repositories;

use Greeate\Greeate\Contracts\StaticPageRepositoryInterface;
use Greeate\Greeate\Models\StaticPage;

class StaticPageRepository extends BaseRepository implements StaticPageRepositoryInterface
{
    protected array $searchableFields = ['title', 'slug', 'content'];

    protected array $filterableFields = ['status'];

    protected array $relationships = [];

    public function __construct()
    {
        parent::__construct(new StaticPage());
    }
}
