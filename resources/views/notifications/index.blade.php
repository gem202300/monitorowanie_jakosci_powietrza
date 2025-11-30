<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">{{ __('notifications.title') }}</h2>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            <!-- Filter bar - combined type (left) and date (right) -->
            <div class="mb-6 flex items-center justify-between gap-4">
                <!-- Type filter (left) -->
                <div class="flex items-center gap-3">
                    <span
                        class="text-sm text-gray-600 whitespace-nowrap">{{ __('notifications.filter_by_type') }}</span>
                    <div class="flex gap-2">
                        <a href="{{ route('notifications.index', array_filter(['date_from' => $dateFrom, 'date_to' => $dateTo])) }}"
                            class="px-3 py-1 rounded border {{ empty($type) ? 'bg-gray-200' : 'border-gray-200' }}">{{ __('notifications.all') }}</a>
                        @foreach($types as $t)
                        <a href="{{ route('notifications.index', array_merge(['type' => $t], array_filter(['date_from' => $dateFrom, 'date_to' => $dateTo]))) }}"
                            class="px-3 py-1 rounded border {{ ($type === $t) ? 'bg-gray-200' : 'border-gray-200' }}">{{ ucfirst($t) }}</a>
                        @endforeach
                    </div>
                </div>

                <!-- Date filter (right) -->
                <form action="{{ route('notifications.index') }}" method="GET" class="flex items-center gap-2">
                    @if($type)
                    <input type="hidden" name="type" value="{{ $type }}">
                    @endif

                    <span class="text-sm text-gray-600 whitespace-nowrap">{{ __('notifications.from') }}</span>
                    <input type="date" name="date_from" value="{{ $dateFrom }}"
                        class="border border-gray-400 rounded px-2 py-1 text-sm">

                    <span class="text-sm text-gray-600 whitespace-nowrap">{{ __('notifications.to') }}</span>
                    <input type="date" name="date_to" value="{{ $dateTo }}"
                        class="border border-gray-400 rounded px-2 py-1 text-sm">

                    <button type="submit"
                        class="bg-blue-500 text-white hover:bg-blue-600 px-4 py-1 rounded text-sm transition font-semibold">
                        {{ __('notifications.filter') }}
                    </button>

                    @if($dateFrom || $dateTo)
                    <a href="{{ route('notifications.index', array_filter(['type' => $type])) }}"
                        class="bg-gray-500 text-white hover:bg-gray-600 px-4 py-1 rounded text-sm transition font-semibold">
                        {{ __('notifications.clear') }}
                    </a>
                    @endif
                </form>
            </div>

            @if($notifications->isEmpty())
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">{{ __('notifications.none') }}</p>
            </div>
            @else
            <div class="space-y-4">
                @foreach($notifications as $notification)
                <a href="{{ route('notifications.show', $notification->id) }}" class="block">
                    <div
                        class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition cursor-pointer {{ is_null($notification->read_at) ? 'bg-blue-50' : '' }}">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <h3 class="font-semibold text-gray-900">
                                        {{ $notification->data['title'] ?? __('notifications.default_title') }}
                                    </h3>
                                    @if(!empty($notification->data['type']))
                                    <span
                                        class="inline-block text-xs px-2 py-1 rounded-full {{ $notification->data['type'] === 'critical' ? 'bg-red-600 text-white' : ($notification->data['type'] === 'warning' ? 'bg-yellow-500 text-white' : ($notification->data['type'] === 'incident' ? 'bg-orange-500 text-white' : 'bg-gray-300 text-black')) }}">
                                        {{ strtoupper($notification->data['type']) }}
                                    </span>
                                    @endif
                                    @if(is_null($notification->read_at))
                                    <span class="inline-block bg-blue-500 text-white text-xs px-2 py-1 rounded-full">
                                        {{ __('notifications.new_badge') }}
                                    </span>
                                    @endif
                                </div>
                                <p class="text-gray-700 mt-1">
                                    {!! nl2br(e(str_replace('\n', "\n", $notification->data['body'] ?? ''))) !!}
                                </p>
                                @if(isset($notification->data['device_report_id']))
                                <div class="mt-2 text-sm text-gray-600">
                                    <p><strong>{{ __('notifications.report_id') }}:</strong>
                                        #{{ $notification->data['device_report_id'] }}</p>
                                    <p><strong>{{ __('notifications.device_id') }}:</strong>
                                        {{ $notification->data['device_id'] }}</p>
                                </div>
                                @endif
                                <p class="text-xs text-gray-400 mt-2">
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>
                            </div>

                            <div class="flex gap-2 ml-4" onclick="event.stopPropagation();">
                                @if(is_null($notification->read_at))
                                <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="border border-gray-400 text-gray-700 hover:bg-gray-200 px-3 py-1 rounded text-sm transition">
                                        {{ __('notifications.mark_read') }}
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
                        {{ __('notifications.mark_all_read') }}
                    </button>
                </form>
            </div>
            @endif
            @endif
        </div>
    </div>
</x-app-layout>