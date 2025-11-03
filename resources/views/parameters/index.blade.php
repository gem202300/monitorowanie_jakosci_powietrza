<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Parameter</h2>

            @can('parameter_manage')
               <a href="{{ route('parameters.create') }}"
                class="border border-gray-400 text-gray-700 dark:border-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 px-4 py-2 rounded transition">
                  Dodaj parameter
              </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">
        <div class="bg-white p-4 rounded shadow">
            <livewire:parameters.parameter-table />
        </div>
    </div>
</x-app-layout>
