<?php

namespace Greeate\Greeate\Repositories;

use Greeate\Greeate\Contracts\RoleRepositoryInterface;
use Greeate\Greeate\Models\Role;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    protected array $searchableFields = ['name'];

    protected array $filterableFields = [];

    protected array $relationships = ['permissions'];

    public function __construct()
    {
        parent::__construct(new Role());
    }
}
