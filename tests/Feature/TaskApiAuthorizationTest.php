<?php

use Laravel\Sanctum\Sanctum;
use App\Models\User;
use App\Models\Task;
use App\Models\Category;

it('prevents unauthorized user from getting a task', function () {
    $user1 = User::factory()->create();

    $category = Category::factory()->create();

    $task = Task::factory()->create([
        'user_id' => $user1->id,
        'category_id' => $category->id
    ]);


    $user2 = User::factory()->create();
    Sanctum::actingAs($user2);

    $response = $this->getJson("/api/tasks/{$task->id}");
    $response->assertStatus(403);
});

it('prevents unauthorized user from updating a task', function () {
    $user1 = User::factory()->create();

    $category = Category::factory()->create();

    $task = Task::factory()->create([
        'user_id' => $user1->id,
        'category_id' => $category->id
    ]);

    $user2 = User::factory()->create();
    Sanctum::actingAs($user2);

    $response = $this->putJson("/api/tasks/{$task->id}", [
        'title' => 'Updated Task',
    ]);
    $response->assertStatus(403);
});

it('prevents unauthorized user from deleting a task', function () {
    $user1 = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user1->id]);

    $user2 = User::factory()->create();
    Sanctum::actingAs($user2);

    $response = $this->deleteJson("/api/tasks/{$task->id}");
    $response->assertStatus(403);
});

it('prevents unauthorized user from updating a task\'s status', function () {
    $user1 = User::factory()->create();

    $category = Category::factory()->create();

    $task = Task::factory()->create([
        'user_id' => $user1->id,
        'category_id' => $category->id
    ]);

    $user2 = User::factory()->create();
    Sanctum::actingAs($user2);

    $response = $this->postJson("/api/tasks/{$task->id}/update-status", [
        'status' => 'Completed',
    ]);
    $response->assertStatus(403);
});
