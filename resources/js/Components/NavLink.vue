<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'inline-flex items-center rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-sm transition duration-150 ease-in-out'
        : 'inline-flex items-center rounded-full px-4 py-2 text-sm font-medium text-slate-600 transition duration-150 ease-in-out hover:bg-white hover:text-slate-900'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
