<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">
                {{ __('service_reports.report_details') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back button -->
        <div class="mb-4">
            <a href="{{ route('service-reports.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg shadow transition">
                ← {{ __('service_reports.back_to_list') }}
            </a>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-6">
            <!-- Device Information Card -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('service_reports.device_information') }}</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">{{ __('service_reports.device') }}</label>
                        <p class="mt-1 text-gray-900 font-semibold">{{ $device->name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">{{ __('service_reports.device_status') }}</label>
                        <p class="mt-1">
                            <span class="px-2 py-1 text-sm rounded {{ $device->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($device->status) }}
                            </span>
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">{{ __('service_reports.device_address') }}</label>
                        <p class="mt-1 text-gray-900">{{ $device->address }}</p>
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('service_reports.total_reports') }}: 
                        <span class="text-red-600 font-bold">{{ $reports->count() }}</span>
                    </label>
                </div>
            </div>

            <!-- All Reports List Card -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('service_reports.all_reports_for_device') }}</h3>
                
                <div class="space-y-4">
                    @foreach($reports as $index => $report)
                    <div class="border-l-4 border-blue-500 bg-gray-50 p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-semibold text-gray-900">{{ __('service_reports.report') }} #{{ $index + 1 }}</h4>
                            <span class="text-sm text-gray-500">{{ $report->created_at->format('Y-m-d H:i') }}</span>
                        </div>
                        
                        <div class="space-y-2">
                            <div>
                                <span class="text-sm font-medium text-gray-700">{{ __('service_reports.reason') }}:</span>
                                <span class="text-sm text-gray-900">{{ $report->reason }}</span>
                            </div>
                            
                            @if($report->description)
                            <div>
                                <span class="text-sm font-medium text-gray-700">{{ __('service_reports.description') }}:</span>
                                <p class="text-sm text-gray-900 mt-1">{{ $report->description }}</p>
                            </div>
                            @endif

                            <div>
                                <span class="text-sm font-medium text-gray-700">{{ __('service_reports.reported_by') }}:</span>
                                <span class="text-sm text-gray-900">{{ $report->user->name }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Notes Form Card -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('service_reports.add_notes') }}</h3>
                <p class="text-sm text-gray-600 mb-4">{{ __('service_reports.resolve_all_hint') }}</p>
                
                <form id="resolveForm" action="{{ route('service-reports.resolve', $device) }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('service_reports.notes_label') }}
                        </label>
                        <textarea 
                            id="notes" 
                            name="notes" 
                            rows="10"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('notes') border-red-500 @enderror"
                            placeholder="{{ __('service_reports.notes_placeholder') }}"
                            required
                        >{{ old('notes') }}</textarea>
                        
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        
                        <p class="mt-2 text-sm text-gray-500">
                            {{ __('service_reports.notes_hint') }}
                        </p>
                    </div>

                    <div class="flex justify-end">
                        <button 
                            type="button"
                            onclick="confirmResolve()"
                            class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow transition">
                            {{ __('service_reports.resolve') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">{{ __('service_reports.confirm_resolve_title') }}</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        {{ __('service_reports.confirm_resolve_description') }}
                    </p>
                </div>
                <div class="items-center px-4 py-3 flex gap-2 justify-center">
                    <button 
                        id="cancelButton"
                        onclick="closeModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        {{ __('service_reports.no') }}
                    </button>
                    <button 
                        id="confirmButton"
                        onclick="submitForm()"
                        class="px-4 py-2 bg-green-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                        {{ __('service_reports.yes') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmResolve() {
            // Validate notes field
            const notesField = document.getElementById('notes');
            if (!notesField.value.trim() || notesField.value.trim().length < 10) {
                alert('{{ __('service_reports.notes_required') }}');
                notesField.focus();
                return;
            }
            
            // Show modal
            document.getElementById('confirmModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('confirmModal').classList.add('hidden');
        }

        function submitForm() {
            document.getElementById('resolveForm').submit();
        }

        // Close modal on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });
    </script>
</x-app-layout>

