<x-app-layout>
    <div id="map-container" style="position: relative; width: 100vw; height: 100vh; overflow: hidden;">
        <div id="map" style="width: 100%; height: 100%;"></div>

        <button
            id="fullscreenBtn"
            style="
                position: absolute;
                top: 12px;
                right: 12px;
                background-color: #e5e7eb;
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
            title="Pełny ekran"
            onclick="toggleFullScreen()"
        >
            <svg id="enterFullScreenIcon" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6" viewBox="0 0 24 24" style="width: 24px; height: 24px;">
                <path d="M8 3H5a2 2 0 00-2 2v3"/>
                <path d="M16 3h3a2 2 0 012 2v3"/>
                <path d="M8 21H5a2 2 0 01-2-2v-3"/>
                <path d="M16 21h3a2 2 0 002-2v-3"/>
            </svg>

            <svg id="exitFullScreenIcon" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6" viewBox="0 0 24 24" style="width: 24px; height: 24px; display:none;">
                <line x1="18" y1="6" x2="6" y2="18" />
                <line x1="6" y1="6" x2="18" y2="18" />
            </svg>
        </button>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        const map = L.map('map').setView([52.2297, 21.0122], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
        }).addTo(map);

        fetch('/api/devices')
            .then(response => response.json())
            .then(devices => {
                devices.forEach(device => {
                    if(device.latitude && device.longitude) {
                        const marker = L.marker([device.latitude, device.longitude], {
                            title: device.name,
                            icon: L.icon({
                                iconUrl: '/images/marker-icon.png',
                                iconSize: [18, 25],
                                iconAnchor: [15, 30],
                                popupAnchor: [0, -30],
                            })
                        }).addTo(map);

                        marker.bindPopup(`<strong>${device.name}</strong>`);
                        marker.on('click', () => {
                            window.location.href = `/devices/${device.id}/measurements`;
                        });
                    }
                });
            })
            .catch(error => console.error('Błąd podczas ładowania urządzeń:', error));

        const mapContainer = document.getElementById('map-container');
        const enterIcon = document.getElementById('enterFullScreenIcon');
        const exitIcon = document.getElementById('exitFullScreenIcon');

        function toggleFullScreen() {
            if (!document.fullscreenElement) {
                mapContainer.requestFullscreen().then(() => {
                    enterIcon.style.display = 'none';
                    exitIcon.style.display = 'block';
                }).catch((err) => {
                    alert(`Nie udało się przełączyć na pełny ekran: ${err.message}`);
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
