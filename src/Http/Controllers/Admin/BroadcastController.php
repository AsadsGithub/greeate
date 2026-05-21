<?php

namespace Greeate\Greeate\Http\Controllers\Admin;

use Greeate\Greeate\Contracts\BroadcastRepositoryInterface;
use Greeate\Greeate\Http\Controllers\BaseController;
use Greeate\Greeate\Services\BroadcastService;
use Greeate\Greeate\Traits\AuthorizesActions;
use Greeate\Greeate\Traits\CrudController;
use Illuminate\Http\Request;

class BroadcastController extends BaseController
{
    use AuthorizesActions, CrudController;

    public function __construct(
        protected BroadcastRepositoryInterface $repository,
        protected BroadcastService $broadcastService
    ) {}

    protected function getRepository(): BroadcastRepositoryInterface
    {
        return $this->repository;
    }

    protected function getResourceName(): string
    {
        return 'broadcasts';
    }

    protected function getViewPrefix(): string
    {
        return 'greeate::admin.broadcasts';
    }

    protected function getRoutePrefix(): string
    {
        return 'greeate.admin.broadcasts';
    }

    public function send(int $id)
    {
        $this->authorizeAbility('broadcasts.send');
        $broadcast = $this->repository->findOrFail($id);
        $this->broadcastService->send($broadcast);

        return back()->with('success', __('greeate::messages.broadcast_sent'));
    }
}
