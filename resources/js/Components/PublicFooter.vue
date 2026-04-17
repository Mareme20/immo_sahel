<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';

const phoneNumber = '+221770000000';
const currentYear = new Date().getFullYear();
const whatsappUrl = `https://wa.me/${phoneNumber.replace('+', '')}?text=${encodeURIComponent(
    'Bonjour, je souhaite obtenir plus d’informations sur vos biens immobiliers.',
)}`;
</script>

<template>
    <footer class="pt-14">
        <div class="sahel-shell">
            <div class="overflow-hidden rounded-[2.2rem] bg-[#0d2d30] text-white shadow-[0_34px_90px_rgba(15,61,62,0.24)]">
                <div class="grid gap-10 px-6 py-10 sm:px-8 lg:grid-cols-[1.15fr_0.85fr_0.85fr] lg:px-10 lg:py-12">
                    <div class="max-w-xl">
                        <div class="flex items-center gap-3">
                            <ApplicationLogo class="h-12 w-12 text-white" />
                            <div>
                                <p class="font-display text-2xl leading-none">Agence Immo Sahel</p>
                                <p class="mt-1 text-[11px] uppercase tracking-[0.28em] text-white/50">
                                    Immobilier de confiance
                                </p>
                            </div>
                        </div>

                        <p class="mt-6 text-base leading-8 text-white/70">
                            Une présence en ligne plus premium pour mieux présenter les biens, rassurer les visiteurs
                            et faciliter les prises de contact.
                        </p>

                        <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                            <Link
                                :href="route('properties.index')"
                                class="sahel-button-primary bg-[#c9893e] hover:bg-[#d79b55] focus:ring-[#c9893e]/25"
                            >
                                Voir le catalogue
                            </Link>
                            <a
                                :href="whatsappUrl"
                                target="_blank"
                                class="sahel-button-secondary border-white/20 bg-white/10 text-white hover:border-white/40 hover:bg-white/20 hover:text-white"
                            >
                                WhatsApp
                            </a>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-white/45">Navigation</p>
                        <div class="mt-5 space-y-3">
                            <Link :href="route('home')" class="block text-sm text-white/75 transition hover:text-white">
                                Accueil
                            </Link>
                            <Link
                                :href="route('properties.index')"
                                class="block text-sm text-white/75 transition hover:text-white"
                            >
                                Catalogue public
                            </Link>
                            <Link
                                v-if="$page.props.auth.user"
                                :href="route('dashboard')"
                                class="block text-sm text-white/75 transition hover:text-white"
                            >
                                Dashboard
                            </Link>
                            <Link
                                v-else
                                :href="route('login')"
                                class="block text-sm text-white/75 transition hover:text-white"
                            >
                                Connexion agence
                            </Link>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-white/45">Contact</p>
                        <div class="mt-5 space-y-3">
                            <a :href="`tel:${phoneNumber}`" class="block text-sm text-white/75 transition hover:text-white">
                                {{ phoneNumber }}
                            </a>
                            <a
                                :href="whatsappUrl"
                                target="_blank"
                                class="block text-sm text-white/75 transition hover:text-white"
                            >
                                Contacter un conseiller
                            </a>
                            <p class="text-sm text-white/55">
                                Présentation, visite, vente et location de biens immobiliers.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="border-t border-white/10 px-6 py-5 sm:px-8 lg:px-10">
                    <div class="flex flex-col gap-3 text-sm text-white/50 sm:flex-row sm:items-center sm:justify-between">
                        <p>© {{ currentYear }} Agence Immo Sahel. Tous droits réservés.</p>
                        <p>Catalogue public, fiches premium et contact rapide.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>
