<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Powiadomienia</h2>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            @if($notifications->isEmpty())
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">Brak powiadomień</p>
            </div>
            @else
            <div class="space-y-4">
                @foreach($notifications as $notification)
                <a href="{{ route('notifications.show', $notification->id) }}" class="block">
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition cursor-pointer {{ is_null($notification->read_at) ? 'bg-blue-50' : '' }}">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <h3 class="font-semibold text-gray-900">
                                        {{ $notification->data['title'] ?? 'Powiadomienie' }}
                                    </h3>
                                    @if(is_null($notification->read_at))
                                    <span class="inline-block bg-blue-500 text-white text-xs px-2 py-1 rounded-full">
                                        Nowe
                                    </span>
                                    @endif
                                </div>
                                <p class="text-gray-700 mt-1">
                                    {{ $notification->data['body'] ?? '' }}
                                </p>
                                @if(isset($notification->data['device_report_id']))
                                <div class="mt-2 text-sm text-gray-600">
                                    <p><strong>ID Raportu:</strong> #{{ $notification->data['device_report_id'] }}</p>
                                    <p><strong>Urządzenie:</strong> ID {{ $notification->data['device_id'] }}</p>
                                </div>
                                @endif
                                <p class="text-xs text-gray-400 mt-2">
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>
                            </div>

                            <div class="flex gap-2 ml-4" onclick="event.stopPropagation();">
                                @if(is_null($notification->read_at))
                                <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="border border-gray-400 text-gray-700 hover:bg-gray-200 px-3 py-1 rounded text-sm transition">
                                        Oznacz jako przeczytane
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            @if($notifications->isNotEmpty())
            <div class="mt-6 flex gap-2">
                <form action="{{ route('notifications.markAllAsRead') }}" method="POST" class="inline">
                    @csrf
                    <button class="border border-gray-400 text-gray-700 hover:bg-gray-200 px-4 py-2 rounded transition">
                        Oznacz wszystkie jako przeczytane
                    </button>
                </form>
            </div>
            @endif
            @endif
        </div>
    </div>
</x-app-layout>