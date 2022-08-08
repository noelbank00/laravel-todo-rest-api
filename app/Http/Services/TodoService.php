<?php

namespace App\Http\Services;

use App\Http\Interfaces\TodoInterface;
use App\Models\Todo;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Stevebauman\Purify\Facades\Purify;

class TodoService implements TodoInterface
{

    /**
     * @param int|null $completed
     * @param string $name
     * @return Collection|array
     */
    public function getAll(int|null $completed, string $name): Collection|array
    {
        return $this->getBuilder($completed, $name)->get();
    }

    /**
     * @param int|null $completed
     * @param string $name
     * @param int $perPage
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function getWithPaginationAll(int|null $completed, string $name, int $perPage, int $page): LengthAwarePaginator
    {
        return $this->getBuilder($completed, $name)->paginate(perPage: $perPage, page: $page);
    }

    /**
     * @param int|null $completed
     * @param string $name
     * @return Builder
     */
    private function getBuilder(int|null $completed, string $name): Builder
    {
        $base = Todo::query();
        if (!is_null($completed)) {
            $base = $base->where('completed', $completed);
        }

        if (strlen($name) !== 0) {
            $base = $base->where('name', $name);
        }

        return $base;
    }

    /**
     * @param array $data
     * @return Todo
     */
    public function create(array $data): Todo
    {
        foreach ($data as &$row) {
            $row = Purify::clean($row);
        }

        return Todo::create($data);
    }

    /**
     * @param Todo $todoItem
     * @param array $data
     * @return bool
     */
    public function update(Todo $todoItem, array $data): bool
    {
        foreach ($data as &$row) {
            $row = Purify::clean($row);
        }

        return $todoItem->update($data);
    }

    /**
     * @param Todo $todoItem
     * @return bool|null
     */
    public function delete(Todo $todoItem): bool|null
    {
        return $todoItem->delete();
    }
}
