<?php

namespace Greeate\Greeate\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseRepositoryInterface
{
    public function all(array $columns = ['*']): Collection;

    public function paginate(Request $request, int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;

    public function find(int $id): ?Model;

    public function findOrFail(int $id): Model;

    public function findBy(array $criteria, ?int $limit = null): Model|Collection|null;

    public function create(array $data): Model;

    public function update(int $id, array $data): Model;

    public function delete(int $id): bool;

    public function restore(int $id): bool;

    public function forceDelete(int $id): bool;

    public function toggleStatus(int $id, string $field = 'status'): Model;

    public function search(Request $request): LengthAwarePaginator;

    public function filter(Request $request): LengthAwarePaginator;

    public function sort(Request $request): LengthAwarePaginator;

    public function bulkDelete(array $ids): int;

    public function bulkUpdate(array $ids, array $data): int;

    public function count(?Request $request = null): int;

    public function exists(array $criteria): bool;
}
