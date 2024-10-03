<x-card title="{{ $editing ? 'Edit Task' : $task->title }}" rounded="1xl" class="mb-4" shadow="xl">
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
                <x-button label="New" wire:click="updateStatus('New')" :color="$task->status == 'New' ? 'positive' : 'slate'"/>
                <x-button label="In Progress" wire:click="updateStatus('In Progress')" :color="$task->status == 'In Progress' ? 'positive' : 'slate'"/>
                <x-button label="Under Review" wire:click="updateStatus('Under Review')" :color="$task->status == 'Under Review' ? 'positive' : 'slate'"/>
                <x-button label="Completed" wire:click="updateStatus('Completed')" :color="$task->status == 'Completed' ? 'positive' : 'slate'"/>
            </div>
        </x-slot>
    @endif
</x-card>
