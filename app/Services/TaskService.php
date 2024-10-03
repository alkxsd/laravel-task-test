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
        $task->status = $newStatus;
        $task->save();
        return $task;
    }

    public function getCategories()
    {
        return Category::all();
    }
}
