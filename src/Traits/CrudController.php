<?php

namespace Greeate\Greeate\Traits;

use Greeate\Greeate\Contracts\BaseRepositoryInterface;
use Illuminate\Http\Request;

trait CrudController
{
    abstract protected function getRepository(): BaseRepositoryInterface;

    abstract protected function getResourceName(): string;

    abstract protected function getViewPrefix(): string;

    abstract protected function getRoutePrefix(): string;

    public function index(Request $request)
    {
        $items = $this->getRepository()->paginate($request);

        return view($this->getViewPrefix().'.index', [
            'items' => $items,
            'resource' => $this->getResourceName(),
        ]);
    }

    public function create()
    {
        return view($this->getViewPrefix().'.create', [
            'resource' => $this->getResourceName(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateStore($request);
        $item = $this->withTransaction(fn () => $this->getRepository()->create($data));

        return redirect()
            ->route($this->getRoutePrefix().'.index')
            ->with('success', __('greeate::messages.created_successfully'));
    }

    public function show(int $id)
    {
        $item = $this->getRepository()->findOrFail($id);

        return view($this->getViewPrefix().'.show', compact('item'));
    }

    public function edit(int $id)
    {
        $item = $this->getRepository()->findOrFail($id);

        return view($this->getViewPrefix().'.edit', compact('item'));
    }

    public function update(Request $request, int $id)
    {
        $data = $this->validateUpdate($request, $id);
        $this->withTransaction(fn () => $this->getRepository()->update($id, $data));

        return redirect()
            ->route($this->getRoutePrefix().'.index')
            ->with('success', __('greeate::messages.updated_successfully'));
    }

    public function destroy(int $id)
    {
        $this->withTransaction(fn () => $this->getRepository()->delete($id));

        return redirect()
            ->route($this->getRoutePrefix().'.index')
            ->with('success', __('greeate::messages.deleted_successfully'));
    }

    public function toggleStatus(int $id)
    {
        $this->getRepository()->toggleStatus($id);

        return back()->with('success', __('greeate::messages.status_updated'));
    }

    protected function validateStore(Request $request): array
    {
        return $request->all();
    }

    protected function validateUpdate(Request $request, int $id): array
    {
        return $request->all();
    }
}
