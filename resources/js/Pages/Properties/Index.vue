<script setup>
import PublicFooter from '@/Components/PublicFooter.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { computed, ref, watch, nextTick } from 'vue';

const props = defineProps({
    properties: Object,
    categories: Array,
    filters: Object,
    stats: Object,
});

const search = ref(props.filters.search || '');
const typeFilter = ref(props.filters.type || '');
const categoryFilter = ref(props.filters.category || '');
const priceRange = ref([props.filters.min_price || 0, props.filters.max_price || 1000000000]);
const sortBy = ref(props.filters.sort || 'latest');
const activeTags = ref([]);

const activeFiltersCount = computed(() => activeTags.value.length);

const availableTypes = [
    { value: 'sale', label: 'Vente' },
    { value: 'rent', label: 'Location' },
];

const formatPrice = (price) =>
    new Intl.NumberFormat('fr-FR', {
        style: 'currency',
        currency: 'XOF',
        maximumFractionDigits: 0,
    }).format(price ?? 0);

const propertyImage = (property) => {
    if (!property?.main_image?.image_path) return '/images/placeholder-property.jpg';
    return `/storage/${property.main_image.image_path}`;
};

const addTag = (tag) => {
    if (!activeTags.value.some(t => t.id === tag.id)) {
        activeTags.value.push(tag);
        updateFilters();
    }
};

const removeTag = (tagId) => {
    activeTags.value = activeTags.value.filter(t => t.id !== tagId);
    updateFilters();
};

const clearAllTags = () => {
    activeTags.value = [];
    updateFilters();
};

const updateFilters = () => {
    const filters = {
        search: search.value || undefined,
        type: activeTags.value.find(t => t.type === 'type')?.value || undefined,
        category: activeTags.value.find(t => t.type === 'category')?.value || undefined,
        min_price: priceRange.value[0] || undefined,
        max_price: priceRange.value[1] || undefined,
        sort: sortBy.value || undefined,
    };

    router.get(route('properties.index'), filters, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    });
};

// Debounced search
let searchTimeout;
watch(search, () => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(updateFilters, 350);
});

watch([typeFilter, categoryFilter, sortBy, () => priceRange.value], updateFilters);

const resetFilters = async () => {
    search.value = '';
    typeFilter.value = '';
    categoryFilter.value = '';
    priceRange.value = [0, 1000000000];
    sortBy.value = 'latest';
    activeTags.value = [];
    await nextTick();
    updateFilters();
};
</script>

<template>
    <Head title="Catalogue Prestige - Immo Sahel" />

    <div class="min-h-screen bg-gradient-to-br from-neutral-50 to-white">
        <!-- Enhanced Navigation -->
        <header class="sticky top-0 z-50 border-b border-neutral-200/30 bg-white/90 backdrop-blur-xl shadow-sm">
            <nav class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4 lg:px-8">
                <Link href="/" class="flex items-center gap-4 group">
                    <div class="rounded-2xl bg-gradient-to-br from-neutral-900 to-primary-900 p-3 shadow-2xl transition-all hover:scale-[1.02] hover:shadow-3xl">
                        <svg class="h-8 w-8 text-white" viewBox="0 0 84 84" fill="none">
                            <rect x="6" y="6" width="72" height="72" rx="20" fill="currentColor" opacity="0.2" />
                            <path d="M21 38.5L42 21L63 38.5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="5" />
                            <path d="M28 35.5V62H56V35.5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="5" />
                            <path d="M36 62V47H48V62" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="5" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="font-serif text-xl font-black text-neutral-900 lg:text-2xl">Immo Sahel</h1>
                        <p class="text-xs uppercase tracking-[0.4em] text-primary-700">Catalogue Prestige</p>
                    </div>
                </Link>

                <div class="hidden items-center gap-8 lg:flex">
                    <Link href="/" class="text-lg font-semibold text-neutral-700 hover:text-primary-700 transition-all">
                        Accueil
                    </Link>
                    <Link href="#contact" class="text-lg font-semibold text-neutral-700 hover:text-primary-700 transition-all">
                        Contact Expert
                    </Link>
                </div>

                <Link
                    :href="route('login')"
                    class="hidden rounded-2xl bg-gradient-to-r from-primary-600 to-gold-600 px-8 py-3 text-sm font-bold text-white shadow-lg hover:shadow-xl hover:from-primary-700 hover:to-gold-700 transition-all lg:inline-flex"
                >
                    Espace Agence
                </Link>
            </nav>
        </header>

        <!-- Hero Stats -->
        <section class="relative isolate py-12 lg:py-20">
            <div class="absolute inset-0 bg-gradient-to-br from-primary-50/50 via-white/90 to-gold-50/40"></div>
            <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
                <div class="grid grid-cols-1 items-center gap-8 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="group text-center">
                        <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-3xl bg-gradient-to-br from-primary-500 to-primary-600 text-2xl font-black text-white shadow-2xl group-hover:animate-bounce group-hover:shadow-3xl transition-all">
                            {{ stats.total }}
                        </div>
                        <h3 class="font-bold text-xl text-neutral-900 group-hover:text-primary-700">Biens Exclusifs</h3>
                        <p class="text-sm text-neutral-600 mt-1">Total disponible</p>
                    </div>
                    <div class="group text-center">
                        <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-3xl bg-gradient-to-br from-gold-500 to-copper-500 text-2xl font-black text-white shadow-2xl group-hover:animate-bounce group-hover:shadow-3xl transition-all">
                            {{ stats.sales }}
                        </div>
                        <h3 class="font-bold text-xl text-neutral-900 group-hover:text-gold-700">À Vendre</h3>
                        <p class="text-sm text-neutral-600 mt-1">Opportunités d'investissement</p>
                    </div>
                    <div class="group text-center">
                        <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-3xl bg-gradient-to-br from-emerald-500 to-teal-500 text-2xl font-black text-white shadow-2xl group-hover:animate-bounce group-hover:shadow-3xl transition-all">
                            {{ stats.rents }}
                        </div>
                        <h3 class="font-bold text-xl text-neutral-900 group-hover:text-emerald-700">À Louer</h3>
                        <p class="text-sm text-neutral-600 mt-1">Locations haut de gamme</p>
                    </div>
                    <div class="group text-center">
                        <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-3xl bg-gradient-to-br from-purple-500 to-violet-500 text-2xl font-black text-white shadow-2xl group-hover:animate-bounce group-hover:shadow-3xl transition-all">
                            {{ stats.featured }}
                        </div>
                        <h3 class="font-bold text-xl text-neutral-900 group-hover:text-purple-700">Sélections</h3>
                        <p class="text-sm text-neutral-600 mt-1">Coups de coeur agence</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Advanced Filters Bar -->
        <section class="sticky top-[104px] z-40 border-b border-neutral-200/50 bg-white/95 backdrop-blur-xl py-8 lg:top-[120px]">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <!-- Search & Core Filters -->
                <div class="mb-8 grid grid-cols-1 items-end gap-6 lg:grid-cols-4 lg:gap-8">
                    <!-- Smart Search -->
                    <div class="lg:col-span-1">
                        <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-neutral-500">Recherche Intelligente</label>
                        <div class="relative">
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 h-5 w-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input
                                v-model="search"
                                type="text"
                                placeholder="Titre • Quartier • Référence • ..."
                                class="w-full rounded-2xl border border-neutral-200 bg-neutral-50/50 px-12 py-4 pr-4 text-lg shadow-sm backdrop-blur-sm placeholder:text-neutral-400 focus:border-primary-400 focus:ring-4 focus:ring-primary-100/50 focus:outline-none transition-all duration-300"
                            />
                        </div>
                    </div>

                    <!-- Type Filter -->
                    <div>
                        <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-neutral-500">Type</label>
                        <div class="flex gap-3">
                            <button
                                v-for="type in availableTypes"
                                :key="type.value"
                                @click="addTag({ id: `type-${type.value}`, value: type.value, label: type.label, type: 'type' })"
                                :class="[
                                    'flex-1 rounded-xl border-2 px-4 py-3 text-sm font-semibold uppercase tracking-wide transition-all duration-200',
                                    activeTags.some(t => t.value === type.value)
                                        ? 'border-primary-500 bg-primary-50 text-primary-800 shadow-md'
                                        : 'border-neutral-200 bg-white hover:border-primary-300 hover:shadow-md hover:text-primary-800'
                                ]"
                            >
                                {{ type.label }}
                            </button>
                        </div>
                    </div>

                    <!-- Category Chips -->
                    <div class="lg:col-span-2">
                        <div class="mb-2 flex items-center justify-between">
                            <label class="text-xs font-bold uppercase tracking-wider text-neutral-500">Catégories</label>
                            <span class="text-xs text-neutral-400">{{ categories.length }} disponibles</span>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <button
                                v-for="cat in categories.slice(0, 8)"
                                :key="cat.id"
                                @click="addTag({ id: `cat-${cat.id}`, value: cat.id, label: cat.name, type: 'category' })"
                                class="rounded-full bg-neutral-100 px-4 py-2 text-xs font-semibold text-neutral-700 hover:bg-primary-100 hover:text-primary-700 transition-all duration-200"
                                :class="{ 'bg-primary-100 text-primary-800 ring-2 ring-primary-200 !ring-offset-0': activeTags.some(t => t.value === cat.id) }"
                            >
                                {{ cat.name }}
                                <span class="ml-1 text-neutral-400">({{ cat.properties_count }})</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Active Filters & Results -->
                <div class="flex flex-col items-center justify-between gap-4 lg:flex-row">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 bg-clip-text text-transparent px-4 py-2 text-sm font-bold shadow-lg">
                            {{ properties.total }} résultat{{ properties.total > 1 ? 's' : '' }}
                        </span>
                        <span
                            v-if="activeFiltersCount"
                            class="rounded-full bg-gradient-to-r from-primary-100 to-gold-100 px-4 py-2 text-sm font-bold text-primary-800 shadow-md"
                        >
                            {{ activeFiltersCount }} filtre{{ activeFiltersCount > 1 ? 's actif' : ' actif' }} • <button @click="clearAllTags" class="underline hover:no-underline">Effacer</button>
                        </span>
                    </div>

                    <!-- Sort & Reset -->
                    <div class="flex items-center gap-3">
                        <div class="flex rounded-2xl bg-neutral-100 p-1">
                            <button
                                v-for="option in [
                                    { value: 'latest', label: 'Récents' },
                                    { value: 'price-low', label: 'Prix +' },
                                    { value: 'price-high', label: 'Prix -' },
                                    { value: 'area', label: 'Surface' }
                                ]"
                                :key="option.value"
                                @click="sortBy = option.value"
                                class="rounded-xl px-4 py-2 text-sm font-semibold transition-all"
                                :class="[
                                    sortBy === option.value
                                        ? 'bg-white text-primary-900 shadow-md'
                                        : 'text-neutral-600 hover:bg-white hover:text-primary-700'
                                ]"
                            >
                                {{ option.label }}
                            </button>
                        </div>
                        <button
                            @click="resetFilters"
                            class="rounded-2xl bg-gradient-to-r from-neutral-100 to-neutral-200 px-6 py-2.5 font-semibold text-neutral-700 hover:from-neutral-200 hover:shadow-md transition-all whitespace-nowrap"
                        >
                            Réinitialiser
                        </button>
                    </div>
                </div>

                <!-- Price Range Slider (Advanced) -->
                <div v-if="activeTags.length || priceRange[0] > 0 || priceRange[1] < 1000000000" class="mt-8 rounded-3xl bg-white/60 p-6 shadow-xl backdrop-blur-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-neutral-700">Budget</span>
                        <span class="text-lg font-bold text-primary-900">{{ formatPrice(priceRange[0]) }} - {{ formatPrice(priceRange[1]) }}</span>
                    </div>
                    <!-- Simplified slider - use native range or external lib for production -->
                    <div class="mt-4 flex gap-4">
                        <input
                            type="range"
                            :min="0"
                            :max="500000000"
                            v-model="priceRange[0]"
                            class="flex-1 h-2 w-full cursor-pointer rounded-lg bg-neutral-200 accent-primary-600 hover:accent-primary-700 transition-all"
                        />
                        <input
                            type="range"
                            :min="0"
                            :max="500000000"
                            v-model="priceRange[1]"
                            class="flex-1 h-2 w-full cursor-pointer rounded-lg bg-neutral-200 accent-primary-600 hover:accent-primary-700 transition-all"
                        />
                    </div>
                </div>
            </div>
        </section>

        <!-- Properties Masonry Grid -->
        <main class="py-16 lg:py-24">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div v-if="properties.data.length" class="-m-4 columns-1 gap-6 sm:columns-2 lg:columns-3 xl:columns-4">
                    <article
                        v-for="property in properties.data"
                        :key="property.id"
                        class="group mb-6 break-inside-avoid rounded-3xl bg-white shadow-xl hover:shadow-3xl transition-all duration-500 hover:-translate-y-4 hover:rotate-1"
                    >
                        <div class="aspect-[4/3] overflow-hidden rounded-t-3xl bg-gradient-to-br from-neutral-50 to-neutral-100">
                            <img
                                :src="propertyImage(property)"
                                :alt="property.title"
                                class="h-full w-full object-cover transition-all duration-700 group-hover:scale-110"
                                loading="lazy"
                            />
                            <!-- Quick Badges -->
                            <div class="absolute left-4 top-4 flex flex-col gap-2">
                                <span
                                    class="rounded-xl bg-white/95 px-3.5 py-1.5 text-xs font-bold uppercase text-neutral-900 shadow-lg backdrop-blur-xl"
                                >
                                    {{ property.type === 'sale' ? 'Vente' : 'Location' }}
                                </span>
                                <span
                                    v-if="property.featured"
                                    class="rounded-xl bg-gradient-to-r from-gold-500 to-copper-500 px-3.5 py-1.5 text-xs font-bold uppercase text-white shadow-lg"
                                >
                                    Elite
                                </span>
                            </div>
                        </div>

                        <div class="p-8">
                            <div class="mb-6 flex items-start justify-between">
                                <span class="rounded-lg bg-gradient-to-r from-emerald-100 to-teal-100 px-3 py-1 text-xs font-bold uppercase text-emerald-800">
                                    {{ property.category?.name }}
                                </span>
                                <h2 class="text-3xl font-black text-neutral-900 transition-colors group-hover:text-primary-900">
                                    {{ formatPrice(property.price) }}
                                </h2>
                            </div>

                            <h3 class="mb-4 line-clamp-2 text-2xl font-bold leading-tight text-neutral-900 group-hover:text-neutral-950 transition-colors">
                                {{ property.title }}
                            </h3>

                            <p class="mb-8 line-clamp-2 text-lg text-neutral-600 leading-relaxed">
                                {{ property.location }} • {{ property.area }} m² • {{ property.rooms }} chambres
                            </p>

                            <div class="mb-10 grid grid-cols-3 gap-4">
                                <div class="group flex flex-col items-center gap-2 rounded-2xl p-4 bg-neutral-50 transition-all hover:bg-primary-50">
                                    <svg class="h-6 w-6 text-neutral-600 group-hover:text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 00-2-2h-.5a2.5 2.5 0 01-2.5-2.5V11" />
                                    </svg>
                                    <span class="font-bold text-neutral-900 group-hover:text-primary-900">{{ property.area || 0 }} m²</span>
                                </div>
                                <div class="group flex flex-col items-center gap-2 rounded-2xl p-4 bg-neutral-50 transition-all hover:bg-primary-50">
                                    <svg class="h-6 w-6 text-neutral-600 group-hover:text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <span class="font-bold text-neutral-900 group-hover:text-primary-900">{{ property.rooms || 0 }}</span>
                                </div>
                                <div class="group flex flex-col items-center gap-2 rounded-2xl p-4 bg-neutral-50 transition-all hover:bg-primary-50">
                                    <svg class="h-6 w-6 text-neutral-600 group-hover:text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11l7-7 7 7M5 19v4h4M13 19v4h4M21 13v-4h-4M4 4h16M8 3v2M12 3v2M16 3v2M5 19l7-7 7 7" />
                                    </svg>
                                    <span class="font-bold text-neutral-900 group-hover:text-primary-900">{{ property.bathrooms || 0 }}</span>
                                </div>
                            </div>

                            <Link
                                :href="route('properties.show', property.slug)"
                                class="group flex w-full items-center justify-center gap-3 rounded-3xl bg-gradient-to-r from-primary-600 to-gold-600 px-8 py-5 text-lg font-bold text-white shadow-2xl hover:shadow-3xl hover:from-primary-700 hover:to-gold-700 transition-all duration-300 group-hover:-translate-y-1"
                            >
                                Découvrir cette Propriété Exclusive
                                <svg class="h-6 w-6 transition-transform group-hover:translate-x-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </Link>
                        </div>
                    </article>
                </div>

                <div v-else-if="!properties.data.length" class="py-32 text-center">
                    <div class="mx-auto inline-flex h-32 w-32 items-center justify-center rounded-3xl bg-gradient-to-br from-neutral-100 to-neutral-200 shadow-2xl">
                        <svg class="h-20 w-20 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <h2 class="mt-12 text-4xl font-black text-neutral-900">Aucun Bien Correspond</h2>
                    <p class="mt-6 max-w-2xl text-xl text-neutral-600 mx-auto">
                        Essayez de modifier vos critères de recherche ou découvrez notre sélection complète.
                    </p>
                    <div class="mt-12 space-x-4">
                        <button @click="resetFilters" class="rounded-3xl bg-gradient-to-r from-primary-600 to-gold-600 px-10 py-5 text-xl font-bold text-white shadow-2xl hover:shadow-3xl transition-all">
                            Réinitialiser Recherche
                        </button>
                    </div>
                </div>
            </div>
        </main>

        <!-- Load More / Pagination -->
        <section v-if="properties.last_page > 1" class="border-t border-neutral-200/50 bg-white/90 backdrop-blur-sm py-12">
            <div class="mx-auto max-w-7xl px-6 text-center lg:px-8">
                <div class="flex flex-col items-center gap-4 sm:flex-row sm:justify-center">
                    <Link
                        v-if="properties.prev_page_url"
                        :href="properties.prev_page_url"
                        class="inline-flex items-center gap-3 rounded-3xl bg-neutral-100 px-8 py-4 text-lg font-semibold text-neutral-700 hover:bg-neutral-200 hover:shadow-lg transition-all px-12"
                    >
                        <svg class="h-5 w-5 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        Précédent
                    </Link>
                    <span class="text-xl font-bold text-neutral-700">
                        {{ properties.current_page }} / {{ properties.last_page }}
                    </span>
                    <Link
                        v-if="properties.next_page_url"
                        :href="properties.next_page_url"
                        class="inline-flex items-center gap-3 rounded-3xl bg-gradient-to-r from-primary-600 to-gold-600 px-8 py-4 text-lg font-bold text-white shadow-xl hover:shadow-2xl transition-all"
                    >
                        Suivant
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </Link>
                </div>
            </div>
        </section>

        <PublicFooter />
    </div>
</template>

<style scoped>
.columns-1 {
    column-count: 1;
}

@media (min-width: 640px) {
    .columns-2 {
        column-count: 2;
    }
}

@media (min-width: 1024px) {
    .columns-3 {
        column-count: 3;
    }
}

@media (min-width: 1280px) {
    .columns-4 {
        column-count: 4;
    }
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Custom scrollbar for filters */
::-webkit-scrollbar {
    height: 6px;
}

::-webkit-scrollbar-track {
    background: transparent;
}

::-webkit-scrollbar-thumb {
    background: rgba(59, 130, 246, 0.3);
    border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
    background: rgba(59, 130, 246, 0.5);
}
</style>
