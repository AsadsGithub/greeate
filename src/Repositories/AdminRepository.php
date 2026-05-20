<?php

namespace Greeate\Greeate\Repositories;

use Greeate\Greeate\Contracts\AdminRepositoryInterface;
use Greeate\Greeate\Models\Admin;

class AdminRepository extends BaseRepository implements AdminRepositoryInterface
{
    protected array $searchableFields = ['name', 'email', 'phone'];

    protected array $filterableFields = ['status'];

    protected array $relationships = ['roles'];

    public function __construct()
    {
        parent::__construct(new Admin());
    }
}
