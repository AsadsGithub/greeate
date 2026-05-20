<?php

namespace Greeate\Greeate\Http\Controllers\Api\V1;

use Greeate\Greeate\Contracts\AdminRepositoryInterface;
use Greeate\Greeate\Http\Controllers\BaseController;
use Greeate\Greeate\Http\Resources\AdminResource;
use Illuminate\Http\Request;

class AdminController extends BaseController
{
    public function __construct(protected AdminRepositoryInterface $repository) {}

    public function index(Request $request)
    {
        return AdminResource::collection($this->repository->paginate($request));
    }

    public function show(int $id)
    {
        return new AdminResource($this->repository->findOrFail($id)->load('roles'));
    }
}
