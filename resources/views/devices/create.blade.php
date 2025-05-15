<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Створення пристрою</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">
        <div class="bg-white shadow-md rounded p-6">
            <livewire:devices.device-form />
        </div>
    </div>
</x-app-layout>
