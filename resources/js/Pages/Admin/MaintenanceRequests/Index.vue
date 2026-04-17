<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PaginationLinks from '@/Components/PaginationLinks.vue';
import { Head, Link, router } from '@inertiajs/vue3';

defineProps({
    requests: Object,
    stats: Object,
});

const deleteRequest = (requestId) => {
    if (confirm('Supprimer cette demande de maintenance ?')) {
        router.delete(route('admin.maintenance-requests.destroy', requestId));
    }
};

const formatCurrency = (amount) =>
    amount
        ? new Intl.NumberFormat('fr-FR', {
              style: 'currency',
              currency: 'XOF',
              maximumFractionDigits: 0,
          }).format(amount)
        : 'Non estime';

const formatDate = (value) =>
    value ? new Date(value).toLocaleDateString('fr-FR') : 'Non renseignee';

const priorityLabels = {
    low: 'Faible',
    medium: 'Moyenne',
    high: 'Haute',
    urgent: 'Urgente',
};

const priorityClasses = {
    low: 'bg-slate-100 text-slate-600',
    medium: 'bg-blue-50 text-blue-700',
    high: 'bg-amber-50 text-amber-700',
    urgent: 'bg-red-50 text-red-700',
};

const statusLabels = {
    open: 'Ouverte',
    in_progress: 'En cours',
    resolved: 'Resolue',
    closed: 'Cloturee',
};
</script>

<template>
    <Head title="Maintenance - Administration" />

    <AuthenticatedLayout>
        <template #header>
            <div class="admin-shell py-6">
                <div class="grid gap-4 lg:grid-cols-[1.3fr_0.7fr]">
                    <div class="admin-card overflow-hidden bg-gradient-to-br from-slate-900 to-slate-800 p-8 text-white">
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-white/60">Maintenance</p>
                        <h1 class="mt-3 font-display text-3xl">Interventions et travaux</h1>
                        <p class="mt-3 max-w-2xl text-sm leading-6 text-white/70">
                            Suis les incidents, les priorites et les couts estimes pour garder un parc fiable et bien pilote.
                        </p>
                    </div>

                    <div class="admin-card p-6">
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-400">Action rapide</p>
                        <h2 class="mt-3 text-xl font-semibold text-slate-900">Nouvelle demande</h2>
                        <p class="mt-2 text-sm text-slate-500">
                            Enregistre un incident, un devis ou un chantier sur un bien du portefeuille.
                        </p>
                        <Link :href="route('admin.maintenance-requests.create')" class="admin-button-primary mt-5">
                            Ajouter une intervention
                        </Link>
                    </div>
                </div>
            </div>
        </template>

        <div class="admin-shell py-8">
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div class="admin-card p-5">
                    <div class="text-sm text-slate-500">Total</div>
                    <div class="mt-2 text-3xl font-semibold text-slate-900">{{ stats.total }}</div>
                </div>
                <div class="admin-card p-5">
                    <div class="text-sm text-slate-500">Ouvertes</div>
                    <div class="mt-2 text-3xl font-semibold text-slate-900">{{ stats.open }}</div>
                </div>
                <div class="admin-card p-5">
                    <div class="text-sm text-slate-500">En cours</div>
                    <div class="mt-2 text-3xl font-semibold text-slate-900">{{ stats.in_progress }}</div>
                </div>
                <div class="admin-card p-5">
                    <div class="text-sm text-slate-500">Urgentes</div>
                    <div class="mt-2 text-3xl font-semibold text-slate-900">{{ stats.urgent }}</div>
                </div>
            </div>

            <div class="admin-card mt-6 overflow-hidden">
                <div class="flex flex-col gap-3 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Operations</p>
                        <h2 class="mt-2 text-xl font-semibold text-slate-900">Suivi des incidents et travaux</h2>
                    </div>
                    <div class="text-sm text-slate-500">
                        {{ requests.total }} demande{{ requests.total > 1 ? 's' : '' }}
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Intervention</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Priorite</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Statut</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Cout</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            <tr v-for="request in requests.data" :key="request.id">
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-900">{{ request.title }}</div>
                                    <div class="mt-1 text-sm text-slate-500">
                                        {{ request.property?.title || 'Bien supprime' }} - {{ request.property?.location || '-' }}
                                    </div>
                                    <div class="text-sm text-slate-500">
                                        Signale le {{ formatDate(request.reported_at || request.created_at) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold" :class="priorityClasses[request.priority] || 'bg-slate-100 text-slate-600'">
                                        {{ priorityLabels[request.priority] || request.priority }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ statusLabels[request.status] || request.status }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ formatCurrency(request.estimated_cost) }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-end gap-3">
                                        <Link :href="route('admin.maintenance-requests.edit', request.id)" class="rounded-full border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 transition hover:border-slate-300 hover:bg-slate-50">
                                            Modifier
                                        </Link>
                                        <button type="button" class="rounded-full border border-red-200 px-4 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50" @click="deleteRequest(request.id)">
                                            Supprimer
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="px-6 pb-6">
                    <PaginationLinks :links="requests.links" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
