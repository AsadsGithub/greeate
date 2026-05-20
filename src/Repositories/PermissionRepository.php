<?php

namespace Greeate\Greeate\Repositories;

use Greeate\Greeate\Contracts\PermissionRepositoryInterface;
use Spatie\Permission\Models\Permission;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    protected array $searchableFields = ['name'];

    protected array $filterableFields = [];

    protected array $relationships = [];

    public function __construct()
    {
        parent::__construct(new Permission());
    }
}
