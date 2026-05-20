<?php

namespace Greeate\Greeate\Http\Controllers\Admin;

use Greeate\Greeate\Contracts\FaqRepositoryInterface;
use Greeate\Greeate\Http\Controllers\BaseController;
use Greeate\Greeate\Traits\CrudController;
use Illuminate\Http\Request;

class FaqController extends BaseController
{
    use CrudController;

    public function __construct(
        protected FaqRepositoryInterface $repository
    ) {}

    protected function getRepository(): FaqRepositoryInterface
    {
        return $this->repository;
    }

    protected function getResourceName(): string
    {
        return 'faqs';
    }

    protected function getViewPrefix(): string
    {
        return 'greeate::admin.faqs';
    }

    protected function getRoutePrefix(): string
    {
        return 'greeate.admin.faqs';
    }
}
