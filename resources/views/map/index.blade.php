<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Карта якості повітря') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-4">
                    <div id="map" class="rounded-xl shadow" style="height: 500px;"></div>
                    <button onclick="toggleFullScreen()" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        На весь екран
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet CDN -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- Карта JS -->
    <script>
        const map = L.map('map').setView([52.2297, 21.0122], 12); // Варшава

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
        }).addTo(map);

        function toggleFullScreen() {
            const mapDiv = document.getElementById('map');
            if (!document.fullscreenElement) {
                mapDiv.requestFullscreen().catch(err => alert(err));
            } else {
                document.exitFullscreen();
            }
        }
    </script>
</x-app-layout>
