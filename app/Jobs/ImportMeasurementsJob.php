<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Device;
use App\Models\Parameter;
use App\Models\Measurement;
use App\Models\MeasurementValue;
use Carbon\Carbon;

class ImportMeasurementsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
    protected $userId;

    public function __construct($filePath, $userId)
    {
        $this->filePath = $filePath;
        $this->userId = $userId;
    }

    public function handle()
{
    $data = json_decode(file_get_contents($this->filePath), true);

    if (!is_array($data)) {
        Cache::put("import_progress_{$this->userId}", 0);
        return;
    }

    $total = count($data);
    $current = 0;

    foreach ($data as $entry) {
        $current++;
        $progress = intval(($current / $total) * 100);
        Cache::put("import_progress_{$this->userId}", $progress);
        $deviceIdNumber = (int) filter_var($entry['devid'], FILTER_SANITIZE_NUMBER_INT);

        $device = Device::find($deviceIdNumber);

        if (!$device) continue;

        $createdAt = Carbon::createFromFormat('d.m.Y H:i', $entry['created_at']);

        // Параметри — беремо тільки ті, що є у базі для цього пристрою
        $parameters = collect($entry)->except(['devid', 'created_at']);

        $measurement = Measurement::create([
            'device_id' => $device->id,
            'date_time' => $createdAt,
        ]);

        foreach ($parameters as $key => $value) {
            $parameter = $device->parameters()->where('name', $key)->first();

            if (!$parameter) continue;

            MeasurementValue::create([
                'measurement_id' => $measurement->id,
                'parameter_id' => $parameter->id,
                'value' => str_replace(',', '.', $value),
            ]);
        }
    }

    Cache::put("import_progress_{$this->userId}", 100);
}

}
