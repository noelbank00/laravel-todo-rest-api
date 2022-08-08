<?php

namespace App\Http\Interfaces;

use App\Models\Todo;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface TodoInterface
{
    public function getAll(int|null $completed, string $name): Collection|array;

    public function getWithPaginationAll(int|null $completed, string $name, int $perPage, int $page): LengthAwarePaginator;

    public function create(array $data): Todo;

    public function update(Todo $todoItem, array $data): bool;

    public function delete(Todo $todoItem): bool|null;
}
