<div>
    <x-card title="Create Task" class="mt-4">
        <div class="mt-4">
            <x-input label="Title" wire:model.defer="title" />
            <x-textarea label="Description" wire:model.defer="description" />

            <x-select label="Category" wire:model.defer="category_id" :options="$categories" option-label="name" option-value="id" />

            <div class="mt-4">
                <x-button color="blue" label="Save" primary wire:click="createTask" />
                <x-button light secondary label="Cancel" wire:click="goToTaskList" />
            </div>
        </div>
    </x-card>
</div>
