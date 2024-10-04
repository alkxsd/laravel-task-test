<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\TaskService;
use App\Models\Task;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Controllers\Controller;
use App\DTO\TaskDto;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    use AuthorizesRequests;

    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index()
    {
        $tasks = $this->taskService->getTasksForUser(auth()->user())->get();
        return response()->json($tasks);
    }

    public function store(StoreTaskRequest $request)
    {
        $taskDto = TaskDto::fromRequest($request);
        $task = $this->taskService->createTask(auth()->user(), $taskDto);
        return response()->json($task, 201);
    }

    public function show(Task $task)
    {
        $this->authorize('view', $task);
        return response()->json($task);
}

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);
        $taskDto = TaskDto::fromRequest($request);
        $task = $this->taskService->updateTask($task, $taskDto);
        return response()->json($task);
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $this->taskService->deleteTask($task);
        return response()->noContent();
    }

    public function updateStatus(Request $request, Task $task)
    {
        $this->authorize('update', $task);
        $request->validate(['status' => 'required|string']);
        $task = $this->taskService->updateTaskStatus($task, $request->status);
        return response()->json($task);
    }
}
