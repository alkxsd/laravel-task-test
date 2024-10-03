<?php

namespace App\Livewire;

use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Services\TaskService;
use WireUi\Traits\WireUiActions;

class TaskList extends Component
{
    use WithPagination, WireUiActions;

    protected $taskService;

    protected $listeners = [
        'task-updated' => '$refresh',
    ];

    public function boot(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }


    public function mount()
    {

    }

    #[Computed]
    public function tasks()
    {
        return $this->taskService->getTasksForUser(auth()->user())
            ->paginate(10)
            ->withQueryString();
    }

    public function render()
    {
        return view('livewire.task-list');
    }
}
