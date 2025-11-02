<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Historia awarii i napraw - ') . $device->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <a href="{{ route('devices.index') }}" 
                   class="text-blue-500 hover:underline block mb-4">
                    ← Powrót do listy urządzeń
                </a>

                @if($repairs->isEmpty())
                    <p class="text-gray-600 dark:text-gray-300">Brak zapisów historii.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Typ</th>
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Opis</th>
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Zgłoszono</th>
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Naprawiono</th>
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Serwisant</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($repairs as $repair)
                                    <tr>
                                        <td class="px-4 py-2 text-gray-800 dark:text-gray-200">
                                            {{ $repair->type === 'failure' ? 'Awaria' : 'Naprawa' }}
                                        </td>
                                        <td class="px-4 py-2 text-gray-800 dark:text-gray-200">
                                            {{ $repair->description }}
                                        </td>
                                        <td class="px-4 py-2 text-gray-800 dark:text-gray-200">
                                            {{ $repair->reported_at?->format('Y-m-d H:i') ?? '—' }}
                                        </td>
                                        <td class="px-4 py-2 text-gray-800 dark:text-gray-200">
                                            {{ $repair->resolved_at?->format('Y-m-d H:i') ?? '—' }}
                                        </td>
                                        <td class="px-4 py-2 text-gray-800 dark:text-gray-200">
                                            {{ $repair->user?->name ?? '—' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
