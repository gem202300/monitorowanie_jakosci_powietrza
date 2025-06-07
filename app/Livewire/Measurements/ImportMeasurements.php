<?php
namespace App\Livewire\Measurements;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Jobs\ImportMeasurementsJob;

class ImportMeasurements extends Component
{
    use WithFileUploads;

    public $jsonFile;
    public $successMessage;

    public function getProgressProperty()
    {
        return Cache::get("import_progress_" . auth()->id(), 0);
    }

    public function import()
    {
        $this->validate([
            'jsonFile' => 'required|file|mimes:json,txt|max:10240',
        ]);

        $path = $this->jsonFile->store('imports');

        // Скидаємо прогрес
        Cache::put("import_progress_" . auth()->id(), 0);

        // Запускаємо фонову задачу
        ImportMeasurementsJob::dispatch(storage_path("app/{$path}"), auth()->id());

        $this->successMessage = 'Імпорт запущено! Прогрес зʼявиться нижче.';
    }

    public function render()
    {
        return view('livewire.measurements.import-measurements')
        ->layout('layouts.app');
    }
}
