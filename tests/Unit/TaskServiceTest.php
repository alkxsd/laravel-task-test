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


it('can update a task\'s status to the next sequential status', function () {
    $task = Task::factory()->create(['status' => 'New']);

    $taskService = new TaskService();

    // Valid transition: New -> In Progress
    $updatedTask = $taskService->updateTaskStatus($task, 'In Progress');
    expect($updatedTask->status)->toBe('In Progress');
    expect($updatedTask->status_history)->toHaveCount(1);
    expect($updatedTask->status_history[0]['status'])->toBe('In Progress');

    // Valid transition: In Progress -> Under Review
    $updatedTask = $taskService->updateTaskStatus($updatedTask, 'Under Review');
    expect($updatedTask->status)->toBe('Under Review');
    expect($updatedTask->status_history)->toHaveCount(2);
    expect($updatedTask->status_history[1]['status'])->toBe('Under Review');

    // Valid transition: Under Review -> Completed
    $updatedTask = $taskService->updateTaskStatus($updatedTask, 'Completed');
    expect($updatedTask->status)->toBe('Completed');
    expect($updatedTask->status_history)->toHaveCount(3);
    expect($updatedTask->status_history[2]['status'])->toBe('Completed');
    expect($updatedTask->completed_at)->not()->toBeNull();
});

it('cannot update a task\'s status to a non-sequential status', function () {
    $task = Task::factory()->create(['status' => 'New']);

    $taskService = new TaskService();

    // Invalid transition: New -> Under Review
    $updatedTask = $taskService->updateTaskStatus($task, 'Under Review');
    expect($updatedTask->status)->toBe('New'); // Status should remain the same
    expect($updatedTask->status_history)->toBeNull();

    // Invalid transition: In Progress -> Completed (without going through Under Review)
    $updatedTask = $taskService->updateTaskStatus($updatedTask, 'Completed');
    expect($updatedTask->status)->toBe('New');
    expect($updatedTask->status_history)->toBeNull();
});

it('cannot set a task\'s status back to "New" once changed', function () {
    $task = Task::factory()->create(['status' => 'In Progress']);

    $taskService = new TaskService();

    // Invalid transition: In Progress -> New
    $updatedTask = $taskService->updateTaskStatus($task, 'New');
    expect($updatedTask->status)->toBe('In Progress');
});
