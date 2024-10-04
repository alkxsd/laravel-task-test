<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-2 lg:px-6">
            <div class="overflow-hidden sm:rounded-lg p-6">
                <x-button icon="plus" color="teal" class="w-full mb-10" label="Add New Task" primary href="{{ route('tasks.create') }}" />
                <livewire:task-list />
            </div>
        </div>
    </div>
</x-app-layout>
