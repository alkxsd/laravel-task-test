<?php

namespace Tests\Unit;

use App\Services\TaskService;
use App\Models\Task;
use App\Models\User;
use App\DTO\TaskDto;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can get tasks for a user', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->id]);

    $taskService = new TaskService();
    $tasks = $taskService->getTasksForUser($user)->get();

    expect($tasks)->toHaveCount(1);
    expect($tasks[0]->id)->toBe($task->id);
});

it('can create a task', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $taskDto = new TaskDto(
        title: 'Test Task',
        description: 'Test Description',
        categoryId: $category->id,
        status: 'New'
    );

    $taskService = new TaskService();
    $task = $taskService->createTask($user, $taskDto);

    expect($task)->toBeInstanceOf(Task::class);
    expect($task->title)->toBe('Test Task');
    expect(Task::count())->toBe(1);
});

it('can get a task by ID', function () {
    $task = Task::factory()->create();

    $taskService = new TaskService();
    $foundTask = $taskService->getTaskById($task->id);

    expect($foundTask->id)->toBe($task->id);
});

it('can update a task', function () {
    $category = Category::factory()->create();
    $task = Task::factory()->create(['category_id' => $category->id]);

    $category2 = Category::factory()->create();
    $taskDto = new TaskDto(
        title: 'Updated Title',
        description: 'Updated Description',
        categoryId: $category2->id,
        status: 'In Progress'
    );

    $taskService = new TaskService();
    $updatedTask = $taskService->updateTask($task, $taskDto);

    expect($updatedTask->title)->toBe('Updated Title');
    expect($updatedTask->category_id)->not()->toBe($category->id);
    expect($updatedTask->category_id)->toBe($category2->id);
});

it('can delete a task', function () {
    $task = Task::factory()->create();

    $taskService = new TaskService();
    $taskService->deleteTask($task);

    expect(Task::count())->toBe(0);
});

it('can update a task\'s status', function () {
    $task = Task::factory()->create(['status' => 'New']);

    $taskService = new TaskService();
    $updatedTask = $taskService->updateTaskStatus($task, 'Completed');

    expect($updatedTask->status)->not()->toBe('New');
    expect($updatedTask->status)->toBe('Completed');
});
