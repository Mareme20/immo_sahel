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
        ? 'block w-full rounded-2xl bg-slate-900 px-4 py-3 text-start text-base font-semibold text-white transition duration-150 ease-in-out'
        : 'block w-full rounded-2xl px-4 py-3 text-start text-base font-medium text-slate-600 transition duration-150 ease-in-out hover:bg-white hover:text-slate-900'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
