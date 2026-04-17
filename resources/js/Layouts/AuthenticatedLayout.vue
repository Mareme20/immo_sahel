<script setup>
import { computed, ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import AdminIcon from '@/Components/AdminIcon.vue';
import QuickActionFab from '@/Components/QuickActionFab.vue';

const showingNavigationDropdown = ref(false);

const mainNavigation = computed(() => [
    {
        label: 'Tableau de bord',
        icon: 'chart-bar',
        href: route('dashboard'),
        active: route().current('dashboard'),
        available: true,
    },
    {
        label: 'Biens Immobiliers',
        icon: 'building-office-2',
        href: route('admin.properties.index'),
        active: route().current('admin.properties.*'),
        available: true,
    },
    {
        label: 'Demandes Clients',
        icon: 'chat-bubble-left',
        href: route('admin.inquiries.index'),
        active: route().current('admin.inquiries.*'),
        available: true,
    },
    {
        label: 'Contacts',
        icon: 'users',
        href: route('admin.contacts.index'),
        active: route().current('admin.contacts.*'),
        available: true,
    },
    {
        label: 'Loyers & Finance',
        icon: 'currency-dollar',
        href: route('admin.rent-payments.index'),
        active: route().current('admin.rent-payments.*'),
        available: true,
    },
    {
        label: 'Maintenance',
        icon: 'wrench-screwdriver',
        href: route('admin.maintenance-requests.index'),
        active: route().current('admin.maintenance-requests.*'),
        available: true,
    },
]);
</script>

<template>
    <div class="flex min-h-screen bg-gradient-to-br from-neutral-50 via-white to-primary-50">
        <!-- Enhanced Sidebar -->
        <aside class="admin-sidebar fixed left-0 top-0 z-50 h-screen w-72 flex-shrink-0 overflow-hidden bg-gradient-to-b from-primary-900 via-primary-800 to-neutral-900 shadow-2xl backdrop-blur-xl transition-all duration-300">
            <div class="flex h-full flex-col p-6">
                <!-- Logo -->
                <Link :href="route('dashboard')" class="group mb-10 flex items-center gap-3 rounded-2xl bg-white/10 p-4 backdrop-blur-sm transition-all group-hover:bg-white/20">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-gold-400 to-copper-500 p-2.5 shadow-xl">
                        <ApplicationLogo class="h-8 w-8 fill-white" />
                    </div>
                    <div>
                        <h1 class="font-display text-xl font-black text-white drop-shadow-lg">ImmoPilot</h1>
                        <p class="text-xs uppercase tracking-[0.3em] text-gold-200">Pro Admin</p>
                    </div>
                </Link>

                <!-- Navigation -->
                <nav class="flex-1 space-y-1">
                    <div class="mb-6 text-xs font-bold uppercase tracking-[0.3em] text-white/60">Navigation</div>
                    <div v-for="item in mainNavigation" :key="item.label" class="space-y-1">
                        <Link
                            v-if="item.available"
                            :href="item.href"
                            class="admin-sidebar-link group flex items-center gap-3 rounded-xl p-3 text-white/90 transition-all hover:bg-white/10 hover:text-white focus:outline-none focus:ring-2 focus:ring-gold-400"
                            :class="{ 'admin-sidebar-link-active bg-white/20 text-white ring-2 ring-gold-400/50 !ring-offset-0 shadow-xl': item.active }"
                        >
                            <AdminIcon :name="item.icon" class="h-5 w-5 flex-shrink-0" />
                            <span>{{ item.label }}</span>
                        </Link>
                        <div v-else class="admin-sidebar-link flex items-center gap-3 rounded-xl p-3 opacity-50">
                            <AdminIcon :name="item.icon" class="h-5 w-5 flex-shrink-0" />
                            <span>{{ item.label }}</span>
                            <span class="ml-auto rounded-full bg-white/20 px-2.5 py-1 text-xs font-bold uppercase tracking-wide text-white">Bientôt</span>
                        </div>
                    </div>
                </nav>

                <!-- Footer -->
                <div class="mt-auto space-y-3 pt-8">
                    <div class="flex items-center gap-3 rounded-2xl bg-white/5 p-4 backdrop-blur-sm">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-gold-500 to-copper-500 font-bold uppercase text-xs tracking-wide text-white shadow-lg">
                            {{ $page.props.auth.user.name?.slice(0, 2).toUpperCase() || 'AD' }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate font-semibold text-white">{{ $page.props.auth.user.name }}</p>
                            <p class="text-xs text-gold-200">Administrateur</p>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <Link :href="route('profile.edit')" class="admin-sidebar-link flex items-center gap-3 p-3 text-white/80 hover:bg-white/10">
                            <AdminIcon name="user-circle" class="h-5 w-5" />
                            Mon Profil
                        </Link>
                        <Link :href="route('logout')" method="post" as="button" class="admin-sidebar-link flex items-center gap-3 p-3 text-rose-300 hover:bg-rose-500/10">
                            <AdminIcon name="arrow-right-start-on-rectangle" class="h-5 w-5" />
                            Déconnexion
                        </Link>
                    </div>

                    <Link
                        :href="route('properties.index')"
                        class="group flex items-center justify-center gap-2 rounded-2xl bg-white/10 p-3 text-white backdrop-blur-sm transition-all hover:bg-white/20 hover:shadow-lg"
                    >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        Site Public
                    </Link>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="ml-72 flex min-w-0 flex-1 flex-col">
            <!-- Topbar -->
            <header class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-4 border-b border-neutral-200/50 bg-white/90 px-6 backdrop-blur-xl lg:h-20 lg:px-8 lg:pl-2">
                <button
                    @click="showingNavigationDropdown = !showingNavigationDropdown"
                    class="lg:hidden p-2 text-neutral-700 hover:bg-neutral-100 rounded-xl transition-colors"
                >
                    <AdminIcon name="bars-3" class="h-6 w-6" />
                </button>

                <div class="flex items-center gap-4">
                    <div class="hidden lg:block">
                        <div class="text-xs font-bold uppercase tracking-[0.3em] text-neutral-500">Back-Office</div>
                        <div class="text-sm font-semibold text-neutral-900">Gestion Complète</div>
                    </div>
                </div>

                <div class="ml-auto flex items-center gap-3">
                    <div class="flex items-center gap-2 rounded-full bg-emerald-50/80 px-4 py-2 text-xs font-semibold text-emerald-700 backdrop-blur">
                        <div class="h-2 w-2 animate-pulse rounded-full bg-emerald-400"></div>
                        Système Opérationnel
                    </div>

                    <div class="flex items-center gap-3 rounded-2xl bg-white/50 px-3 py-2 backdrop-blur border border-neutral-200/50">
                        <div
                            class="flex h-8 w-8 items-center justify-center rounded-xl bg-gradient-to-br from-primary-500 to-primary-600 font-bold uppercase text-xs text-white shadow-md"
                        >
                            {{ $page.props.auth.user.name?.slice(0, 2).toUpperCase() || 'AD' }}
                        </div>
                        <div class="min-w-0 max-w-48">
                            <div class="truncate text-sm font-semibold text-neutral-900">{{ $page.props.auth.user.name }}</div>
                            <div class="truncate text-xs text-neutral-500">{{ $page.props.auth.user.email }}</div>
                        </div>
                        <Link :href="route('profile.edit')" class="-mr-1 p-1 hover:bg-neutral-200 rounded-lg transition-colors">
                            <AdminIcon name="pencil-square" class="h-4 w-4 text-neutral-600" />
                        </Link>
                    </div>
                </div>
            </header>

            <!-- Mobile Overlay Nav -->
            <div
                v-if="showingNavigationDropdown"
                class="fixed inset-0 z-50 bg-neutral-900/95 backdrop-blur-xl lg:hidden"
                @click="showingNavigationDropdown = false"
            >
                <div
                    class="absolute right-0 top-0 h-full w-80 bg-gradient-to-b from-neutral-900 via-primary-900 to-primary-800 p-8"
                    @click.stop
                >
                    <nav class="space-y-4">
                        <div v-for="item in mainNavigation" :key="item.label">
                            <Link
                                v-if="item.available"
                                :href="item.href"
                                class="admin-sidebar-link flex items-center gap-4 rounded-xl p-4 text-white hover:bg-white/10"
                                @click="showingNavigationDropdown = false"
                            >
                                <AdminIcon :name="item.icon" class="h-6 w-6" />
                                <span class="text-lg font-semibold">{{ item.label }}</span>
                            </Link>
                        </div>
                    </nav>
                </div>
            </div>

            <!-- Flash Messages -->
            <div v-if="$page.props.flash?.message" class="border-b border-emerald-200/50 bg-emerald-50/80 px-6 py-4 backdrop-blur-sm">
                <div class="flex items-center gap-3 text-emerald-800">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ $page.props.flash.message }}
                </div>
            </div>

            <!-- Page Header -->
            <header v-if="$slots.header" class="border-b border-neutral-200/50 bg-white/80 px-6 py-8 backdrop-blur-sm lg:px-8 lg:py-10">
                <div class="container-lg">
                    <slot name="header" />
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 p-6 lg:p-8">
                <slot />
            </main>
        </div>

        <QuickActionFab />
    </div>
</template>

<style scoped>
/* Scoped animations & fine-tuning */
.admin-sidebar {
    scrollbar-width: thin;
    scrollbar-color: rgba(255,255,255,0.2) transparent;
}

.admin-sidebar::-webkit-scrollbar {
    width: 4px;
}

.admin-sidebar::-webkit-scrollbar-track {
    background: transparent;
}

.admin-sidebar::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,0.2);
    border-radius: 2px;
}

.admin-sidebar-link-active {
    position: relative;
}

admin-sidebar-link-active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    height: 1.5rem;
    width: 0.25rem;
    background: theme('colors.gold.400');
    border-radius: 9999px;
}

/* Responsive */
@media (max-width: 1024px) {
    .admin-sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
}
</style>
