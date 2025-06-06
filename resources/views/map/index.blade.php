<x-app-layout>
    <div id="map-container" style="position: relative; width: 100vw; height: 95vh; overflow: hidden;">
        <div id="map" style="width: 100%; height: 100%;"></div>

        <!-- PRZYCISK FILTRA -->
        <button id="toggleFilter"
            style="position: absolute; top: 12px; right: 60px; background-color: #e5e7eb; color: black;
                   border: none; border-radius: 9999px; width: 40px; height: 40px; display: flex;
                   align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                   z-index: 9999;" title="Filtr">🔍</button>

        <!-- PRZYCISK PEŁNEGO EKRANU -->
        <button id="fullscreenBtn"
            style="position: absolute; top: 12px; right: 12px; background-color: #e5e7eb; color: black;
                   border: none; border-radius: 9999px; width: 40px; height: 40px; display: flex;
                   align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                   z-index: 9999;" title="Pełny ekran" onclick="toggleFullScreen()">
            <svg id="enterFullScreenIcon" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="h-6 w-6" viewBox="0 0 24 24" style="width: 24px; height: 24px;">
                <path d="M8 3H5a2 2 0 00-2 2v3"/>
                <path d="M16 3h3a2 2 0 012 2v3"/>
                <path d="M8 21H5a2 2 0 01-2-2v-3"/>
                <path d="M16 21h3a2 2 0 002-2v-3"/>
            </svg>
            <svg id="exitFullScreenIcon" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="h-6 w-6" viewBox="0 0 24 24" style="width: 24px; height: 24px; display:none;">
                <line x1="18" y1="6" x2="6" y2="18" />
                <line x1="6" y1="6" x2="18" y2="18" />
            </svg>
        </button>

        <!-- PANEL FILTRA -->
        <div id="filterPanel" style="display: none; position: absolute; top: 60px; right: 12px; z-index: 9999;
             background: white; padding: 12px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <label>Data/Godzina:</label>
            <input type="datetime-local" id="filterDatetime" />
            <select id="parameterSelect"></select>
            <button onclick="loadFilteredDevices()">Filtruj</button>
        </div>

        <!-- LEGENDA -->
        <div id="legend" style="
            position: absolute;
            bottom: 12px;
            left: 12px;
            background-color: rgba(255,255,255,0.9);
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 14px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            z-index: 9999;
            max-width: 250px;">
            <strong>Legenda:</strong>
            <div id="legend-content">
                Wybierz parametr
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        const map = L.map('map');
        const boundsPoland = L.latLngBounds([[49.0, 14.0], [55.0, 24.5]]);
        map.fitBounds(boundsPoland);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        let markers = [];

        function getMarkerColor(value, parameter) {
            switch (parameter) {
                case 'temperature':
                    if (value >= 35) return 'red';
                    else if (value >= 30) return 'orange';
                    else if (value >= 20) return 'yellow';
                    else return 'green';
                case 'humidity':
                    if (value < 20) return 'red';
                    else if (value < 30) return 'orange';
                    else if (value <= 60) return 'green';
                    else if (value <= 80) return 'yellow';
                    else return 'red';
                case 'pressure':
                    if (value < 980) return 'red';
                    else if (value < 990) return 'orange';
                    else if (value <= 1020) return 'green';
                    else if (value <= 1030) return 'yellow';
                    else return 'red';
                case 'pm1':
                    if (value <= 20) return 'green';
                    else if (value <= 35) return 'yellow';
                    else if (value <= 50) return 'orange';
                    else return 'red';
                case 'pm2_5':
                    if (value <= 25) return 'green';
                    else if (value <= 40) return 'yellow';
                    else if (value <= 50) return 'orange';
                    else return 'red';
                case 'pm10':
                    if (value <= 50) return 'green';
                    else if (value <= 80) return 'yellow';
                    else if (value <= 100) return 'orange';
                    else return 'red';
                default:
                    return 'grey';
            }
        }

        function updateLegend(parameter) {
            const legend = document.getElementById('legend-content');
            let html = '';

            switch (parameter) {
                case 'temperature':
                    html = `
                        <div><img src="/icons/marker-icon-red.png" width="12"> >35°C (Bardzo gorąco)</div>
                        <div><img src="/icons/marker-icon-orange.png" width="12"> 30–35°C (Gorąco)</div>
                        <div><img src="/icons/marker-icon-yellow.png" width="12"> 20–30°C (Normalnie)</div>
                        <div><img src="/icons/marker-icon-green.png" width="12"> <20°C (Chłodno)</div>`;
                    break;
                case 'humidity':
                    html = `
                        <div><img src="/icons/marker-icon-red.png" width="12"> <20% lub >80% (Niebezpieczne)</div>
                        <div><img src="/icons/marker-icon-orange.png" width="12"> 20–30% (Niska)</div>
                        <div><img src="/icons/marker-icon-green.png" width="12"> 30–60% (Optymalna)</div>
                        <div><img src="/icons/marker-icon-yellow.png" width="12"> 60–80% (Wysoka)</div>`;
                    break;
                case 'pressure':
                    html = `
                        <div><img src="/icons/marker-icon-red.png" width="12"> <980 lub >1030 hPa</div>
                        <div><img src="/icons/marker-icon-orange.png" width="12"> 980–990 hPa</div>
                        <div><img src="/icons/marker-icon-green.png" width="12"> 990–1020 hPa</div>
                        <div><img src="/icons/marker-icon-yellow.png" width="12"> 1020–1030 hPa</div>`;
                    break;
                case 'pm1':
                case 'pm2_5':
                case 'pm10':
                    html = `
                        <div><img src="/icons/marker-icon-green.png" width="12"> Dobry</div>
                        <div><img src="/icons/marker-icon-yellow.png" width="12"> Akceptowalny</div>
                        <div><img src="/icons/marker-icon-orange.png" width="12"> Umiarkowany</div>
                        <div><img src="/icons/marker-icon-red.png" width="12"> Zły</div>`;
                    break;
                default:
                    html = 'Brak opisu dla tego parametru';
            }

            legend.innerHTML = html;
        }

        function clearMarkers() {
            markers.forEach(marker => map.removeLayer(marker));
            markers = [];
        }

       function loadFilteredDevices() {
    clearMarkers();
    const datetime = document.getElementById('filterDatetime').value;
    const parameter = document.getElementById('parameterSelect').value;
    if (!datetime || !parameter) return alert('Wybierz datę/czas i parametr!');
    updateLegend(parameter);

    fetch(`/api/devices/with-latest-values?parameter=${parameter}&datetime=${datetime}`)
        .then(res => res.json())
        .then(devices => {
            devices.forEach(device => {
                const color = getMarkerColor(device.value, parameter);
                const iconUrl = `/icons/marker-icon-${color}.png`;

                const icon = L.icon({
                    iconUrl,
                    shadowUrl: '/icons/marker-shadow.png',
                    iconSize: [12, 21],
                    iconAnchor: [6, 21],
                    popupAnchor: [1, -20],
                    shadowSize: [21, 21]
                });

                const marker = L.marker([device.latitude, device.longitude], { icon }).addTo(map);
                marker.bindPopup(`<strong>${device.name}</strong><br>${parameter}: ${device.value}`);
                marker.on('dblclick', () => {
                    window.location.href = `/devices/${device.id}/measurements`;
                });
                markers.push(marker);
            });
        });
}


        document.addEventListener('DOMContentLoaded', () => {
            const now = new Date();
            const oneHourAgo = new Date(now.getTime() - 60 * 60 * 1000);
            document.getElementById('filterDatetime').value = oneHourAgo.toISOString().slice(0, 16);

            fetch('/api/parameters')
                .then(res => res.json())
                .then(parameters => {
                    const select = document.getElementById('parameterSelect');
                    parameters.forEach(param => {
                        const opt = document.createElement('option');
                        opt.value = param.name;
                        opt.textContent = param.name;
                        select.appendChild(opt);
                    });
                    loadFilteredDevices(); // Automatyczne ładowanie
                });
        });

        document.getElementById('toggleFilter').addEventListener('click', () => {
            const panel = document.getElementById('filterPanel');
            panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
        });

        const mapContainer = document.getElementById('map-container');
        const enterIcon = document.getElementById('enterFullScreenIcon');
        const exitIcon = document.getElementById('exitFullScreenIcon');

        function toggleFullScreen() {
            if (!document.fullscreenElement) {
                mapContainer.requestFullscreen().then(() => {
                    enterIcon.style.display = 'none';
                    exitIcon.style.display = 'block';
                });
            } else {
                document.exitFullscreen().then(() => {
                    enterIcon.style.display = 'block';
                    exitIcon.style.display = 'none';
                });
            }
        }

        document.addEventListener('fullscreenchange', () => {
            const fs = document.fullscreenElement;
            enterIcon.style.display = fs ? 'none' : 'block';
            exitIcon.style.display = fs ? 'block' : 'none';
        });
    </script>
</x-app-layout>
