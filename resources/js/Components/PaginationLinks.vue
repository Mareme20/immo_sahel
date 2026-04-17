<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    links: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <nav v-if="links.length > 3" class="mt-8 flex flex-wrap items-center gap-2">
        <component
            :is="link.url ? Link : 'span'"
            v-for="link in links"
            :key="`${link.label}-${link.url}`"
            :href="link.url || undefined"
            class="inline-flex min-w-[2.75rem] items-center justify-center rounded-full border px-4 py-2 text-sm transition"
            :class="
                link.url
                    ? link.active
                        ? 'border-emerald-600 bg-emerald-600 text-white'
                        : 'border-slate-200 bg-white text-slate-700 hover:border-slate-300 hover:bg-slate-50'
                    : 'border-slate-100 bg-slate-100 text-slate-400'
            "
            v-html="link.label"
        />
    </nav>
</template>
