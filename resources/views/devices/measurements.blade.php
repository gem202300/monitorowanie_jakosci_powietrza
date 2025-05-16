<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Pomiary dla urządzenia: {{ $device->name }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto space-y-6">
        <div class="bg-white shadow rounded p-6">
            <h3 class="text-lg font-semibold mb-2">Informacje o urządzeniu</h3>
            <p><strong>Status:</strong> {{ $device->status }}</p>
            <p><strong>Adres:</strong> {{ $device->address }}</p>
            <p><strong>Współrzędne:</strong> {{ $device->latitude }}, {{ $device->longitude }}</p>
        </div>

        <div class="bg-white shadow rounded p-6">
            <h3 class="text-lg font-semibold mb-2">Parametry</h3>
            <ul class="list-disc list-inside">
                @foreach($device->parameters as $parameter)
                    <li>
                        {{ $parameter->name }} ({{ $parameter->label }}) —
                        Jednostka: {{ $parameter->unit }},
                        Typ: {{ $parameter->valueType }}
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="bg-white shadow rounded p-6">
            <h3 class="text-lg font-semibold mb-2">Pomiary</h3>

            @if($device->measurements->isEmpty())
                <p>Brak pomiarów dla tego urządzenia.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto border-collapse border border-gray-300">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border p-2 text-left">Data/Czas</th>
                                @foreach($device->parameters as $parameter)
                                    <th class="border p-2 text-left">
                                        {{ $parameter->name }} ({{ $parameter->unit }})
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($device->measurements as $measurement)
                                <tr class="odd:bg-white even:bg-gray-50">
                                    <td class="border p-2">
                                        {{ \Carbon\Carbon::parse($measurement->date_time)->format('Y-m-d H:i') }}
                                    </td>
                                    @foreach($device->parameters as $parameter)
                                        @php
                                            $value = $measurement->values->firstWhere('parameter_id', $parameter->id);
                                        @endphp
                                        <td class="border p-2">
                                            {{ $value ? $value->value : 'Brak danych' }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
