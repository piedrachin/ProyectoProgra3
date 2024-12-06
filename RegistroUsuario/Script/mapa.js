// Coordenadas del hotel (ejemplo: San José, Costa Rica)
const hotelCoords = { lat: 9.9281, lng: -84.0907 };

// Inicializa el mapa centrado en las coordenadas del hotel
const map = L.map('map').setView([hotelCoords.lat, hotelCoords.lng], 13);

// Carga el mapa desde OpenStreetMap
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap'
}).addTo(map);

// Agrega un marcador en la ubicación del hotel
L.marker([hotelCoords.lat, hotelCoords.lng])
    .addTo(map)
    .bindPopup('Aquí está el hotel')
    .openPopup();
