<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { ApplicationLogo } from '@/Components/ApplicationLogo.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Connexion Sécurisée - Immo Sahel" />

    <div class="min-h-screen bg-gradient-to-br from-neutral-50 via-white to-primary-50">
        <!-- Animated Background -->
        <div class="absolute inset-0">
            <div class="absolute left-0 top-1/4 h-96 w-96 -translate-x-1/4 animate-[float_6s_ease-in-out_infinite] rounded-full bg-primary-500/5 blur-3xl"></div>
            <div class="absolute right-0 bottom-1/4 h-80 w-80 translate-x-1/4 animate-[float_8s_ease-in-out_infinite_reverse] rounded-full bg-gold-400/10 blur-3xl"></div>
        </div>

        <div class="relative z-10 isolate flex min-h-screen flex-col">
            <!-- Header -->
            <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-xl border-b border-neutral-200/50 py-8">
                <div class="mx-auto w-full max-w-7xl px-6 lg:px-8">
                    <Link href="/" class="group flex items-center gap-4">
                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-neutral-900 to-primary-900 shadow-2xl group-hover:shadow-3xl transition-all duration-300">
                            <ApplicationLogo class="h-10 w-10 fill-white" />
                        </div>
                        <div>
                            <h1 class="font-serif text-2xl font-black tracking-tight text-neutral-900">Immo Sahel</h1>
                            <p class="text-xs uppercase tracking-[0.4em] text-primary-700 font-medium">Espace Agence</p>
                        </div>
                    </Link>
                </div>
            </header>

            <div class="flex flex-1 items-center justify-center py-16">
                <div class="w-full max-w-md">
                    <!-- Main Card -->
                    <div class="relative isolate rounded-3xl bg-white/90 shadow-2xl backdrop-blur-xl border border-white/50 p-10">
                        <!-- Decorative Elements -->
                        <div class="pointer-events-none absolute -inset-1 rounded-3xl bg-gradient-to-r from-primary-500/5 to-gold-500/5 blur-xl opacity-75"></div>

                        <!-- Content -->
                        <div class="relative">
                            <!-- Icon & Title -->
                            <div class="mx-auto mb-10 flex h-24 w-24 items-center justify-center rounded-3xl bg-gradient-to-br from-primary-500 to-primary-600 text-3xl font-black text-white shadow-2xl">
                                <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <h1 class="text-center text-3xl font-serif font-black text-neutral-900 mb-4">Connexion Agence</h1>
                            <p class="mx-auto mb-10 max-w-sm text-center text-lg text-neutral-600">
                                Accédez à votre tableau de bord pour gérer le catalogue prestige et suivre vos leads.
                            </p>

                            <!-- Status -->
                            <div v-if="status" class="mb-8 rounded-2xl bg-emerald-50 border border-emerald-200 p-5">
                                <div class="flex items-center gap-3 text-emerald-800">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="font-semibold">{{ status }}</span>
                                </div>
                            </div>

                            <!-- Form -->
                            <form @submit.prevent="submit" class="space-y-6">
                                <!-- Email -->
                                <div>
                                    <label class="mb-3 block text-sm font-bold uppercase tracking-wide text-neutral-700">Email Professionnel</label>
                                    <div class="group relative">
                                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 h-5 w-5 text-neutral-400 group-focus-within:text-primary-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        <input
                                            v-model="form.email"
                                            type="email"
                                            required
                                            autofocus
                                            autocomplete="email"
                                            class="w-full rounded-2xl border border-neutral-200 bg-neutral-50/50 px-14 py-5 text-lg shadow-inner backdrop-blur-sm placeholder:text-neutral-500 focus:border-primary-400 focus:ring-4 focus:ring-primary-100/50 focus:outline-none transition-all duration-300"
                                            placeholder="agence@example.com"
                                        />
                                    </div>
                                    <p v-if="form.errors.email" class="mt-2 text-sm text-red-600">{{ form.errors.email[0] }}</p>
                                </div>

                                <!-- Password -->
                                <div>
                                    <label class="mb-3 block text-sm font-bold uppercase tracking-wide text-neutral-700">Mot de Passe</label>
                                    <div class="group relative">
                                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 h-5 w-5 text-neutral-400 group-focus-within:text-primary-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                        <input
                                            v-model="form.password"
                                            type="password"
                                            required
                                            autocomplete="current-password"
                                            class="w-full rounded-2xl border border-neutral-200 bg-neutral-50/50 px-14 py-5 text-lg shadow-inner backdrop-blur-sm placeholder:text-neutral-500 focus:border-primary-400 focus:ring-4 focus:ring-primary-100/50 focus:outline-none transition-all duration-300"
                                            placeholder="••••••••"
                                        />
                                    </div>
                                    <p v-if="form.errors.password" class="mt-2 text-sm text-red-600">{{ form.errors.password[0] }}</p>
                                </div>

                                <!-- Remember Me -->
                                <label class="flex cursor-pointer items-center gap-3 rounded-2xl border border-neutral-200 bg-neutral-50/50 p-4 backdrop-blur-sm hover:border-neutral-300 transition-all">
                                    <input
                                        type="checkbox"
                                        v-model="form.remember"
                                        class="h-5 w-5 rounded-lg border-neutral-300 text-primary-600 focus:ring-primary-500 transition-all"
                                    />
                                    <span class="text-sm text-neutral-700 font-medium">Rester connecté 30 jours</span>
                                </label>

                                <!-- Submit Button -->
                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="group relative w-full rounded-3xl bg-gradient-to-r from-primary-600 to-primary-700 py-6 px-8 text-xl font-bold text-white shadow-2xl hover:shadow-3xl hover:from-primary-700 hover:to-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-none"
                                >
                                    <span v-if="!form.processing">
                                        <svg class="mr-3 inline h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                        </svg>
                                        Accéder au Dashboard
                                    </span>
                                    <span v-else class="flex items-center justify-center">
                                        <svg class="mr-3 h-6 w-6 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                                        </svg>
                                        Connexion...
                                    </span>
                                    <div class="pointer-events-none absolute inset-0 rounded-3xl opacity-0 transition-opacity group-hover:opacity-100 bg-gradient-to-r from-primary-500/20" />
                                </button>

                                <!-- Forgot Password -->
                                <Link
                                    v-if="canResetPassword"
                                    :href="route('password.request')"
                                    class="block w-full text-center rounded-xl border-2 border-transparent bg-gradient-to-r from-neutral-50 to-white/60 px-6 py-4 text-sm font-bold text-neutral-800 hover:border-neutral-300 hover:shadow-md backdrop-blur-sm transition-all duration-300"
                                >
                                    Mot de passe oublié ?
                                </Link>
                            </form>

                            <!-- Divider -->
                            <div class="relative my-8">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-neutral-200" />
                                </div>
                                <div class="relative flex justify-center">
                                    <span class="px-4 py-2 text-sm font-bold text-neutral-600 bg-white">Ou</span>
                                </div>
                            </div>

                            <!-- Alternative Links -->
                            <Link
                                :href="route('register')"
                                class="block w-full rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 px-6 py-4 text-center text-sm font-bold text-white shadow-lg hover:shadow-xl hover:from-emerald-600 hover:to-teal-600 transition-all duration-300"
                            >
                                Créer un compte Agence
                            </Link>

                            <p class="mt-8 pt-8 border-t border-neutral-200 text-center text-sm text-neutral-600">
                                <Link href="/" class="font-medium text-primary-700 hover:text-primary-800 transition-colors">
                                    ← Retour au catalogue public
                                </Link>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Decorative Footer -->
            <footer class="mt-auto border-t border-neutral-200/50 bg-white/80 py-12 backdrop-blur-sm">
                <div class="mx-auto w-full max-w-7xl px-6 text-center lg:px-8">
                    <p class="text-xs text-neutral-500">
                        © {{ new Date().getFullYear() }} Immo Sahel Prestige • Tous droits réservés • 
                        <Link href="/privacy" class="hover:text-primary-700 transition-colors">Politique de confidentialité</Link>
                    </p>
                </div>
            </footer>
        </div>
    </div>
</template>
