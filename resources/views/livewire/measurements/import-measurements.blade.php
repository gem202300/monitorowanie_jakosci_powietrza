<div class="py-6 max-w-7xl mx-auto">
    <div class="bg-white p-6 rounded shadow">
        <form wire:submit.prevent="import" class="space-y-4">
            <h3 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('measurement.import_title') ?? 'Importuj plik JSON' }}
            </h3>

            <hr class="my-2">

            <x-wireui-input
                type="file"
                label="{{ __('measurement.select_file') ?? 'Wybierz plik' }}"
                wire:model="jsonFile"
                accept=".json,.txt"
                :error="$errors->first('jsonFile')"
                class="pt-1"
            />

            @error('jsonFile')
                <div class="text-sm text-red-600">{{ $message }}</div>
            @enderror

            <div class="flex justify-end pt-4 space-x-2">
                <x-wireui-button
                    type="submit"
                    primary
                    label="{{ __('measurement.import_button') ?? 'Importuj' }}"
                    spinner
                />
            </div>
        </form>

        @if ($successMessage)
            <div class="mt-4 text-green-600 font-medium">{{ $successMessage }}</div>
        @endif

        <div wire:poll.1000ms class="mt-6">
            @if ($this->progress > 0 && $this->progress < 100)
                <div class="bg-gray-200 rounded h-4 overflow-hidden">
                    <div class="bg-blue-600 h-full transition-all duration-300" style="width: {{ $this->progress }}%"></div>
                </div>
                <p class="mt-2 text-gray-600 text-sm">{{ __('measurement.progress') }} {{ $this->progress }}%</p>
            @elseif ($this->progress === 100)
                <p class="mt-4 text-green-700 font-semibold">{{ __('measurement.finished') }}</p>
            @endif
        </div>
    </div>
</div>
