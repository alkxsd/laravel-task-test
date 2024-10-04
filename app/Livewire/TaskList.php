<?php

namespace App\Livewire;

use WireUi\Traits\WireUiActions;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Services\TaskService;
use App\Services\CategoryService;
use App\DTO\TaskFilterDto;
use App\Traits\Task\Filterable as TaskFilterable;
use stdClass;

class TaskList extends Component
{
    use WithPagination, WireUiActions, TaskFilterable;

    protected $taskService;
    public $search = '';
    public $status = '';
    public $category_id = 0;
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
        $taskFilterDto = TaskFilterDto::fromLivewire($this); // Create DTO from component

        $query = $this->filterTasks($taskFilterDto, $this->taskService);

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
