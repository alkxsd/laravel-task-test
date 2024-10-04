<?php

namespace App\Livewire;

use WireUi\Traits\WireUiActions;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Services\TaskService;
use App\Services\CategoryService;

class TaskList extends Component
{
    use WithPagination, WireUiActions;

    protected $taskService;
    public $search = '';
    public $status = '';
    public $category_id = '';
    public $categories;

    protected $listeners = [
        'task-updated' => '$refresh',
    ];

    public function boot(TaskService $taskService, CategoryService $categoryService)
    {
        $this->taskService = $taskService;
        $this->categories = $categoryService->getCategories();
    }


    public function mount()
    {

    }

    public function clearFilters()
    {
        $this->search = '';
        $this->status = '';
        $this->category_id = '';
    }

    public function getTasksProperty()
    {
        $query = $this->taskService->getTasksForUser(auth()->user());

        // Search by task title
        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }
        // Filter by task status
        if ($this->status) {
            $query->where('status', $this->status);
        }
        // Filter by category
        if ($this->category_id) {
            $query->where('category_id', $this->category_id);
        }

        return $query->paginate(10)
            ->withQueryString();
    }

    public function render()
    {
        return view('livewire.task-list', [
            'tasks' => $this->tasks,
            'categories' =>  $this->categories,
            'statuses' => $this->taskService->getStatuses()
        ]);
    }
}
