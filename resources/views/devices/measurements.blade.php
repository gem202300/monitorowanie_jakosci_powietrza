<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Pomiary dla urządzenia: {{ $device->name }}
        </h2>
    </x-slot>

    <div x-data="deviceReport()" class="py-6 max-w-7xl mx-auto space-y-6">

        {{-- Інформація про пристрій --}}
        <div class="bg-white shadow rounded p-6">
            <h3 class="text-lg font-semibold mb-2">Informacje o urządzeniu</h3>
            <p><strong>Status:</strong> {{ $device->status }}</p>
            <p><strong>Adres:</strong> {{ $device->address }}</p>
            <p><strong>Współrzędne:</strong> {{ $device->latitude }}, {{ $device->longitude }}</p>

            <button @click="openReportModal()" 
                class="mt-4 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                Zgłoś problem
            </button>
        </div>

        {{-- Модальне вікно --}}
        <div x-show="openReport" x-transition class="fixed inset-0 bg-black bg-opacity-25 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg w-96 p-6 relative" @click.away="closeModal()">
                <h3 class="text-lg font-semibold mb-4">Zgłoś problem</h3>

                <form @submit.prevent="submitReport($event)">
                    @csrf
                    <input type="hidden" name="device_id" value="{{ $device->id }}">
                    
                    <label class="block mb-2">Powód</label>
                    <select name="reason" class="w-full border rounded p-2 mb-4" required>
                        <option value="">Wybierz powód</option>
                        <option value="incorrect_data">Niepoprawne dane</option>
                        <option value="device_offline">Urządzenie nie działa</option>
                        <option value="other">Inne</option>
                    </select>

                    <label class="block mb-2">Opis</label>
                    <textarea name="description" class="w-full border rounded p-2 mb-4" placeholder="Opcjonalny opis..."></textarea>

                    {{-- Повідомлення --}}
                    <template x-if="message">
                        <div :class="{'text-green-600': success, 'text-red-600': !success}" class="mb-2">
                            <span x-text="message"></span>
                        </div>
                    </template>

                    <div class="flex justify-end space-x-2">
                        <button type="button" @click="closeModal()" class="px-3 py-1 rounded border">Anuluj</button>
                        <button type="submit" class="px-3 py-1 bg-blue-500 text-white rounded">Wyślij</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Параметри та вимірювання залишаються без змін --}}
        <div class="bg-white shadow rounded p-6">
            <h3 class="text-lg font-semibold mb-2">Parametry</h3>
            <ul class="list-disc list-inside">
                @foreach($device->parameters as $parameter)
                    <li>{{ $parameter->name }} ({{ $parameter->label }}) — Jednostka: {{ $parameter->unit }}, Typ: {{ $parameter->valueType }}</li>
                @endforeach
            </ul>
        </div>

        <div class="bg-white shadow rounded p-6">
            <h3 class="text-lg font-semibold mb-2">Pomiary</h3>
            @if($measurements->isEmpty())
                <p>Brak pomiarów dla tego urządzenia.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto border-collapse border border-gray-300">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border p-2 text-left">Data/Czas</th>
                                @foreach($parameters as $parameter)
                                    <th class="border p-2 text-left">{{ $parameter->name }} ({{ $parameter->unit }})</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($measurements as $measurement)
                                <tr class="odd:bg-white even:bg-gray-50">
                                    <td class="border p-2">{{ \Carbon\Carbon::parse($measurement->date_time)->format('Y-m-d H:i') }}</td>
                                    @foreach($parameters as $parameter)
                                        @php $value = $measurement->values->firstWhere('parameter_id', $parameter->id); @endphp
                                        <td class="border p-2">{{ $value ? $value->value : 'Brak danych' }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $measurements->links() }}</div>
            @endif
        </div>

    </div>
</x-app-layout>

<script>
function deviceReport() {
    return {
        openReport: false,
        message: '',
        success: false,

        openReportModal() {
            this.openReport = true;
            this.message = ''; 
            this.success = false;
        },

        closeModal() {
            this.openReport = false;
            this.message = ''; 
            this.success = false;
        },

        submitReport(event) {
            const form = event.target;
            const formData = new FormData(form);

            fetch("{{ route('device-reports.store') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': formData.get('_token'),
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(async res => {
                if (!res.ok) {
                    let errData = await res.json().catch(() => null);
                    throw new Error(errData?.message || 'Błąd podczas wysyłania');
                }
                return res.json();
            })
            .then(data => {
                this.message = data.message;
                this.success = true;
                form.reset();
                setTimeout(() => this.closeModal(), 1500);
            })
            .catch(err => {
                this.message = err.message;
                this.success = false;
            });
        }
    }
}
</script>
