<x-app-layout>
    <x-slot name="header">
            <h2 class="font-semibold text-xl text-white leading-tight"> <!-- змінили text-gray-800 на text-white -->
            {{ __('devices.repairs.title_prefix') . $device->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white text-gray-900 overflow-hidden shadow-xl sm:rounded-lg p-6">

                <!-- Кнопка назад з чорним текстом -->
                <a href="{{ route('devices.index') }}" 
                   class="inline-block mb-4 px-4 py-2 bg-blue-600 text-black font-semibold rounded-lg shadow hover:bg-blue-700 transition">
                    {{ __('devices.repairs.back_to_devices') }}
                </a>

                @if($repairs->isEmpty())
                    <p class="text-gray-700">{{ __('devices.repairs.no_records') }}</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left text-sm font-semibold">{{ __('devices.repairs.type_heading') }}</th>
                                    <th class="px-4 py-2 text-left text-sm font-semibold">{{ __('devices.repairs.description') }}</th>
                                    <th class="px-4 py-2 text-left text-sm font-semibold">{{ __('devices.repairs.reported_at') }}</th>
                                    <th class="px-4 py-2 text-left text-sm font-semibold">{{ __('devices.repairs.resolved_at') }}</th>
                                    <th class="px-4 py-2 text-left text-sm font-semibold">{{ __('devices.repairs.serviceman') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($repairs as $repair)
                                    <tr>
                                        <td class="px-4 py-2">{{ $repair->type === 'failure' ? __('devices.repairs.type.failure') : __('devices.repairs.type.repair') }}</td>
                                        <td class="px-4 py-2">{{ $repair->description }}</td>
                                        <td class="px-4 py-2">
                                            {{ $repair->reported_at ? $repair->reported_at->format('Y-m-d H:i') : '—' }}
                                        </td>
                                        <td class="px-4 py-2">
                                            {{ $repair->resolved_at ? $repair->resolved_at->format('Y-m-d H:i') : '—' }}
                                        </td>
                                        <td class="px-4 py-2">{{ $repair->user?->name ?? '—' }}</td>
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
