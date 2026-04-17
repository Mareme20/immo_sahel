<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { ApplicationLogo } from '@/Components/ApplicationLogo.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const showPassword = ref(false);
const showPasswordConfirmation = ref(false);

const submit = () => {
    form.post(route('register'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation');
            form.password = '';
            form.password_confirmation = '';
        },
    });
};
</script>

<template>
    <Head title="Créer Compte Agence - Immo Sahel" />

    <div class="min-h-screen bg-gradient-to-br from-neutral-50 via-white to-gold-50">
        <!-- Background Animations -->
        <div class="absolute inset-0">
            <div class="absolute left-20 top-20 h-80 w-80 animate-[float_7s_ease-in-out_infinite] rounded-full bg-emerald-500/3 blur-3xl"></div>
            <div class="absolute right-10 bottom-1/4 h-72 w-72 animate-[float_9s_ease-in-out_infinite_2s_reverse] rounded-full bg-gold-400/5 blur-3xl"></div>
        </div>

        <div class="relative z-10 flex min-h-screen flex-col">
            <!-- Header -->
            <header class="sticky top-0 z-50 bg-white/95 border-b border-neutral-200/50 py-8 backdrop-blur-xl shadow-sm">
                <div class="mx-auto w-full max-w-7xl px-6 lg:px-8">
                    <Link href="/" class="group flex items-center gap-4">
                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-neutral-900 to-primary-900 shadow-xl group-hover:shadow-2xl transition-all">
                            <ApplicationLogo class="h-10 w-10 fill-white" />
                        </div>
                        <div>
                            <h1 class="font-serif text-2xl font-black tracking-tight text-neutral-900">Immo Sahel</h1>
                            <p class="text-xs uppercase tracking-[0.4em] text-emerald-700 font-medium">Inscription Agence</p>
                        </div>
                    </Link>
                </div>
            </header>

            <div class="flex flex-1 items-center justify-center py-16 lg:py-24">
                <div class="w-full max-w-md">
                    <!-- Registration Card -->
                    <div class="relative isolate rounded-3xl bg-white/90 shadow-2xl backdrop-blur-xl border border-white/40 p-10 lg:p-12">
                        <!-- Decorative gradient -->
                        <div class="pointer-events-none absolute inset-0.5 rounded-3xl bg-gradient-to-r from-emerald-500/3 via-primary-500/2 to-gold-500/3 blur opacity-75"></div>

                        <div class="relative">
                            <!-- Icon Header -->
                            <div class="mx-auto mb-12 flex h-28 w-28 items-center justify-center rounded-3xl bg-gradient-to-br from-emerald-500 to-teal-600 text-3xl font-black text-white shadow-2xl">
                                <svg class="h-16 w-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>

                            <h1 class="text-center text-4xl font-serif font-black text-neutral-900 mb-6">Nouveau Compte</h1>
                            <p class="mx-auto mb-12 max-w-sm text-center text-xl text-neutral-600 leading-relaxed">
                                Créez votre espace agence pour gérer publications, leads et analytics immobiliers en temps réel.
                            </p>

                            <!-- Form -->
                            <form @submit.prevent="submit" class="space-y-6">
                                <!-- Name -->
                                <div>
                                    <label class="mb-3 block text-sm font-bold uppercase tracking-wide text-neutral-700">Nom Complet</label>
                                    <div class="group relative">
                                        <svg class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 transform text-neutral-400 group-focus-within:text-primary-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <input
                                            v-model="form.name"
                                            type="text"
                                            required
                                            autofocus
                                            autocomplete="name"
                                            class="w-full rounded-2xl border border-neutral-200 bg-neutral-50/50 pl-14 py-5 px-4 text-lg shadow-inner backdrop-blur-sm placeholder:text-neutral-500 focus:border-primary-400 focus:ring-4 focus:ring-primary-100/50 focus:outline-none transition-all duration-300"
                                            placeholder="Agence XYZ"
                                        />
                                    </div>
                                    <p v-if="form.errors.name" class="mt-2 text-sm text-red-600">{{ form.errors.name[0] }}</p>
                                </div>

                                <!-- Email -->
                                <div>
                                    <label class="mb-3 block text-sm font-bold uppercase tracking-wide text-neutral-700">Email Professionnel</label>
                                    <div class="group relative">
                                        <svg class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 transform text-neutral-400 group-focus-within:text-primary-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        <input
                                            v-model="form.email"
                                            type="email"
                                            required
                                            autocomplete="username"
                                            class="w-full rounded-2xl border border-neutral-200 bg-neutral-50/50 pl-14 py-5 px-4 text-lg shadow-inner backdrop-blur-sm placeholder:text-neutral-500 focus:border-primary-400 focus:ring-4 focus:ring-primary-100/50 focus:outline-none transition-all duration-300"
                                            placeholder="agence@immosahel.sn"
                                        />
                                    </div>
                                    <p v-if="form.errors.email" class="mt-2 text-sm text-red-600">{{ form.errors.email[0] }}</p>
                                </div>

                                <!-- Password -->
                                <div>
                                    <label class="mb-3 block text-sm font-bold uppercase tracking-wide text-neutral-700">Mot de Passe Sécurisé</label>
                                    <div class="group relative">
                                        <svg class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 transform text-neutral-400 group-focus-within:text-primary-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                        <input
                                            v-model="form.password"
                                            :type="showPassword ? 'text' : 'password'"
                                            required
                                            autocomplete="new-password"
                                            class="w-full rounded-2xl border border-neutral-200 bg-neutral-50/50 pl-14 pr-14 py-5 px-4 text-lg shadow-inner backdrop-blur-sm placeholder:text-neutral-500 focus:border-primary-400 focus:ring-4 focus:ring-primary-100/50 focus:outline-none transition-all duration-300"
                                            placeholder="Minimum 8 caractères sécurisés"
                                        />
                                        <button
                                            type="button"
                                            @click="showPassword = !showPassword"
                                            class="absolute right-4 top-1/2 -translate-y-1/2 flex h-10 w-10 items-center justify-center rounded-xl text-neutral-400 hover:text-neutral-600 hover:bg-neutral-100 transition-all"
                                        >
                                            <svg v-if="!showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <svg v-else class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                            </svg>
                                        </button>
                                    </div>
                                    <p v-if="form.errors.password" class="mt-2 text-sm text-red-600">{{ form.errors.password[0] }}</p>
                                </div>

                                <!-- Password Confirmation -->
                                <div>
                                    <label class="mb-3 block text-sm font-bold uppercase tracking-wide text-neutral-700">Confirmer Mot de Passe</label>
                                    <div class="group relative">
                                        <svg class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 transform text-neutral-400 group-focus-within:text-primary-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <input
                                            v-model="form.password_confirmation"
                                            :type="showPasswordConfirmation ? 'text' : 'password'"
                                            required
                                            autocomplete="new-password"
                                            class="w-full rounded-2xl border border-neutral-200 bg-neutral-50/50 pl-14 pr-14 py-5 px-4 text-lg shadow-inner backdrop-blur-sm placeholder:text-neutral-500 focus:border-primary-400 focus:ring-4 focus:ring-primary-100/50 focus:outline-none transition-all duration-300"
                                            placeholder="Confirmez votre mot de passe"
                                        />
                                        <button
                                            type="button"
                                            @click="showPasswordConfirmation = !showPasswordConfirmation"
                                            class="absolute right-4 top-1/2 -translate-y-1/2 flex h-10 w-10 items-center justify-center rounded-xl text-neutral-400 hover:text-neutral-600 hover:bg-neutral-100 transition-all"
                                        >
                                            <svg v-if="!showPasswordConfirmation" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <svg v-else class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                            </svg>
                                        </button>
                                    </div>
                                    <p v-if="form.errors.password_confirmation" class="mt-2 text-sm text-red-600">{{ form.errors.password_confirmation[0] }}</p>
                                </div>

                                <!-- Terms -->
                                <label class="flex cursor-pointer items-start gap-4 rounded-2xl border border-neutral-200 bg-neutral-50/50 p-5 backdrop-blur-sm hover:border-neutral-300 transition-all">
                                    <input
                                        type="checkbox"
                                        v-model="form.terms"
                                        required
                                        class="mt-1 h-5 w-5 rounded-lg border-neutral-300 text-primary-600 focus:ring-primary-500 transition-all"
                                    />
                                    <div class="text-sm leading-6 text-neutral-700">
                                        <p>J'accepte les <Link href="/terms" class="font-bold text-primary-700 hover:text-primary-800 transition-colors">conditions d'utilisation</Link> et la 
                                        <Link href="/privacy" class="font-bold text-primary-700 hover:text-primary-800 transition-colors">politique de confidentialité</Link>.
                                        </p>
                                    </div>
                                </label>

                                <!-- Submit -->
                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="group relative w-full rounded-3xl bg-gradient-to-r from-emerald-500 via-emerald-600 to-teal-600 py-7 px-8 text-xl font-black text-white shadow-2xl hover:shadow-3xl hover:from-emerald-600 hover:to-teal-700 focus:outline-none focus:ring-4 focus:ring-emerald-300 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-none"
                                >
                                    <span v-if="!form.processing">
                                        <svg class="mr-3 inline h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Créer Mon Compte Agence
                                    </span>
                                    <span v-else class="flex items-center justify-center">
                                        <svg class="mr-3 h-7 w-7 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                                        </svg>
                                        Création...
                                    </span>
                                    <div class="pointer-events-none absolute inset-0 rounded-3xl opacity-0 transition-opacity group-hover:opacity-100 bg-gradient-to-r from-emerald-500/20" />
                                </button>
                            </form>

                            <!-- Divider & Login Link -->
                            <div class="relative my-10">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-neutral-200/50" />
                                </div>
                                <div class="relative flex justify-center">
                                    <span class="px-6 py-3 text-sm font-bold text-neutral-600 bg-white">Déjà inscrit ?</span>
                                </div>
                            </div>

                            <Link
                                :href="route('login')"
                                class="block w-full rounded-3xl border-2 border-neutral-200/50 bg-white/60 px-8 py-5 text-center text-xl font-bold text-neutral-900 shadow-md hover:border-primary-300 hover:shadow-xl backdrop-blur-sm transition-all duration-300"
                            >
                                Se Connecter
                            </Link>

                            <p class="mt-10 pt-10 border-t border-neutral-200/50 text-center text-sm text-neutral-600">
                                <Link href="/" class="font-semibold text-primary-700 hover:text-primary-800 transition-colors">
                                    ← Découvrir le Catalogue
                                </Link>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="mt-auto border-t border-neutral-200/50 bg-white/80 py-12 backdrop-blur-sm">
                <div class="mx-auto w-full max-w-7xl px-6 text-center lg:px-8">
                    <p class="text-xs text-neutral-500">
                        © {{ new Date().getFullYear() }} Immo Sahel Prestige • 
                        <Link href="/terms" class="hover:text-primary-700 transition-colors">Conditions</Link> • 
                        <Link href="/privacy" class="hover:text-primary-700 transition-colors">Confidentialité</Link>
                    </p>
                </div>
            </footer>
        </div>
    </div>
</template>
