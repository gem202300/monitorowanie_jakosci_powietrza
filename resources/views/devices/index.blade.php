<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Список пристроїв</h2>
            <a href="{{ route('devices.create') }}"
               class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded transition">
                ➕ Додати пристрій
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">
        <div class="bg-white p-4 rounded shadow">
            <livewire:devices.device-table />
        </div>
    </div>
</x-app-layout>
