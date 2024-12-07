import L from 'leaflet';

// example usage
// const mapConfig = {
//     center: [51.505, -0.09], // Latitude and Longitude
//     zoom: 13, // Zoom level
// };

// const mapMarkers = [
//     {
//         coords: [51.505, -0.09],
//         popup: "I am a marker at the center!",
//     },
//     {
//         coords: [51.515, -0.1],
//         popup: "I am another marker!",
//     },
// ];
// generateMap('map', mapConfig, mapMarkers);

export const  generateMap = (mapId, config, markers = []) => {
    // Ensure no previous map instance exists in the container
    if (window[mapId + '_map']) {
        window[mapId + '_map'].remove();
    }

    // Create a new map instance
    const map = L.map(mapId).setView(config.center, config.zoom);
    window[mapId + '_map'] = map; // Store map instance globally for potential reuse

    // Add OpenStreetMap tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors',
    }).addTo(map);

    // Add markers to the map
    markers.forEach(marker => {
        const leafletMarker = L.marker(marker.coords).addTo(map);
        if (marker.popup) {
            leafletMarker.bindPopup(marker.popup);
        }
    });
}
