<x-app-layout>
    <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('servicemen.title') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white text-black overflow-hidden shadow-xl sm:rounded-lg p-6">

                <!-- Форма пошуку -->
                <form method="GET" action="{{ route('servicemen.index') }}" class="mb-4 flex justify-end">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="{{ __('servicemen.search_placeholder') }}"
                        class="border rounded px-3 py-1 mr-2">
                    <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">{{ __('servicemen.search') }}</button>
                </form>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($servicemen as $serviceman)
                        <div class="border rounded p-4 flex flex-col justify-between">
                            <div>
                                <h3 class="font-bold text-lg">{{ $serviceman->name }}</h3>
                                <p>{{ __('servicemen.email') }} {{ $serviceman->email }}</p>
                                <p>{{ __('servicemen.assigned_devices') }} {{ $serviceman->devices->count() }}</p>
                            </div>
                            <a href="{{ route('servicemen.show', $serviceman) }}" 
                               class="mt-4 inline-block bg-blue-500 text-white px-3 py-1 rounded self-end">
                                {{ __('servicemen.manage_devices') }}
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $servicemen->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
