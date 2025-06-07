<div class="max-w-md mx-auto p-4 bg-white rounded shadow">
    <form wire:submit.prevent="import" class="space-y-4">
        <h3 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('import_form.labels.title') ?? 'Importuj plik JSON' }}
        </h3>

        <hr class="my-2">

        <input 
            type="file" 
            wire:model="jsonFile" 
            accept=".json,.txt" 
            class="block w-full border border-gray-300 rounded px-3 py-2"
        />
        @error('jsonFile') <span class="text-danger text-sm">{{ $message }}</span> @enderror

        <div class="flex justify-end space-x-2 pt-4">
            <button type="submit" 
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded transition">
                {{ __('import_form.actions.import') ?? 'Importuj' }}
            </button>
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
            <p class="mt-2 text-gray-600 text-sm">Progres: {{ $this->progress }}%</p>
        @elseif ($this->progress === 100)
            <p class="mt-4 text-green-700 font-semibold">Import zakończony ✅</p>
        @endif
    </div>
</div>
