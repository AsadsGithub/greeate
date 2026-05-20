<?php

namespace Greeate\Greeate\Http\Controllers\Admin;

use Greeate\Greeate\Contracts\ContactMessageRepositoryInterface;
use Greeate\Greeate\Http\Controllers\BaseController;
use Greeate\Greeate\Traits\CrudController;
use Illuminate\Http\Request;

class ContactMessageController extends BaseController
{
    use CrudController;

    public function __construct(
        protected ContactMessageRepositoryInterface $repository
    ) {}

    protected function getRepository(): ContactMessageRepositoryInterface
    {
        return $this->repository;
    }

    protected function getResourceName(): string
    {
        return 'contact-messages';
    }

    protected function getViewPrefix(): string
    {
        return 'greeate::admin.contact-messages';
    }

    protected function getRoutePrefix(): string
    {
        return 'greeate.admin.contact-messages';
    }
}
