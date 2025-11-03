<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Notifications
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-6">
        @if($notifications->isEmpty())
        <p>No notifications.</p>
        @else
        <div class="divide-y divide-gray-200">
            @foreach($notifications as $notification)
            <div class="flex justify-between items-center p-4 cursor-pointer hover:bg-gray-50"
                onclick="window.location='{{ route('notifications.show', $notification->id) }}'">

                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">
                        {{ $notification->data['title'] }}
                    </p>
                    <p class="text-sm text-gray-500 truncate">
                        {{ $notification->data['body'] }}
                    </p>
                    <p class="text-xs text-gray-400">
                        {{ $notification->created_at->diffForHumans() }}
                    </p>
                </div>

                <div class="flex space-x-2 ml-4">
                    @if(is_null($notification->read_at))
                    <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-sm text-blue-600 hover:underline">
                            Mark as read
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <form action="{{ route('notifications.markAllAsRead') }}" method="POST" class="mt-4">
            @csrf
            <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Mark all as read
            </button>
        </form>
        @endif
    </div>
</x-app-layout>