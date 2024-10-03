@php
    $statusColor = match ($task->status) {
        'New' => 'rose',
        'In Progress' => 'blue',
        'Under Review' => 'amber',
        default => 'emerald',
    };
@endphp
<x-card rounded="1xl" class="mb-4" shadow="xl">

    <x-slot name="title" class="!font-bold">
        <x-badge class="mr-2" :color="$statusColor" label="{{ $task->status }}" />{{ $task->title }}
    </x-slot>

    <x-slot name="action">
        <x-badge outline :color="$task->category->color ?? 'black'" label="{{ $task->category->name }}" />
    </x-slot>
    <p>{{ $task->description }}</p>

    <x-slot name="footer" class="flex items-center justify-between">
        <div>
            <x-button icon="pencil" primary wire:click="toggleEdit" />
            <x-button icon="trash" negative wire:click="deleteTask" />
        </div>

        <div>
            @if ($task->status === 'New')
                <x-button label="Start Progress" wire:click="updateStatus('In Progress')" blue />
            @elseif ($task->status === 'In Progress')
                <x-button label="Move to Review" wire:click="updateStatus('Under Review')" amber />
            @elseif ($task->status === 'Under Review')
                <x-button label="Mark Completed" wire:click="updateStatus('Completed')" emerald />
            @endif
        </div>
    </x-slot>
</x-card>
