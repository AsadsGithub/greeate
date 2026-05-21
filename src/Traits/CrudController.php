<?php

namespace Greeate\Greeate\Traits;

use Greeate\Greeate\Support\GreeateUi;
use Illuminate\Http\Request;

trait CrudController
{
    abstract protected function getRepository(): \Greeate\Greeate\Contracts\BaseRepositoryInterface;

    abstract protected function getResourceName(): string;

    abstract protected function getViewPrefix(): string;

    abstract protected function getRoutePrefix(): string;

    public function index(Request $request)
    {
        $items = $this->getRepository()->paginate($request);

        return $this->renderCrud('index', [
            'items' => $items,
            'resource' => $this->getResourceName(),
            'title' => __("greeate::nav.{$this->getResourceName()}"),
        ]);
    }

    public function create()
    {
        return $this->renderCrud('create', [
            'resource' => $this->getResourceName(),
            'title' => __('greeate::actions.create').' '. __("greeate::nav.{$this->getResourceName()}"),
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

        return $this->renderCrud('show', [
            'item' => $item,
            'resource' => $this->getResourceName(),
        ]);
    }

    public function edit(int $id)
    {
        $item = $this->getRepository()->findOrFail($id);

        return $this->renderCrud('edit', [
            'item' => $item,
            'resource' => $this->getResourceName(),
            'title' => __('greeate::actions.edit').' '. __("greeate::nav.{$this->getResourceName()}"),
        ]);
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

    protected function renderCrud(string $action, array $props = [])
    {
        if (GreeateUi::usesInertia()) {
            $component = GreeateUi::inertiaComponentFromBladePrefix($this->getViewPrefix(), $action);

            if ($action === 'index') {
                $adminPrefix = trim(config('greeate.admin_prefix', 'admin'), '/');

                return $this->greeatePage('greeate/admin/resource-index', array_merge($props, [
                    'component' => $component,
                    'routePrefix' => $this->getRoutePrefix(),
                    'basePath' => '/'.$adminPrefix.'/'.str_replace('_', '-', $this->getResourceName()),
                ]));
            }

            return $this->greeatePage('greeate/admin/resource-form', array_merge($props, [
                'action' => $action,
                'routePrefix' => $this->getRoutePrefix(),
            ]));
        }

        return view($this->getViewPrefix().'.'.$action, $props);
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
