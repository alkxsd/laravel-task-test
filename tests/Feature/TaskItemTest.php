<?php

use App\Models\Task;
use App\Models\Category;
use App\Livewire\TaskItem;

test('can edit a task', function () {
    $category1 = Category::factory()->create();
    $category2 = Category::factory()->create();

    $task = Task::factory()->create(['category_id' => $category1->id]);
    login()->livewire(TaskItem::class, ['task' => $task])
        ->call('toggleEdit')
        ->assertSet('editing', true)
        ->set('editTitle', 'Updated Title')
        ->set('editDescription', 'Updated Description')
        ->set('editCategoryId', $category2->id)
        ->call('updateTask')
        ->assertSet('editing', false);

    $this->assertDatabaseHas('tasks', [
        'id' => $task->id,
        'title' => 'Updated Title',
        'description' => 'Updated Description',
        'category_id' => $category2->id,
    ]);
});

test('can delete a task', function () {
    $task = Task::factory()->create();
    login()->livewire(TaskItem::class, ['task' => $task])
        ->call('deleteTask')
        ->call('confirmDelete')
        ->assertRedirect(route('tasks.index'));

    $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
});

test('can update a task\'s status', function () {
    $task = Task::factory()->create(['status' => 'New']);
    login()->livewire(TaskItem::class, ['task' => $task])
        ->call('updateStatus', 'In Progress');

    $this->assertDatabaseHas('tasks', [
        'id' => $task->id,
        'status' => 'In Progress',
    ]);
});
