<?php

namespace App\Traits\Task;

use Illuminate\Http\Request;
use App\Services\TaskService;
use App\DTO\TaskFilterDto;

trait Filterable
{
    protected function filterTasks(TaskFilterDto $taskFilterDto, TaskService $taskService)
    {
        $query = $taskService->getTasksForUser(auth()->user());

        if ($taskFilterDto->search) {
            $query->where('title', 'like', '%' . $taskFilterDto->search . '%');
        }

        if ($taskFilterDto->status) {
            $query->where('status', $taskFilterDto->status);
        }

        if ($taskFilterDto->category_id) {
            $query->where('category_id', $taskFilterDto->category_id);
        }

        return $query;
    }
}
