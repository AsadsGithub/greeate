<?php

namespace Greeate\Greeate\Traits;

use Greeate\Greeate\Support\GreeateModuleRegistry;
use Greeate\Greeate\Support\GreeateUi;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

trait CrudController
{
    abstract protected function getRepository(): \Greeate\Greeate\Contracts\BaseRepositoryInterface;

    abstract protected function getResourceName(): string;

    abstract protected function getViewPrefix(): string;

    abstract protected function getRoutePrefix(): string;

    public function index(Request $request)
    {
        $module = $this->getModuleKey();
        $items = $this->getRepository()->paginate($request);

        return $this->renderCrud('index', [
            'module' => $module,
            'moduleConfig' => GreeateModuleRegistry::get($module),
            'items' => $items,
            'filters' => $request->only(['search', 'status', 'per_page']),
            'title' => __("greeate::nav.{$this->getNavKey()}"),
        ]);
    }

    public function create()
    {
        $module = $this->getModuleKey();

        return $this->renderCrud('create', [
            'module' => $module,
            'moduleConfig' => GreeateModuleRegistry::get($module),
            'title' => __('greeate::actions.create').' '.__("greeate::nav.{$this->getNavKey()}"),
            'formOptions' => $this->getFormOptions(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateStore($request);
        $this->withTransaction(fn () => $this->getRepository()->create($data));

        return redirect()
            ->route($this->getRoutePrefix().'.index')
            ->with('success', __('greeate::messages.created_successfully'));
    }

    public function show(int $id)
    {
        $module = $this->getModuleKey();
        $item = $this->getRepository()->findOrFail($id);

        return $this->renderCrud('show', [
            'module' => $module,
            'moduleConfig' => GreeateModuleRegistry::get($module),
            'item' => $item,
            'title' => __("greeate::nav.{$this->getNavKey()}"),
        ]);
    }

    public function edit(int $id)
    {
        $module = $this->getModuleKey();
        $item = $this->getRepository()->findOrFail($id);

        return $this->renderCrud('edit', [
            'module' => $module,
            'moduleConfig' => GreeateModuleRegistry::get($module),
            'item' => $item,
            'title' => __('greeate::actions.edit').' '.__("greeate::nav.{$this->getNavKey()}"),
            'formOptions' => $this->getFormOptions(),
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

    protected function getModuleKey(): string
    {
        return GreeateModuleRegistry::urlSegment($this->getResourceName());
    }

    protected function getNavKey(): string
    {
        return str_replace('-', '_', $this->getResourceName());
    }

    protected function getBasePath(): string
    {
        $prefix = trim(config('greeate.admin_prefix', 'dashboard'), '/');

        return '/'.$prefix.'/'.GreeateModuleRegistry::urlSegment($this->getResourceName());
    }

    protected function getFormOptions(): array
    {
        return [
            'roles' => Role::query()->orderBy('name')->pluck('name', 'name')->toArray(),
        ];
    }

    protected function renderCrud(string $action, array $props = [])
    {
        if (GreeateUi::usesInertia()) {
            $page = match ($action) {
                'index' => 'greeate/admin/crud/index',
                'show' => 'greeate/admin/crud/show',
                default => 'greeate/admin/crud/form',
            };

            return $this->greeatePage($page, array_merge($props, [
                'action' => $action,
                'routePrefix' => $this->getRoutePrefix(),
                'basePath' => $this->getBasePath(),
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
