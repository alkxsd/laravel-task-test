<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\TaskService;
use App\Services\CategoryService;
use App\Models\Task;
use App\DTO\TaskDto;
use WireUi\Traits\WireUiActions;

class TaskItem extends Component
{
    use WireUiActions;

    public Task $task;
    public $editing = false;
    public $editTitle;
    public $editDescription;
    public $editCategoryId;
    public $categories;

    protected $taskService;

    public function boot(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function mount(Task $task, CategoryService $categoryService)
    {
        $this->task = $task;
        $this->editTitle = $task->title;
        $this->editDescription = $task->description;
        $this->editCategoryId = $task->category_id;
        $this->categories = $categoryService->getCategories();
    }

    public function toggleEdit()
    {
        $this->editing = !$this->editing;
    }

    public function updateTask()
    {
        $this->validate([
            'editTitle' => 'required|string|max:255',
            'editDescription' => 'nullable|string',
            'editCategoryId' => 'required|exists:categories,id',
        ]);

        $taskDto = new TaskDto(
            title: $this->editTitle,
            description: $this->editDescription,
            categoryId: $this->editCategoryId,
            status: $this->task->status, // Keep the existing status
        );

        $this->taskService->updateTask($this->task, $taskDto);

        $this->editing = false;
        $this->dispatch('task-updated');
        $this->notification()->success(
            $title = 'Success!',
            $description = 'Task has been updated!'
        );
    }

    public function deleteTask()
    {
        $this->dialog()->confirm([
            'title'       => 'Are you sure?',
            'description' => 'This task will be permanently deleted.',
            'icon'        => 'error',
            'accept'      => [
                'label'  => 'Yes, delete it',
                'method' => 'confirmDelete', // Call this method on confirmation
            ],
            'reject' => [
                'label'  => 'No, cancel',
            ],
        ]);
    }

    public function confirmDelete()
    {
        $this->taskService->deleteTask($this->task);
        redirect(route('tasks.index'));
    }

    public function updateStatus($newStatus)
    {
        $this->taskService->updateTaskStatus($this->task, $newStatus);
        $this->dispatch('task-updated');
        $this->notification()->success(
            $title = 'Success!',
            $description = 'The task status updated to "' . $newStatus .'"'
        );
    }

    public function render()
    {
        return view('livewire.task-item');
    }
}
