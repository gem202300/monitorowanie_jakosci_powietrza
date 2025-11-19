<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Historia przypisań urządzenia: {{ $device->name }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto space-y-6">
        <div class="bg-white shadow rounded p-6 text-black">
            <table class="min-w-full table-auto border-collapse border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-3 py-2 text-left">Kto przypisał</th>
                        <th class="border px-3 py-2 text-left">Kogo przypisano</th>
                        <th class="border px-3 py-2 text-left">Data przypisania</th>
                        <th class="border px-3 py-2 text-left">Data odpisania</th>
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
                            <td colspan="4" class="border px-3 py-2 text-center">Brak historii przypisań</td>
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
