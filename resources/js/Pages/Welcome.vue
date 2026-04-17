<script setup>
import PublicFooter from '@/Components/PublicFooter.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    featured_properties: {
        type: Array,
        default: () => [],
    },
    market_stats: {
        type: Object,
        default: () => ({}),
    },
    categories: {
        type: Array,
        default: () => [],
    },
});

const heroIndex = ref(0);
const statIndex = ref(0);

const heroProperty = computed(() => props.featured_properties[heroIndex.value] ?? null);

const statItems = computed(() => [
    { label: 'Biens Premium', value: props.market_stats.total ?? 0, icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', color: 'from-primary-500 to-blue-600' },
    { label: 'À Vendre', value: props.market_stats.sales ?? 0, icon: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', color: 'from-gold-500 to-yellow-600' },
    { label: 'À Louer', value: props.market_stats.rents ?? 0, icon: 'M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z', color: 'from-emerald-500 to-teal-600' },
    { label: 'Villes Couvertes', value: props.market_stats.cities ?? 0, icon: 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z', color: 'from-copper-500 to-orange-600' },
]);

const formatPrice = (price) =>
    new Intl.NumberFormat('fr-FR', {
        style: 'currency',
        currency: 'XOF',
        maximumFractionDigits: 0,
    }).format(price ?? 0);

const propertyImage = (property) => {
    if (!property?.main_image?.image_path) {
        return null;
    }
    return `/storage/${property.main_image.image_path}`;
};

// Auto-rotate hero
setInterval(() => {
    heroIndex.value = (heroIndex.value + 1) % props.featured_properties.length;
}, 5000);

// Auto-rotate stats
setInterval(() => {
    statIndex.value = (statIndex.value + 1) % statItems.value.length;
}, 3000);
</script>

<template>
    <Head title="Agence Immo Sahel - Immobilier Prestige Sahel" />

    <div class="min-h-screen bg-neutral-50">
        <!-- Navigation -->
        <header class="sticky top-0 z-50 border-b border-neutral-200/50 bg-white/95 backdrop-blur-xl">
            <nav class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4 lg:px-8">
                <Link href="/" class="flex items-center gap-3">
                    <div class="rounded-2xl bg-gradient-to-br from-neutral-900 to-primary-900 p-3 shadow-xl transition-all hover:scale-105 hover:shadow-2xl">
                        <svg class="h-10 w-10 text-white" viewBox="0 0 84 84" fill="none">
                            <rect x="6" y="6" width="72" height="72" rx="20" fill="currentColor" opacity="0.15" />
                            <path d="M21 38.5L42 21L63 38.5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="5" />
                            <path d="M28 35.5V62H56V35.5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="5" />
                            <path d="M36 62V47H48V62" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="5" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="font-serif text-2xl font-black tracking-tight text-neutral-900 lg:text-3xl">Immo Sahel</h1>
                        <p class="text-xs uppercase tracking-[0.4em] text-primary-700 font-medium">Prestige Immobilier</p>
                    </div>
                </Link>

                <div class="hidden items-center gap-8 lg:flex">
                    <Link href="#" class="text-sm font-semibold text-neutral-700 hover:text-primary-700 transition-all group">
                        À Propos
                        <span class="ml-1 h-1 w-0 rounded-full bg-primary-600 transition-all group-hover:w-4"></span>
                    </Link>
                    <Link :href="route('properties.index')" class="text-lg font-bold text-primary-900 hover:text-primary-700 transition-all">
                        Notre Catalogue
                    </Link>
                    <Link href="#contact" class="text-sm font-semibold text-neutral-700 hover:text-primary-700 transition-all">
                        Contact
                    </Link>
                </div>

                <div class="flex items-center gap-3">
                    <Link :href="route('login')" class="text-sm font-semibold text-neutral-700 hover:text-primary-700 px-6 py-3 border border-neutral-200 rounded-2xl hover:border-primary-300 transition-all">
                        Espace Agence
                    </Link>
                    <Link
                        :href="route('properties.index')"
                        class="rounded-2xl bg-gradient-to-r from-primary-600 to-gold-600 px-8 py-3 text-sm font-bold text-white shadow-xl hover:shadow-2xl hover:from-primary-700 hover:to-gold-700 transition-all"
                    >
                        Explorer
                    </Link>
                </div>
            </nav>
        </header>

        <!-- Hero Section with Carousel -->
        <section class="relative isolate overflow-hidden py-20 lg:py-32">
            <!-- Animated Background -->
            <div class="absolute inset-0">
                <div class="absolute -left-1/3 top-1/4 h-[1000px] w-[1000px] rounded-full bg-gradient-to-r from-primary-400/10 via-transparent to-gold-400/5 blur-3xl animate-[float_8s_ease-in-out_infinite]"></div>
                <div class="absolute right-1/4 bottom-1/4 h-[800px] w-[800px] rounded-full bg-gradient-to-b from-gold-500/5 to-copper-500/5 blur-3xl animate-[float_10s_ease-in-out_infinite_reverse]"></div>
            </div>

            <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
                <div class="grid grid-cols-1 items-center gap-12 lg:grid-cols-2 lg:gap-x-16 lg:gap-y-12">
                    <!-- Hero Content -->
                    <div class="text-center lg:text-left">
                        <span class="inline-flex animate-fade-in items-center gap-2 rounded-full bg-white/80 px-5 py-2.5 text-sm font-bold uppercase tracking-[0.25em] text-primary-800 shadow-lg backdrop-blur-sm">
                            <div class="h-2.5 w-2.5 animate-ping rounded-full bg-gradient-to-r from-primary-500 to-gold-500"></div>
                            <span>Catalogue Exclusif 2024</span>
                        </span>

                        <h1 class="mt-10 font-serif text-5xl font-black leading-[1.05] tracking-tight text-neutral-900 sm:text-7xl lg:text-8xl xl:text-9xl animate-slide-up">
                            Biens d'<span class="bg-gradient-to-r from-primary-600 via-gold-500 to-copper-500 bg-clip-text text-transparent drop-shadow-2xl">Exception</span>
                            <br class="hidden lg:block" />
                            <span class="text-4xl sm:text-5xl lg:text-6xl text-neutral-600">Sahel Prestige</span>
                        </h1>

                        <p class="mx-auto mt-8 max-w-2xl text-xl text-neutral-600 lg:mx-0 animate-[fade-in_0.8s_0.3s] lg:text-2xl">
                            Découvrez une sélection rigoureuse de propriétés haut de gamme. Chaque bien présenté avec élégance 
                            et minutie, prêt à devenir le vôtre.
                        </p>

                        <div class="mt-12 flex animate-[fade-in_1s_0.5s] flex-col gap-4 sm:flex-row lg:justify-start">
                            <Link
                                :href="route('properties.index')"
                                class="group relative flex w-full max-w-sm items-center justify-center gap-3 rounded-3xl bg-gradient-to-r from-primary-600 via-primary-600 to-gold-600 px-10 py-6 font-bold text-xl text-white shadow-2xl hover:shadow-3xl sm:w-auto transition-all duration-500 group-hover:-translate-y-2 hover:from-primary-700 hover:to-gold-700"
                            >
                                <span>Explorer ({{ market_stats.total ?? 0 }})</span>
                                <svg class="h-6 w-6 transition-transform group-hover:translate-x-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                                <div class="pointer-events-none absolute inset-0 rounded-3xl bg-gradient-to-r from-primary-600/20 opacity-0 transition-opacity group-hover:opacity-100"></div>
                            </Link>
                            <a
                                href="tel:+22177000000"
                                class="group flex w-full max-w-sm items-center justify-center gap-3 rounded-3xl border-2 border-transparent bg-white/80 px-10 py-6 font-semibold text-xl text-primary-900 shadow-xl backdrop-blur-xl hover:border-primary-300 hover:shadow-2xl hover:brightness-105 sm:w-auto transition-all duration-300"
                            >
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                Appeler Expert
                            </a>
                        </div>

                        <!-- Live Stats Carousel -->
                        <div class="mt-24 lg:mt-32">
                            <div class="relative">
                                <div
                                    v-for="(stat, index) in statItems"
                                    :key="index"
                                    :class="[
                                        'absolute inset-0 opacity-0 transition-all duration-1000 ease-out transform translate-y-4',
                                        index === statIndex ? 'opacity-100 translate-y-0 scale-105' : ''
                                    ]"
                                    class="grid grid-cols-2 gap-6 sm:grid-cols-4"
                                >
                                    <div v-for="(item, sIndex) in statItems.slice(index, index + 4)" :key="sIndex" class="group cursor-default text-center transition-all hover:scale-105">
                                        <div class="mx-auto mb-4 inline-flex h-20 w-20 items-center justify-center rounded-3xl bg-gradient-to-br from-white/50 backdrop-blur-xl shadow-2xl group-hover:shadow-3xl transition-all duration-300">
                                            <svg class="h-8 w-8 text-primary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="item.icon" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-3xl font-black text-neutral-900 drop-shadow-lg animate-[counter_2s_ease-out]">{{ item.value.toLocaleString() }}</p>
                                            <p class="mt-2 text-sm font-semibold uppercase tracking-wide text-neutral-600 group-hover:text-primary-700">{{ item.label }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mx-auto mt-6 flex gap-2">
                                    <button
                                        v-for="(item, index) in statItems"
                                        :key="index"
                                        @click="statIndex = index"
                                        :class="[
                                            'h-3 w-3 rounded-full transition-all duration-300',
                                            statIndex === index ? 'bg-primary-600 scale-125 shadow-lg' : 'bg-neutral-300 hover:bg-neutral-400'
                                        ]"
                                    ></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hero Property Showcase -->
                    <div class="relative lg:col-start-2">
                        <div class="group relative">
                            <!-- Hero Image -->
                            <div class="aspect-[4/3] w-full overflow-hidden rounded-3xl bg-gradient-to-br from-neutral-100 to-neutral-200 shadow-2xl group-hover:shadow-3xl transition-all duration-700 group-hover:scale-[1.02]">
                                <img
                                    v-if="propertyImage(heroProperty)"
                                    :src="propertyImage(heroProperty)"
                                    :alt="heroProperty?.title"
                                    class="h-full w-full object-cover transition-transform duration-1000 group-hover:scale-110"
                                />
                                <div v-else class="flex h-full w-full items-center justify-center bg-gradient-to-br from-neutral-200 to-neutral-300 p-12 text-neutral-400">
                                    <div class="text-center">
                                        <svg class="mx-auto h-24 w-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="mt-4 text-xl font-semibold">Image Premium</p>
                                        <p class="mt-1 text-sm opacity-75">Bientôt disponible</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Overlay Gradient & Content -->
                            <div class="absolute inset-0 bg-gradient-to-t from-neutral-900/80 via-neutral-900/20 to-transparent"></div>
                            <div class="absolute bottom-6 left-6 right-6">
                                <div class="flex gap-3">
                                    <span
                                        class="rounded-full bg-white/95 px-4 py-1.5 text-xs font-bold uppercase text-neutral-900 backdrop-blur-xl shadow-lg"
                                    >
                                        {{ heroProperty?.type === 'sale' ? 'À Vendre' : 'À Louer' }}
                                    </span>
                                    <span
                                        v-if="heroProperty?.featured"
                                        class="rounded-full bg-gradient-to-r from-gold-500 to-copper-500 px-4 py-1.5 text-xs font-bold uppercase text-white shadow-lg"
                                    >
                                        Sélection Élite
                                    </span>
                                </div>
                                <h2 class="mt-3 font-display text-3xl font-bold text-white drop-shadow-2xl line-clamp-2">
                                    {{ heroProperty?.title }}
                                </h2>
                                <p class="mt-1 text-lg font-semibold text-gold-300 drop-shadow-lg">
                                    {{ heroProperty?.location }}
                                </p>
                                <div class="mt-6 flex items-center justify-between">
                                    <div>
                                        <p class="text-4xl font-black text-gold-400 drop-shadow-2xl">{{ formatPrice(heroProperty?.price) }}</p>
                                    </div>
                                    <Link
                                        :href="route('properties.show', heroProperty?.slug)"
                                        class="flex items-center gap-2 rounded-2xl bg-white/90 px-6 py-3 font-semibold text-primary-900 backdrop-blur-xl shadow-2xl hover:bg-white hover:shadow-3xl transition-all duration-300"
                                    >
                                        Voir Détails
                                        <svg class="h-5 w-5 transition-transform hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                        </svg>
                                    </Link>
                                </div>
                            </div>

                            <!-- Pagination Dots -->
                            <div v-if="props.featured_properties.length > 1" class="absolute bottom-6 left-1/2 -translate-x-1/2 transform flex gap-2">
                                <button
                                    v-for="(property, index) in props.featured_properties"
                                    :key="property.id"
                                    @click="heroIndex = index"
                                    :class="[
                                        'h-2.5 w-2.5 rounded-full transition-all duration-300',
                                        heroIndex === index
                                            ? 'bg-gold-400 scale-125 shadow-lg ring-2 ring-gold-200/50'
                                            : 'bg-white/60 backdrop-blur hover:bg-white hover:scale-110'
                                    ]"
                                ></button>
                            </div>
                        </div>

                        <!-- Quick Features -->
                        <div class="mt-8 grid grid-cols-2 gap-4 lg:mt-12">
                            <div class="group rounded-2xl bg-white/70 p-6 shadow-xl backdrop-blur-sm transition-all hover:shadow-2xl hover:-translate-y-1">
                                <h4 class="font-display text-sm font-bold uppercase tracking-wide text-primary-800">Expertise</h4>
                                <p class="mt-2 text-neutral-700">Sélection rigoureuse par experts certifiés</p>
                            </div>
                            <div class="group rounded-2xl bg-white/70 p-6 shadow-xl backdrop-blur-sm transition-all hover:shadow-2xl hover:-translate-y-1">
                                <h4 class="font-display text-sm font-bold uppercase tracking-wide text-gold-700">Sécurisé</h4>
                                <p class="mt-2 text-neutral-700">Transactions 100% sécurisées et transparentes</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Properties Grid -->
        <section class="py-24 lg:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mb-16 text-center">
                    <span class="inline-block rounded-full bg-gradient-to-r from-primary-100 to-gold-100 px-5 py-2.5 text-sm font-bold uppercase tracking-[0.25em] text-primary-800">
                        Sélection Exclusive
                    </span>
                    <h2 class="mt-8 font-serif text-4xl font-black tracking-tight text-neutral-900 sm:text-6xl">
                        Nos Biens d'<span class="text-transparent bg-clip-text bg-gradient-to-r from-gold-600 to-copper-600">Exception</span>
                    </h2>
                    <p class="mx-auto mt-6 max-w-2xl text-xl text-neutral-600 lg:text-2xl">
                        Une sélection méticuleuse de propriétés rares, présentées avec l'élégance qu'elles méritent.
                    </p>
                </div>

                <div v-if="featured_properties.length" class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <article
                        v-for="property in featured_properties"
                        :key="property.id"
                        class="group relative overflow-hidden rounded-3xl bg-white shadow-2xl transition-all duration-700 hover:shadow-3xl hover:-translate-y-4 hover:rotate-1"
                    >
                        <!-- Image with overlay -->
                        <div class="aspect-[4/3] relative overflow-hidden bg-gradient-to-br from-neutral-50 to-neutral-100">
                            <img
                                v-if="propertyImage(property)"
                                :src="propertyImage(property)"
                                :alt="property.title"
                                class="h-full w-full object-cover transition-all duration-1000 group-hover:scale-110"
                            />
                            <div class="absolute inset-0 bg-gradient-to-t from-neutral-900/70 via-neutral-900/20" />

                            <!-- Badges -->
                            <div class="absolute left-6 top-6 z-10 flex flex-col gap-2">
                                <span
                                    class="rounded-xl bg-white/95 px-4 py-2 text-xs font-bold uppercase text-neutral-900 backdrop-blur-xl shadow-2xl"
                                >
                                    {{ property.type === 'sale' ? 'Vente Exclusive' : 'Location Prestige' }}
                                </span>
                                <span
                                    v-if="property.featured"
                                    class="rounded-xl bg-gradient-to-r from-gold-500 to-copper-500 px-4 py-2 text-xs font-bold uppercase text-white shadow-2xl"
                                >
                                    Coup de Cœur
                                </span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-8">
                            <div class="mb-6 flex items-start justify-between">
                                <div>
                                    <span class="mb-2 inline-block rounded-lg bg-gradient-to-r from-emerald-100 to-teal-100 px-3 py-1 text-xs font-bold uppercase text-emerald-800">
                                        {{ property.category?.name }}
                                    </span>
                                </div>
                                <Link
                                    :href="route('properties.show', property.slug)"
                                    class="text-2xl font-black text-neutral-900 transition-colors group-hover:text-primary-700"
                                >
                                    {{ formatPrice(property.price) }}
                                </Link>
                            </div>

                            <h3 class="mb-4 line-clamp-2 text-xl font-bold text-neutral-900 group-hover:text-primary-900 transition-colors">
                                {{ property.title }}
                            </h3>
                            <p class="mb-6 text-neutral-600 line-clamp-2">{{ property.location }} • {{ property.area }} m² • {{ property.rooms }} ch.</p>

                            <div class="mb-8 grid grid-cols-3 gap-4">
                                <div class="flex flex-col items-center gap-1 p-3 rounded-2xl bg-neutral-50 group-hover:bg-primary-50 transition-colors">
                                    <svg class="h-5 w-5 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 00-2-2h-.5a2.5 2.5 0 01-2.5-2.5V11" />
                                    </svg>
                                    <span class="text-xs font-bold text-neutral-900">{{ property.area || 'N/A' }} m²</span>
                                </div>
                                <div class="flex flex-col items-center gap-1 p-3 rounded-2xl bg-neutral-50 group-hover:bg-primary-50 transition-colors">
                                    <svg class="h-5 w-5 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <span class="text-xs font-bold text-neutral-900">{{ property.rooms || 'N/A' }}</span>
                                </div>
                                <div class="flex flex-col items-center gap-1 p-3 rounded-2xl bg-neutral-50 group-hover:bg-primary-50 transition-colors">
                                    <svg class="h-5 w-5 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11l7-7 7 7M5 19v4h4M13 19v4h4M21 13v-4h-4M4 4h16M8 3v2M12 3v2M16 3v2M5 19l7-7 7 7" />
                                    </svg>
                                    <span class="text-xs font-bold text-neutral-900">{{ property.bathrooms || 'N/A' }}</span>
                                </div>
                            </div>

                            <Link
                                :href="route('properties.show', property.slug)"
                                class="flex items-center gap-3 rounded-3xl bg-gradient-to-r from-primary-600 to-gold-600 px-8 py-4 font-bold text-white shadow-2xl hover:shadow-3xl hover:from-primary-700 hover:to-gold-700 transition-all duration-300 group-hover:-translate-y-1 w-full justify-center"
                            >
                                Découvrir Propriété
                                <svg class="h-5 w-5 transition-transform group-hover:translate-x-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </Link>
                        </div>
                    </article>
                </div>

                <div v-else class="grid place-items-center py-32 text-center">
                    <div class="inline-flex h-24 w-24 items-center justify-center rounded-3xl bg-neutral-100">
                        <svg class="h-12 w-12 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                    </div>
                    <h3 class="mt-8 text-3xl font-black text-neutral-900">Aucune Propriété</h3>
                    <p class="mt-4 max-w-md text-xl text-neutral-600">Le catalogue sera bientôt rempli de pépites immobilières exclusives.</p>
                </div>

                <div class="mt-20 flex justify-center">
                    <Link
                        :href="route('properties.index')"
                        class="rounded-3xl bg-gradient-to-r from-primary-600 to-gold-600 px-12 py-6 text-xl font-bold text-white shadow-2xl hover:shadow-3xl hover:from-primary-700 hover:to-gold-700 transition-all duration-300"
                    >
                        Voir Tout le Catalogue
                    </Link>
                </div>
            </div>
        </section>

        <!-- Expertise Section -->
        <section class="bg-gradient-to-b from-white to-neutral-50 py-24 lg:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="text-center">
                    <span class="inline-block rounded-2xl bg-gradient-to-r from-emerald-100 to-teal-100 px-6 py-3 text-sm font-bold uppercase tracking-[0.2em] text-emerald-800 shadow-lg">
                        Pourquoi Nous Choisir
                    </span>
                    <h2 class="mt-12 font-serif text-5xl font-black text-neutral-900 sm:text-7xl">
                        Excellence
                        <br />
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-gold-600">Immobilière</span>
                    </h2>
                </div>

                <div class="mt-24 grid grid-cols-1 gap-12 lg:grid-cols-3">
                    <div class="group">
                        <div class="mx-auto mb-8 flex h-24 w-24 items-center justify-center rounded-3xl bg-gradient-to-br from-primary-500 to-primary-600 text-2xl font-black text-white shadow-2xl group-hover:shadow-3xl group-hover:scale-110 transition-all duration-700">
                            01
                        </div>
                        <h3 class="mb-6 text-2xl font-bold text-neutral-900 group-hover:text-primary-900 transition-colors">Sélection Exclusive</h3>
                        <p class="text-lg text-neutral-600 leading-relaxed">
                            Chaque propriété subit une expertise rigoureuse. Seules les pépites atteignent notre catalogue.
                        </p>
                    </div>
                    <div class="group">
                        <div class="mx-auto mb-8 flex h-24 w-24 items-center justify-center rounded-3xl bg-gradient-to-br from-gold-500 to-copper-500 text-2xl font-black text-white shadow-2xl group-hover:shadow-3xl group-hover:scale-110 transition-all duration-700">
                            02
                        </div>
                        <h3 class="mb-6 text-2xl font-bold text-neutral-900 group-hover:text-gold-700 transition-colors">Présentation Premium</h3>
                        <p class="text-lg text-neutral-600 leading-relaxed">
                            Photographies professionnelles, vidéos immersives, visites virtuelles. Le luxe mérite le meilleur.
                        </p>
                    </div>
                    <div class="group">
                        <div class="mx-auto mb-8 flex h-24 w-24 items-center justify-center rounded-3xl bg-gradient-to-br from-emerald-500 to-teal-500 text-2xl font-black text-white shadow-2xl group-hover:shadow-3xl group-hover:scale-110 transition-all duration-700">
                            03
                        </div>
                        <h3 class="mb-6 text-2xl font-bold text-neutral-900 group-hover:text-emerald-700 transition-colors">Service 360°</h3>
                        <p class="text-lg text-neutral-600 leading-relaxed">
                            Du premier contact à la signature, accompagnement expert par nos conseillers spécialisés.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <PublicFooter />
    </div>
</template>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

@keyframes counter {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-[counter_2s_ease-out] {
    animation: counter 2s ease-out;
}
</style>
