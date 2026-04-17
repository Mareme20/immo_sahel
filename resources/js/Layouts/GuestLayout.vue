<script setup>
import { Link } from '@inertiajs/vue3';
import { ApplicationLogo } from '@/Components/ApplicationLogo.vue';
import { onMounted, ref } from 'vue';
</script>

<template>
    <div class="relative min-h-screen overflow-hidden bg-gradient-to-br from-neutral-50 via-white to-gold-50">
        <!-- Animated Background Blobs -->
        <div class="absolute inset-0">
            <div class="absolute -left-40 top-20 h-96 w-96 animate-float rounded-full bg-primary-500/5 blur-3xl"></div>
            <div class="absolute right-0 top-1/4 h-80 w-80 animate-[float_4s_ease-in-out_infinite_reverse] rounded-full bg-gold-400/10 blur-3xl"></div>
            <div class="absolute bottom-20 left-1/4 h-72 w-72 animate-[float_5s_ease-in-out_infinite_2s] rounded-full bg-copper-500/8 blur-xl"></div>
        </div>

        <div class="relative z-10 flex min-h-screen flex-col py-8 lg:py-12">
            <!-- Navbar -->
            <nav class="mx-auto w-full max-w-7xl px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <Link href="/" class="group flex items-center gap-4">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-neutral-900 to-primary-900 p-3 shadow-2xl transition-all group-hover:scale-105 group-hover:shadow-3xl">
                            <ApplicationLogo class="h-9 w-9 fill-white drop-shadow-lg" />
                        </div>
                        <div>
                            <h1 class="font-serif text-2xl font-black tracking-tight text-neutral-900 drop-shadow-sm lg:text-3xl">
                                Immo Sahel
                            </h1>
                            <p class="mt-px text-[11px] uppercase tracking-[0.4em] text-gold-700">Prestige & Confiance</p>
                        </div>
                    </Link>

                    <div class="hidden items-center gap-3 lg:flex">
                        <Link :href="route('properties.index')" class="text-sm font-semibold text-neutral-600 hover:text-primary-700 transition-all">
                            Catalogue
                        </Link>
                        <Link href="/#contact" class="text-sm font-semibold text-neutral-600 hover:text-primary-700 transition-all">
                            Contact
                        </Link>
                        <Link
                            :href="route('login')"
                            class="rounded-full bg-primary-600 px-6 py-2.5 text-sm font-semibold text-white shadow-lg hover:bg-primary-700 hover:shadow-xl transition-all"
                        >
                            Espace Agence
                        </Link>
                    </div>
                </div>
            </nav>

            <!-- Main Content Grid -->
            <main class="flex-1">
                <div class="mx-auto w-full max-w-7xl px-6 lg:px-8 lg:pb-24">
                    <div class="grid min-h-[70vh] items-center gap-12 lg:grid-cols-[1.1fr_0.9fr] lg:gap-20">
                        <!-- Left Content (Marketing) -->
                        <section class="lg:text-left">
                            <span class="inline-flex animate-fade-in items-center gap-2 rounded-full bg-gold-50/80 px-4 py-2 text-xs font-bold uppercase tracking-[0.3em] text-gold-700 backdrop-blur-sm">
                                <div class="h-2 w-2 animate-ping rounded-full bg-gold-400"></div>
                                Accès Sécurisé
                            </span>

                            <h1 class="mt-8 font-serif text-4xl font-black leading-[1.1] text-neutral-900 sm:text-6xl lg:text-7xl animate-slide-up">
                                Plateforme
                                <span class="bg-gradient-to-r from-primary-600 via-gold-500 to-copper-500 bg-clip-text text-transparent drop-shadow-lg">Immobilière</span>
                                <br />
                                Premium
                            </h1>

                            <p class="mt-8 max-w-xl text-lg leading-relaxed text-neutral-600 animate-[fade-in_0.8s_ease-out_0.2s] lg:text-xl">
                                Gérez votre catalogue de biens d'exception avec une interface élégante et performante. 
                                Chaque détail pensé pour l'excellence immobilière.
                            </p>

                            <div class="mt-12 flex animate-[fade-in_1s_ease-out_0.4s] flex-col gap-4 sm:flex-row lg:justify-start">
                                <Link
                                    :href="route('login')"
                                    class="group flex w-full max-w-sm items-center justify-center gap-3 rounded-2xl bg-gradient-to-r from-primary-600 to-primary-700 px-8 py-4 font-semibold text-white shadow-2xl hover:shadow-3xl sm:w-auto transition-all duration-300 group-hover:-translate-y-1"
                                >
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                    </svg>
                                    Accéder au Back-office
                                </Link>
                                <Link
                                    :href="route('properties.index')"
                                    class="group flex w-full max-w-sm items-center justify-center gap-3 rounded-2xl border-2 border-primary-600/50 bg-white/80 px-8 py-4 font-semibold text-primary-700 backdrop-blur-sm hover:border-primary-700 hover:bg-white hover:shadow-xl sm:w-auto transition-all duration-300"
                                >
                                    Explorer le Catalogue Public
                                </Link>
                            </div>

                            <!-- Feature Cards -->
                            <div class="mt-20 grid animate-[fade-in_1.2s_ease-out_0.6s] gap-4 sm:grid-cols-3 lg:mt-24">
                                <div class="group cursor-default rounded-2xl bg-white/70 p-6 shadow-xl backdrop-blur-sm transition-all hover:shadow-2xl">
                                    <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-primary-500 to-primary-600 text-white shadow-lg">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                    <h3 class="font-display text-lg font-bold text-neutral-900 group-hover:text-primary-700">Catalogue Premium</h3>
                                    <p class="mt-2 text-sm text-neutral-600">Présentation haut de gamme de vos biens</p>
                                </div>
                                <div class="group cursor-default rounded-2xl bg-white/70 p-6 shadow-xl backdrop-blur-sm transition-all hover:shadow-2xl">
                                    <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-gold-500 to-copper-500 text-white shadow-lg">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <h3 class="font-display text-lg font-bold text-neutral-900 group-hover:text-gold-600">Gestion Intuitive</h3>
                                    <p class="mt-2 text-sm text-neutral-600">CRM, loyers et maintenance unifiées</p>
                                </div>
                                <div class="group cursor-default rounded-2xl bg-white/70 p-6 shadow-xl backdrop-blur-sm transition-all hover:shadow-2xl">
                                    <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-neutral-900 to-primary-900 text-white shadow-lg">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364a4.5 4.5 0 006.364 0 4.5 4.5 0 000-6.364L13.17 11a4.5 4.5 0 00-5.517 0l-1.335 1.337z" />
                                        </svg>
                                    </div>
                                    <h3 class="font-display text-lg font-bold text-neutral-900 group-hover:text-primary-700">Conversion Optimisée</h3>
                                    <p class="mt-2 text-sm text-neutral-600">Designs pensés pour vendre plus</p>
                                </div>
                            </div>
                        </section>

                        <!-- Right Form Panel -->
                        <section class="relative w-full max-w-lg lg:ml-auto">
                            <div class="sahel-panel relative z-10 rounded-3xl p-8 sm:p-10 lg:p-12 shadow-2xl animate-slide-up">
                                <slot />
                            </div>
                            <!-- Decorative Elements -->
                            <div class="pointer-events-none absolute -right-8 -top-8 h-24 w-24 rounded-2xl bg-gradient-to-br from-gold-400/20 to-transparent blur-xl"></div>
                            <div class="pointer-events-none absolute -bottom-6 left-4 h-20 w-20 rounded-full bg-primary-400/10 blur-lg"></div>
                        </section>
                    </div>
                </div>
            </main>

            <!-- Minimal Footer -->
            <footer class="mt-auto border-t border-neutral-200/50 bg-white/80 backdrop-blur-sm py-8">
                <div class="mx-auto w-full max-w-7xl px-6 text-center text-xs text-neutral-500 lg:px-8">
                    © {{ new Date().getFullYear() }} Agence Immo Sahel. Tous droits réservés.
                    <span class="mx-4">•</span>
                    <Link href="/privacy" class="hover:text-primary-600 transition-colors">Confidentialité</Link>
                </div>
            </footer>
        </div>
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Inter:wght@300;400;500;600;700&display=swap');

:root {
    --font-clash: 'Clash Display', serif;
    font-feature-settings: 'rlig' 1, 'calt' 1;
}

.sahel-panel {
    @apply border-white/20 bg-white/90 shadow-[0_35px_100px_rgba(15,23,42,0.12)] backdrop-blur-2xl;
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}
</style>
