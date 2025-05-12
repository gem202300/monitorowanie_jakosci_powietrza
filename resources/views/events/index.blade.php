<x-app-layout>
  <x-slot name="header">
      <div class="flex justify-between items-center">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              Lista wydarzeń
          </h2>
          @can('create', \App\Models\Event::class)
              <a href="{{ route('events.create') }}"
                 class="inline-block px-4 py-2 border border-gray-400 rounded-md bg-gray-800 text-gray-100 hover:bg-gray-700 transition">
                  {{ __('events.actions.create') }}
              </a>
          @endcan
      </div>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-2">
              <livewire:events.event-table />
          </div>
      </div>
  </div>
</x-app-layout>
