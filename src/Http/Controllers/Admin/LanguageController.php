<?php

namespace Greeate\Greeate\Http\Controllers\Admin;

use Greeate\Greeate\Contracts\LanguageRepositoryInterface;
use Greeate\Greeate\Http\Controllers\BaseController;
use Greeate\Greeate\Traits\CrudController;
use Illuminate\Http\Request;

class LanguageController extends BaseController
{
    use CrudController;

    public function __construct(
        protected LanguageRepositoryInterface $repository
    ) {}

    protected function getRepository(): LanguageRepositoryInterface
    {
        return $this->repository;
    }

    protected function getResourceName(): string
    {
        return 'languages';
    }

    protected function getViewPrefix(): string
    {
        return 'greeate::admin.languages';
    }

    protected function getRoutePrefix(): string
    {
        return 'greeate.admin.languages';
    }
}
