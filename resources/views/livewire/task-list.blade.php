<div>
    <ul>
        @foreach ($tasks as $task)
            <li>
                <livewire:task-item :task="$task" :wire:key="$task->id">
            </li>
        @endforeach
    </ul>
</div>
