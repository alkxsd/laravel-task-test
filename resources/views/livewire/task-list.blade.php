<div>
    @if (session('success_message'))
        <x-alert title="{{ session('success_message') }}" positive dismissable />
    @endif
    <div class="flex flex-col">
        <x-input placeholder="Search by title..." wire:model.live.debounce.500ms="search" />
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <x-select
                placeholder="Filter by status..."
                wire:model.live.debounce.300ms="status"
                class="mt-2"
                :options="$statuses"
            />




            <x-select
                placeholder="Filter by category..."
                wire:model.live.debounce.300ms="category_id"
                class="mt-2"
                :options="$categories"
                option-label="name" option-value="id"
            />



        </div>
        <x-button class="w-1/4 mt-2" light blue label="Clear filters" wire:click="clearFilters"/>
    </div>
    @if ($tasks->count() > 0)

        <ul class="mt-4">
            @foreach ($tasks as $task)
                <li>
                    <livewire:task-item
                        :task="$task"
                        :key="$task->getForLivewireKey()"
                    />
                </li>
            @endforeach
        </ul>

        <div class="mt-4">
            {{ $tasks->links() }}
        </div>
    @else
        <div class="text-center text-gray-600">
            <p>No tasks yet.</p>
            <p>Please add a new task.</p>
        </div>
    @endif
</div>
