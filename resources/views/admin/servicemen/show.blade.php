<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Serviceman Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white text-black shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">{{ $serviceman->name }}</h3>
                <p>Email: {{ $serviceman->email }}</p>

                <h4 class="mt-6 font-semibold">Assign Device</h4>
                <form action="{{ route('servicemen.assign', $serviceman) }}" method="POST" class="mt-2">
                    @csrf
                    <select name="device_id" class="border rounded px-2 py-1 w-full">
                        @foreach($devices as $device)
                            @if(!$serviceman->devices->contains($device->id))
                                <option value="{{ $device->id }}">{{ $device->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    <button type="submit" class="mt-2 bg-green-500 text-white px-3 py-1 rounded">Assign Device</button>
                </form>

                <h4 class="mt-6 font-semibold">Currently Assigned Devices</h4>
                <ul class="mt-2">
                    @foreach($serviceman->devices as $device)
                        <li class="flex justify-between items-center border p-2 rounded mb-1">
                            {{ $device->name }}
                            <form action="{{ route('servicemen.unassign', $serviceman) }}" method="POST">
                                @csrf
                                <input type="hidden" name="device_id" value="{{ $device->id }}">
                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Unassign</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
