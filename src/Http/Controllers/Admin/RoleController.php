<?php

namespace Greeate\Greeate\Http\Controllers\Admin;

use Greeate\Greeate\Contracts\RoleRepositoryInterface;
use Greeate\Greeate\Http\Controllers\BaseController;
use Greeate\Greeate\Traits\CrudController;
use Illuminate\Http\Request;

class RoleController extends BaseController
{
    use CrudController;

    public function __construct(
        protected RoleRepositoryInterface $repository
    ) {}

    protected function getRepository(): RoleRepositoryInterface
    {
        return $this->repository;
    }

    protected function getResourceName(): string
    {
        return 'roles';
    }

    protected function getViewPrefix(): string
    {
        return 'greeate::admin.roles';
    }

    protected function getRoutePrefix(): string
    {
        return 'greeate.admin.roles';
    }
}
