<?php

namespace Greeate\Greeate\Http\Controllers\Admin;

use Greeate\Greeate\Contracts\AdminRepositoryInterface;
use Greeate\Greeate\Http\Controllers\BaseController;
use Greeate\Greeate\Services\AdminService;
use Greeate\Greeate\Traits\CrudController;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $data = $this->validateStore($request);
        $this->service->create($data);

        return redirect()
            ->route($this->getRoutePrefix().'.index')
            ->with('success', __('greeate::messages.created_successfully'));
    }

    public function update(Request $request, int $id)
    {
        $data = $this->validateUpdate($request, $id);
        $this->service->update($id, $data);

        return redirect()
            ->route($this->getRoutePrefix().'.index')
            ->with('success', __('greeate::messages.updated_successfully'));
    }

    protected function validateStore(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:greeate_admins,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8',
            'role' => 'nullable|string|exists:roles,name',
            'status' => 'in:active,inactive',
        ]);
    }

    protected function validateUpdate(Request $request, int $id): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:greeate_admins,email,'.$id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8',
            'role' => 'nullable|string|exists:roles,name',
            'status' => 'in:active,inactive',
        ]);
    }
}
