<?php

namespace Greeate\Greeate\Http\Controllers\Admin;

use Greeate\Greeate\Contracts\PermissionRepositoryInterface;
use Greeate\Greeate\Http\Controllers\BaseController;
use Greeate\Greeate\Traits\CrudController;
use Illuminate\Http\Request;

class PermissionController extends BaseController
{
    use CrudController;

    public function __construct(
        protected PermissionRepositoryInterface $repository
    ) {}

    protected function getRepository(): PermissionRepositoryInterface
    {
        return $this->repository;
    }

    protected function getResourceName(): string
    {
        return 'permissions';
    }

    protected function getViewPrefix(): string
    {
        return 'greeate::admin.permissions';
    }

    protected function getRoutePrefix(): string
    {
        return 'greeate.admin.permissions';
    }
}
