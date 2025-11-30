<x-app-layout>
        <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ __('devices.history.assignment_history_for_device', ['name' => $device->name]) }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto space-y-6">
        <div class="bg-white shadow rounded p-6 text-black">
            <table class="min-w-full table-auto border-collapse border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-3 py-2 text-left">{{ __('devices.history.assigned_by') }}</th>
                        <th class="border px-3 py-2 text-left">{{ __('devices.history.assigned_to') }}</th>
                        <th class="border px-3 py-2 text-left">{{ __('devices.history.assigned_at') }}</th>
                        <th class="border px-3 py-2 text-left">{{ __('devices.history.unassigned_at') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($history as $item)
                        <tr class="odd:bg-white even:bg-gray-50">
                            <td class="border px-3 py-2">{{ $item->assigner->name }}</td>
                            <td class="border px-3 py-2">{{ $item->user->name }}</td>
                            <td class="border px-3 py-2">{{ \Carbon\Carbon::parse($item->assigned_at)->format('Y-m-d H:i') }}</td>
                            <td class="border px-3 py-2">{{ $item->unassigned_at ? \Carbon\Carbon::parse($item->unassigned_at)->format('Y-m-d H:i') : '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="border px-3 py-2 text-center">{{ __('devices.history.no_assignment_history') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $history->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
