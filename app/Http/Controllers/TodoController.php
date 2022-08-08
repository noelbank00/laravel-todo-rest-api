<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\TodoInterface;
use App\Http\Services\TodoService;
use App\Models\Todo;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    private TodoService $service;

    /**
     * @param TodoService $service
     */
    public function __construct(TodoInterface $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): JsonResponse
    {
        $completed = $request->input('completed') ?? null;
        $perPage = (int)$request->input('per_page') ?? 25;
        $page = (int)$request->input('page') ?? 0;
        $name = $request->input('name') ?? '';

        return response()->json($this->service->getWithPaginationAll($completed, $name, $perPage, $page));
    }

    /**
     * @param StoreTodoRequest $request
     * @return Todo
     */
    public function store(StoreTodoRequest $request): Todo
    {
        return $this->service->create($request->validated());
    }

    /**
     * @param Todo $todo
     * @return JsonResponse
     */
    public function show(Todo $todo): JsonResponse
    {
        return response()->json($todo);
    }

    /**
     * @param UpdateTodoRequest $request
     * @param Todo $todo
     * @return JsonResponse
     */
    public function update(UpdateTodoRequest $request, Todo $todo): JsonResponse
    {
        return response()->json(['success' => (bool)$this->service->update($todo, $request->validated())]);
    }

    /**
     * @param Todo $todo
     * @return JsonResponse
     */
    public function destroy(Todo $todo): JsonResponse
    {
        return response()->json(['success' => (bool)$this->service->delete($todo)]);
    }
}
