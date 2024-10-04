<?php

use Laravel\Sanctum\Sanctum;
use App\Models\User;
use App\Models\Task;
use App\Models\Category;

it('can get all tasks for the authenticated user', function () {
    $user = User::factory()->create();
    loginApi($user);

    $task = Task::factory()->create(['user_id' => $user->id]);

    $response = $this->getJson('/api/tasks');

    $response->assertStatus(200)
        ->assertJsonFragment(['title' => $task->title]);
});

it('can create a new task', function () {
    loginApi();

    $category = Category::factory()->create();

    $response = $this->postJson('/api/tasks', [
        'title' => 'Test Task',
        'description' => 'Test Description',
        'category_id' => $category->id,
        'status' => 'New',
    ]);

    $response->assertStatus(201)
        ->assertJsonFragment(['title' => 'Test Task']);

    $this->assertDatabaseHas('tasks', ['title' => 'Test Task']);
});

it('can get a task by ID', function () {
    $user = User::factory()->create();
    loginApi($user);

    $task = Task::factory()->create(['user_id' => $user->id]);
    $response = $this->getJson("/api/tasks/{$task->id}");

    $response->assertStatus(200)
        ->assertJsonFragment(['title' => $task->title]);
});

it('can update a task', function () {
    $user = User::factory()->create();
    loginApi($user);

    $category1 = Category::factory()->create();
    $category2 = Category::factory()->create();
    $task = Task::factory()->create([
        'user_id' => $user->id,
        'category_id' => $category1->id
    ]);


    $response = $this->putJson("/api/tasks/{$task->id}", [
        'title' => 'Updated Task',
        'description' => 'Updated Description',
        'category_id' => $category2->id,
        'status' => 'In Progress',
    ]);

    $response->assertStatus(200)
        ->assertJsonFragment(['title' => 'Updated Task']);

    $this->assertDatabaseHas('tasks', ['title' => 'Updated Task']);
    $this->assertDatabaseHas('tasks', ['category_id' => $category2->id]);
});

it('can delete a task', function () {

    $user = User::factory()->create();
    loginApi($user);

    $task = Task::factory()->create(['user_id' => $user->id]);

    $response = $this->deleteJson("/api/tasks/{$task->id}");

    $response->assertStatus(204);

    $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
});

it('can update a task\'s status', function () {
    $user = User::factory()->create();
    loginApi($user);

    $task = Task::factory()->create(['user_id' => $user->id]);

    $response = $this->postJson("/api/tasks/{$task->id}/update-status", [
        'status' => 'In Progress',
    ]);

    $response->assertStatus(200)
        ->assertJsonFragment(['status' => 'In Progress']);

    $this->assertDatabaseHas('tasks', ['status' => 'In Progress']);
});
