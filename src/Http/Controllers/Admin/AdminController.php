<?php

namespace Greeate\Greeate\Http\Controllers\Admin;

use Greeate\Greeate\Contracts\AdminRepositoryInterface;
use Greeate\Greeate\Http\Controllers\BaseController;
use Greeate\Greeate\Services\AdminService;
use Greeate\Greeate\Traits\CrudController;

class AdminController extends BaseController
{
    use CrudController;

    public function __construct(
        protected AdminRepositoryInterface $repository,
        protected AdminService $service
    ) {}

    protected function getRepository(): AdminRepositoryInterface
    {
        return $this->repository;
    }

    protected function getResourceName(): string
    {
        return 'admins';
    }

    protected function getViewPrefix(): string
    {
        return 'greeate::admin.admins';
    }

    protected function getRoutePrefix(): string
    {
        return 'greeate.admin.admins';
    }
}
