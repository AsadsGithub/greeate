<?php

namespace Greeate\Greeate\Http\Controllers\Admin;

use Greeate\Greeate\Contracts\StaticPageRepositoryInterface;
use Greeate\Greeate\Http\Controllers\BaseController;
use Greeate\Greeate\Traits\CrudController;
use Illuminate\Http\Request;

class StaticPageController extends BaseController
{
    use CrudController;

    public function __construct(
        protected StaticPageRepositoryInterface $repository
    ) {}

    protected function getRepository(): StaticPageRepositoryInterface
    {
        return $this->repository;
    }

    protected function getResourceName(): string
    {
        return 'static-pages';
    }

    protected function getViewPrefix(): string
    {
        return 'greeate::admin.static-pages';
    }

    protected function getRoutePrefix(): string
    {
        return 'greeate.admin.static-pages';
    }
}
