<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($parameter->id) ? __('parameters.labels.edit_form_title') : __('parameters.labels.create_form_title') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-6">
                @if (isset($parameter->id))
                    <livewire:parameters.parameter-form :parameter="$parameter" />
                @else
                    <livewire:parameters.parameter-form />
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
