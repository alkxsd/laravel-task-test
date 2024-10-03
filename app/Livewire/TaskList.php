<?php

namespace App\Livewire;

use App\Services\TaskService;
use Livewire\Component;

class TaskList extends Component
{
    public $tasks;

    protected $listeners = ['taskUpdated' => '$refresh'];

    public function mount(TaskService $taskService) {
        $this->tasks = $taskService->getTasksForUser(auth()->user());
    }

    public function render()
    {
        return view('livewire.task-list');
    }
}
