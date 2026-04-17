<script setup>
import { onMounted, ref } from 'vue';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

const props = defineProps({
    location: String,
    lat: { type: Number, default: 14.7167 }, // Dakar par défaut
    lng: { type: Number, default: -17.4677 }
});

const mapContainer = ref(null);

onMounted(() => {
    const map = L.map(mapContainer.value).setView([props.lat, props.lng], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker([props.lat, props.lng]).addTo(map)
        .bindPopup(`<b>Agence du Sahel</b><br>${props.location}`)
        .openPopup();
});
</script>

<template>
    <div class="rounded-2xl overflow-hidden shadow-lg border-4 border-white h-80 w-full" ref="mapContainer"></div>
</template>

<style>
/* Correction pour les icônes Leaflet qui disparaissent parfois avec Vite */
.leaflet-default-icon-path {
    background-image: url(https://unpkg.com/leaflet@1.7.1/dist/images/marker-icon.png);
}
</style>
