@php
    $statePath = $getStatePath();
    $mapId = $getId() . '-leaflet';
@endphp

<div
    x-data="leafletMapField({
        state: @entangle($statePath),
        mapId: @js($mapId),
    })"
    x-init="init()"
    class="space-y-2"
>
    <div class="text-sm text-gray-500">
        Click on the map or drag the marker to set the location.
    </div>
    <div wire:ignore id="{{ $mapId }}" class="w-full rounded-lg border border-gray-200" style="height: 420px;"></div>
</div>

<script>
    function leafletMapField({ state, mapId }) {
        return {
            state,
            map: null,
            marker: null,
            async init() {
                await this.ensureLeaflet();
                if (!this.state || typeof this.state !== 'object') {
                    this.state = { lat: 21.0278, lng: 105.8342, zoom: 12 };
                }

                const lat = this.state.lat ?? 21.0278;
                const lng = this.state.lng ?? 105.8342;
                const zoom = this.state.zoom ?? 12;

                this.map = L.map(mapId).setView([lat, lng], zoom);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap contributors',
                }).addTo(this.map);

                this.marker = L.marker([lat, lng], { draggable: true }).addTo(this.map);

                this.marker.on('dragend', (event) => {
                    const position = event.target.getLatLng();
                    this.updateState(position.lat, position.lng, this.map.getZoom());
                });

                this.map.on('click', (event) => {
                    const position = event.latlng;
                    this.marker.setLatLng(position);
                    this.updateState(position.lat, position.lng, this.map.getZoom());
                });

                this.map.on('zoomend', () => {
                    const position = this.marker.getLatLng();
                    this.updateState(position.lat, position.lng, this.map.getZoom());
                });
            },
            updateState(lat, lng, zoom) {
                this.state = {
                    lat: Number(lat.toFixed(7)),
                    lng: Number(lng.toFixed(7)),
                    zoom: Number(zoom),
                };
            },
            ensureLeaflet() {
                if (window.leafletMapAssetsLoaded) {
                    return Promise.resolve();
                }

                return new Promise((resolve) => {
                    const css = document.createElement('link');
                    css.rel = 'stylesheet';
                    css.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
                    css.integrity = 'sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=';
                    css.crossOrigin = '';
                    document.head.appendChild(css);

                    const script = document.createElement('script');
                    script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
                    script.integrity = 'sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=';
                    script.crossOrigin = '';
                    script.onload = () => {
                        window.leafletMapAssetsLoaded = true;
                        resolve();
                    };
                    document.head.appendChild(script);
                });
            },
        };
    }
</script>
