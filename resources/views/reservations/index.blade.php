<x-app-layout>
  <x-slot name="header">
      <div class="flex justify-between items-center">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              Rezerwacje dla wydarzenia: {{ request()->get('event_name', 'Nieznane wydarzenie') }}
          </h2>
          <a href="{{ route('events.index') }}"
             class="inline-block px-4 py-2 border border-gray-400 rounded-md bg-gray-800 text-gray-100 hover:bg-gray-700 transition">
              Powrót do wydarzeń
          </a>
          
      </div>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-2">
              <livewire:reservations.reservation-table />
          </div>
      </div>
  </div>
</x-app-layout>
