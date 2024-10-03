<?php

namespace App\Services;

use App\Models\Task;
use App\Models\Category;
use App\DTO\TaskDto;
use App\Models\User;

class TaskService
{
    public function getTasksForUser(User $user)
    {
        return $user->tasks()->with('category')->orderBy('created_at', 'desc');
    }

    public function createTask($user, TaskDto $taskDto)
    {
        return $user->tasks()->create([
            'title' => $taskDto->title,
            'description' => $taskDto->description,
            'category_id' => $taskDto->categoryId,
            'status' => $taskDto->status,
        ]);
    }

    public function getTaskById($id)
    {
        return Task::with('category')->findOrFail($id);
    }

    public function updateTask(Task $task, TaskDto $taskDto)
    {
        $task->update([
            'title' => $taskDto->title,
            'description' => $taskDto->description,
            'category_id' => $taskDto->categoryId,
            'status' => $taskDto->status,
        ]);
        return $task;
    }

    public function deleteTask(Task $task)
    {
        $task->delete();
    }

    public function updateTaskStatus(Task $task, $newStatus)
    {
        $allowedStatuses = [
            'New' => 'In Progress',
            'In Progress' => 'Under Review',
            'Under Review' => 'Completed',
        ];

        $currentStatus = $task->status;

        // Only allow status change to the next sequential status
        if (isset($allowedStatuses[$currentStatus]) && $allowedStatuses[$currentStatus] === $newStatus) {
            $task->status = $newStatus;

            // Log the status change with a timestamp
            $task->status_history = $task->status_history ?? []; // Initialize if not exists
            $task->status_history[] = [
                'status' => $newStatus,
                'timestamp' => now(),
            ];

            // If marked as "Completed", set completion date
            if ($newStatus === 'Completed') {
                $task->completed_at = now();
            }

            $task->save();
        } else {
            // Handle invalid status transition (e.g., throw an exception, log an error, etc.)
            // For now, we'll just return the task without updating the status
        }

        return $task;
    }


    public function getCategories()
    {
        return Category::all();
    }
}
