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
                    <!-- Контейнер карти з відносним позиціонуванням -->
                    <div id="map-container" style="position: relative; height: 500px; border-radius: 0.75rem; overflow: hidden;">
                        <div id="map" style="width: 100%; height: 100%;"></div>

                        <!-- Кнопка fullscreen поверх карти -->
                        <button
                            id="fullscreenBtn"
                            style="
                                position: absolute;
                                top: 12px;
                                right: 12px;
                                background-color: #e5e7eb; /* tailwind blue-600 */
                                color: rgb(0, 0, 0);
                                border: none;
                                border-radius: 9999px;
                                width: 40px;
                                height: 40px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                cursor: pointer;
                                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                                z-index: 9999;
                            "
                            title="На весь екран"
                            onclick="toggleFullScreen()"
                        >
                            <!-- Іконка для входу в повноекранний режим -->
                            <svg id="enterFullScreenIcon" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6" viewBox="0 0 24 24" style="width: 24px; height: 24px;">
                                <path d="M8 3H5a2 2 0 00-2 2v3"/>
                                <path d="M16 3h3a2 2 0 012 2v3"/>
                                <path d="M8 21H5a2 2 0 01-2-2v-3"/>
                                <path d="M16 21h3a2 2 0 002-2v-3"/>
                            </svg>

                            <!-- Іконка для виходу з повноекранного режиму (прихована спочатку) -->
                            <svg id="exitFullScreenIcon" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6" viewBox="0 0 24 24" style="width: 24px; height: 24px; display:none;">
                                <line x1="18" y1="6" x2="6" y2="18" />
                                <line x1="6" y1="6" x2="18" y2="18" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet CSS та JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        const map = L.map('map').setView([52.2297, 21.0122], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
        }).addTo(map);

        const mapContainer = document.getElementById('map-container');
        const enterIcon = document.getElementById('enterFullScreenIcon');
        const exitIcon = document.getElementById('exitFullScreenIcon');

        function toggleFullScreen() {
            if (!document.fullscreenElement) {
                mapContainer.requestFullscreen().then(() => {
                    enterIcon.style.display = 'none';
                    exitIcon.style.display = 'block';
                }).catch((err) => {
                    alert(`Не вдалося перейти у повноекранний режим: ${err.message}`);
                });
            } else {
                document.exitFullscreen().then(() => {
                    enterIcon.style.display = 'block';
                    exitIcon.style.display = 'none';
                });
            }
        }

        document.addEventListener('fullscreenchange', () => {
            if (!document.fullscreenElement) {
                enterIcon.style.display = 'block';
                exitIcon.style.display = 'none';
            }
        });
    </script>
</x-app-layout>
