<?php

use App\Models\Category;
use App\Livewire\TaskForm;

it('can create a new task', function () {
    $category = Category::factory()->create();

    login()->livewire(TaskForm::class)
        ->set('title', 'Test Task')
        ->set('description', 'Test Description')
        ->set('category_id', $category->id)
        ->call('createTask')
        ->assertRedirect(route('tasks.index'))
        ->assertSessionHas('success_message', 'Added new task successfully!');
});

it('can validate task form for errors', function () {
    $category = Category::factory()->create();

    login()->livewire(TaskForm::class)
        ->set('title', '')
        ->set('category_id', '')
        ->call('createTask')
        ->assertHasErrors(['title', 'category_id'])
        ->set('title', 'Test Task')
        ->set('category_id', $category->id)
        ->call('createTask')
        ->assertHasNoErrors(['title', 'category_id']);
});

it('cancel button redirects to task list', function () {
    login()->livewire(TaskForm::class)
        ->call('goToTaskList')
        ->assertRedirect(route('tasks.index'));
});
