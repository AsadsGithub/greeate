<?php

namespace Greeate\Greeate\Http\Controllers\Admin;

use Greeate\Greeate\Contracts\BannerRepositoryInterface;
use Greeate\Greeate\Http\Controllers\BaseController;
use Greeate\Greeate\Traits\CrudController;
use Illuminate\Http\Request;

class BannerController extends BaseController
{
    use CrudController;

    public function __construct(
        protected BannerRepositoryInterface $repository
    ) {}

    protected function getRepository(): BannerRepositoryInterface
    {
        return $this->repository;
    }

    protected function getResourceName(): string
    {
        return 'banners';
    }

    protected function getViewPrefix(): string
    {
        return 'greeate::admin.banners';
    }

    protected function getRoutePrefix(): string
    {
        return 'greeate.admin.banners';
    }
}
