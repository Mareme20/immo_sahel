<script setup>
import { computed } from 'vue';

const props = defineProps({
    name: {
        type: String,
        required: true,
    },
});

const iconPath = computed(() => {
    return {
        home: 'M3.75 10.5 12 3.75l8.25 6.75v9a1.5 1.5 0 0 1-1.5 1.5h-2.25v-6h-4.5v6H5.25A1.5 1.5 0 0 1 3.75 19.5v-9Z',
        building: 'M6.75 21V6.75A2.25 2.25 0 0 1 9 4.5h6a2.25 2.25 0 0 1 2.25 2.25V21M4.5 21h15M9.75 8.25h.008v.008H9.75V8.25Zm0 3.75h.008v.008H9.75V12Zm0 3.75h.008v.008H9.75v-.008ZM14.25 8.25h.008v.008h-.008V8.25Zm0 3.75h.008v.008h-.008V12Zm0 3.75h.008v.008h-.008v-.008Z',
        key: 'M15.75 8.25a3.75 3.75 0 1 1-7.19 1.5H3.75v3h2.25v2.25h2.25v2.25h3V14.44a3.75 3.75 0 0 1 4.5-6.19Z',
        chart: 'M4.5 19.5h15M7.5 16.5V12m4.5 4.5V8.25m4.5 8.25V10.5',
        wrench: 'm14.25 6 3.75-3.75M18 2.25l-3.293 3.293a4.5 4.5 0 0 0-6.364 6.364L3 17.25V21h3.75l5.343-5.343a4.5 4.5 0 0 0 6.364-6.364L21.75 6',
        message: 'M2.25 12a8.25 8.25 0 1 1 3.176 6.504L3 21l2.496-2.426A8.215 8.215 0 0 1 2.25 12Z',
        bell: 'M14.25 18.75a2.25 2.25 0 0 1-4.5 0M6 8.25a6 6 0 1 1 12 0c0 6.75 2.25 8.25 2.25 8.25H3.75S6 15 6 8.25Z',
        plus: 'M12 4.5v15m7.5-7.5h-15',
        upload: 'M12 16.5V6m0 0L8.25 9.75M12 6l3.75 3.75M4.5 16.5v1.125A1.875 1.875 0 0 0 6.375 19.5h11.25A1.875 1.875 0 0 0 19.5 17.625V16.5',
        users: 'M18 18.75a3 3 0 0 0-3-3H9a3 3 0 0 0-3 3M15.75 8.25a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM20.25 18.75a5.245 5.245 0 0 0-4.324-5.164M3.75 18.75a5.245 5.245 0 0 1 4.324-5.164',
    }[props.name] ?? '';
});
</script>

<template>
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path :d="iconPath" />
    </svg>
</template>
