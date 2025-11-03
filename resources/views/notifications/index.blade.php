<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Notifications') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @forelse(Auth::user()->notifications as $notification)
            <div class="bg-white dark:bg-gray-800 p-4 shadow rounded-lg">
                <div class="flex justify-between items-center">
                    <div>
                        <strong>{{ $notification->data['title'] ?? 'No Title' }}</strong>
                        <p>{{ $notification->data['body'] ?? '' }}</p>
                    </div>
                    <div>
                        @if(!$notification->read_at)
                        <span class="text-xs text-red-600 font-bold">New</span>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <p class="text-gray-500 dark:text-gray-400">No notifications</p>
            @endforelse
        </div>
    </div>
</x-app-layout>