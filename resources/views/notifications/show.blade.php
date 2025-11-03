<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $notification->data['title'] }}
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto py-6">
        <div class="p-6 bg-white dark:bg-gray-800 rounded shadow">
            <p class="text-gray-700 dark:text-gray-200">{{ $notification->data['body'] }}</p>
            <p class="text-xs text-gray-400 mt-2">{{ $notification->created_at->diffForHumans() }}</p>
        </div>

        <div class="mt-4 flex space-x-2">
            <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST">
                @csrf
                <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Mark as read
                </button>
            </form>
            <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    Delete
                </button>
            </form>
        </div>
    </div>
</x-app-layout>