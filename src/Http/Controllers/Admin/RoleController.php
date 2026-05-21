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

    protected function validateStore(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'alias' => 'nullable|string|max:255',
        ]);
    }

    protected function validateUpdate(Request $request, int $id): array
    {
        return $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,'.$id,
            'alias' => 'nullable|string|max:255',
        ]);
    }
}
