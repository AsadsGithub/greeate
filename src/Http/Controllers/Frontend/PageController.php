<?php

namespace Greeate\Greeate\Http\Controllers\Frontend;

use Greeate\Greeate\Contracts\StaticPageRepositoryInterface;
use Greeate\Greeate\Http\Controllers\BaseController;

class PageController extends BaseController
{
    public function __construct(protected StaticPageRepositoryInterface $repository) {}

    public function show(string $slug)
    {
        $page = $this->repository->findBy(['slug' => $slug, 'status' => 'published']);

        if (! $page) {
            abort(404);
        }

        return view('greeate::frontend.page', compact('page'));
    }
}
