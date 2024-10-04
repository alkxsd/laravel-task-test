<x-card rounded="1xl" class="mb-4" shadow="xl">
    @php
        $statusColor = match ($task->status) {
            'New' => 'rose',
            'In Progress' => 'blue',
            'Under Review' => 'amber',
            default => 'emerald',
        };
    @endphp
    <x-slot name="title" class="!font-bold">
        <x-badge class="mr-2" :color="$statusColor" label="{{ $task->status }}" />{{ $task->title }}
    </x-slot>
    <x-slot name="action">
        <x-badge outline :color="$task->category->color ?? 'black'" label="{{ $task->category->name }}" />
    </x-slot>
    @if ($editing)
        <div class="mt-4">
            <x-input label="Title" wire:model.defer="editTitle" />
            <x-textarea label="Description" wire:model.defer="editDescription" />

            <x-select label="Category" wire:model.defer="editCategoryId" :options="$categories" option-label="name" option-value="id" />

            <div class="mt-4">
                <x-button label="Save" primary wire:click="updateTask" />
                <x-button label="Cancel" flat wire:click="toggleEdit" />
            </div>
        </div>
    @else
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
    @endif
</x-card>
