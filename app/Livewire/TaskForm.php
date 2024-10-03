<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\TaskService;
use App\Services\CategoryService;
use App\DTO\TaskDto;

class TaskForm extends Component
{
    public $title;
    public $description;
    public $category_id;
    public $categories;
    public $showForm = false;

    public function mount(CategoryService $categoryService)
    {
        $this->categories = $categoryService->getCategories();
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
        $this->reset(['title', 'description', 'category_id']);
    }

    public function createTask(TaskService $taskService)
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $taskDto = new TaskDto(
            title: $this->title,
            description: $this->description,
            categoryId: $this->category_id,
            status: 'New',
        );

        $taskService->createTask(auth()->user(), $taskDto);
        return redirect()->route('tasks.index')->with('success_message', 'Added new task successfully!');
    }

    public function goToTaskList()
    {
        return redirect()->route('tasks.index');
    }

    public function render()
    {
        return view('livewire.task-form');
    }
}
