<div>
    @if (session('success_message'))
        <x-alert title="{{ session('success_message') }}" positive dismissable />
    @endif
    @if ($this->tasks->count() > 0)
        <ul class="mt-4">
            @foreach ($this->tasks as $task)
                <li>
                    <livewire:task-item :task="$task" :wire:key="$task->id">
                </li>
            @endforeach
        </ul>

        <div class="mt-4">
            {{ $this->tasks->links() }}
        </div>
    @else
        <div class="text-center text-gray-600">
            <p>No tasks yet.</p>
            <p>Please add a new task.</p>
        </div>
    @endif
</div>
