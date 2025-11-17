<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Powiadomienia</h2>
            <a href="{{ route('notifications.index') }}"
                class="border border-gray-400 text-gray-700 dark:border-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 px-4 py-2 rounded transition">
                ← Wróć do listy
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">
        <!-- Główna karta z powiadomieniem -->
        <div class="bg-white p-6 rounded shadow mb-6">
            <!-- Nagłówek powiadomienia -->
            <div class="border-b border-gray-200 pb-4 mb-6">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-2xl font-semibold text-gray-900">
                        {{ $notification->data['title'] ?? 'Powiadomienie' }}</h3>
                    @if(!empty($notification->data['type']))
                    <span
                        class="inline-block text-xs px-2 py-1 rounded-full {{ $notification->data['type'] === 'critical' ? 'bg-red-600 text-white' : ($notification->data['type'] === 'warning' ? 'bg-yellow-500 text-white' : ($notification->data['type'] === 'incident' ? 'bg-orange-500 text-white' : 'bg-gray-300 text-black')) }}">
                        {{ strtoupper($notification->data['type']) }}
                    </span>
                    @endif
                </div>
                <p class="text-sm text-gray-600">Utworzono: <span
                        class="font-medium">{{ \Carbon\Carbon::parse($notification->created_at)->format('d.m.Y o H:i') }}</span>
                </p>
            </div>

            <!-- Treść powiadomienia -->
            <div class="mb-6">
                <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-2">Treść</h4>
                <div
                    class="bg-gray-50 border border-gray-200 rounded p-4 text-gray-800 leading-relaxed whitespace-pre-wrap">
                    {!! nl2br(e(str_replace('\\n', "\n", $notification->data['body'] ?? 'Brak treści'))) !!}
                </div>
            </div>

            <!-- Szczegóły jeśli istnieją -->
            @if(count($notification->data) > 2)
            <div class="border-t border-gray-200 pt-6">
                <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">Szczegóły</h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if(isset($notification->data['device_report_id']))
                    <div class="bg-blue-50 border border-blue-200 rounded p-3">
                        <p class="text-xs font-semibold text-blue-900 uppercase mb-1">ID Raportu</p>
                        <p class="text-lg font-medium text-blue-700">#{{ $notification->data['device_report_id'] }}</p>
                    </div>
                    @endif

                    @if(isset($notification->data['device_id']))
                    <div class="bg-purple-50 border border-purple-200 rounded p-3">
                        <p class="text-xs font-semibold text-purple-900 uppercase mb-1">ID Urządzenia</p>
                        <p class="text-lg font-medium text-purple-700">{{ $notification->data['device_id'] }}</p>
                    </div>
                    @endif

                    @if(isset($notification->data['reporter_name']))
                    <div class="bg-green-50 border border-green-200 rounded p-3">
                        <p class="text-xs font-semibold text-green-900 uppercase mb-1">Zgłaszający</p>
                        <p class="text-sm font-medium text-green-700">{{ $notification->data['reporter_name'] }}</p>
                        @if(isset($notification->data['reporter_email']))
                        <p class="text-xs text-green-600">{{ $notification->data['reporter_email'] }}</p>
                        @endif
                    </div>
                    @endif
                </div>

                @if(isset($notification->data['description']))
                <div class="mt-4">
                    <p class="text-xs font-semibold text-gray-700 uppercase tracking-wide mb-2">Pełny opis</p>
                    <div
                        class="bg-gray-50 border border-gray-200 rounded p-4 text-gray-800 text-sm leading-relaxed whitespace-pre-wrap">
                        {!! nl2br(e(str_replace('\\n', "\n", $notification->data['description'] ?? ''))) !!}
                    </div>
                </div>
                @endif
            </div>
            @endif
        </div>

        <!-- Akcje -->
        <div class="flex gap-2">
            <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" class="inline"
                onsubmit="return confirm('Czy na pewno chcesz usunąć to powiadomienie?');">
                @csrf
                @method('DELETE')
                <button class="border border-red-400 text-red-700 hover:bg-red-100 px-4 py-2 rounded transition">
                    Usuń powiadomienie
                </button>
            </form>
        </div>
    </div>
</x-app-layout>