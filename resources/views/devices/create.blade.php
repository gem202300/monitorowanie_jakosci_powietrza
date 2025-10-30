<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($device->id) ? __('devices.labels.edit_form_title') : __('devices.labels.create_form_title') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-6">
                @if (isset($device->id))
                    <livewire:devices.device-form :device="$device" />
                @else
                    <livewire:devices.device-form />
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
