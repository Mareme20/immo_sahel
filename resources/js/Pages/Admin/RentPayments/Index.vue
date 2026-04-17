<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PaginationLinks from '@/Components/PaginationLinks.vue';
import { Head, Link, router } from '@inertiajs/vue3';

defineProps({
    payments: Object,
    stats: Object,
});

const deletePayment = (paymentId) => {
    if (confirm('Supprimer cet enregistrement de loyer ?')) {
        router.delete(route('admin.rent-payments.destroy', paymentId));
    }
};

const formatCurrency = (amount) =>
    new Intl.NumberFormat('fr-FR', {
        style: 'currency',
        currency: 'XOF',
        maximumFractionDigits: 0,
    }).format(amount ?? 0);

const formatDate = (value) =>
    value ? new Date(value).toLocaleDateString('fr-FR') : 'Non renseignee';

const statusLabels = {
    pending: 'En attente',
    paid: 'Paye',
    late: 'En retard',
    partial: 'Partiel',
    cancelled: 'Annule',
};

const statusClasses = {
    pending: 'bg-amber-50 text-amber-700',
    paid: 'bg-emerald-50 text-emerald-700',
    late: 'bg-red-50 text-red-700',
    partial: 'bg-blue-50 text-blue-700',
    cancelled: 'bg-slate-100 text-slate-600',
};
</script>

<template>
    <Head title="Loyers - Administration" />

    <AuthenticatedLayout>
        <template #header>
            <div class="admin-shell py-6">
                <div class="grid gap-4 lg:grid-cols-[1.3fr_0.7fr]">
                    <div class="admin-card overflow-hidden bg-gradient-to-br from-slate-900 to-slate-800 p-8 text-white">
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-white/60">Finance</p>
                        <h1 class="mt-3 font-display text-3xl">Suivi des loyers</h1>
                        <p class="mt-3 max-w-2xl text-sm leading-6 text-white/70">
                            Anticipe les echeances, visualise les retards et garde une trace propre des encaissements lies aux biens locatifs.
                        </p>
                    </div>

                    <div class="admin-card p-6">
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-400">Action rapide</p>
                        <h2 class="mt-3 text-xl font-semibold text-slate-900">Nouvelle echeance</h2>
                        <p class="mt-2 text-sm text-slate-500">
                            Cree une ligne de suivi pour un loyer, une regularisation ou un paiement partiel.
                        </p>
                        <Link :href="route('admin.rent-payments.create')" class="admin-button-primary mt-5">
                            Ajouter un paiement
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
                    <div class="text-sm text-slate-500">Payes</div>
                    <div class="mt-2 text-3xl font-semibold text-slate-900">{{ stats.paid }}</div>
                </div>
                <div class="admin-card p-5">
                    <div class="text-sm text-slate-500">En attente</div>
                    <div class="mt-2 text-3xl font-semibold text-slate-900">{{ stats.pending }}</div>
                </div>
                <div class="admin-card p-5">
                    <div class="text-sm text-slate-500">Montant a suivre</div>
                    <div class="mt-2 text-2xl font-semibold text-slate-900">{{ formatCurrency(stats.expected_amount) }}</div>
                </div>
            </div>

            <div class="admin-card mt-6 overflow-hidden">
                <div class="flex flex-col gap-3 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Encaissements</p>
                        <h2 class="mt-2 text-xl font-semibold text-slate-900">Historique et prochaines echeances</h2>
                    </div>
                    <div class="text-sm text-slate-500">
                        {{ payments.total }} ligne{{ payments.total > 1 ? 's' : '' }}
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Bien</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Locataire</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Periode</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Statut</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Montant</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            <tr v-for="payment in payments.data" :key="payment.id">
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-900">{{ payment.property?.title || 'Bien supprime' }}</div>
                                    <div class="mt-1 text-sm text-slate-500">{{ payment.property?.location || '-' }}</div>
                                    <div class="text-sm text-slate-500">Echeance: {{ formatDate(payment.due_date) }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ payment.tenant_contact?.name || 'Non assigne' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ payment.period_label || 'Periode non renseignee' }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold" :class="statusClasses[payment.status] || 'bg-slate-100 text-slate-600'">
                                        {{ statusLabels[payment.status] || payment.status }}
                                    </span>
                                    <div v-if="payment.paid_date" class="mt-2 text-xs text-slate-500">
                                        Regle le {{ formatDate(payment.paid_date) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-semibold text-slate-900">
                                    {{ formatCurrency(payment.amount) }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-end gap-3">
                                        <Link :href="route('admin.rent-payments.edit', payment.id)" class="rounded-full border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 transition hover:border-slate-300 hover:bg-slate-50">
                                            Modifier
                                        </Link>
                                        <button type="button" class="rounded-full border border-red-200 px-4 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50" @click="deletePayment(payment.id)">
                                            Supprimer
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="px-6 pb-6">
                    <PaginationLinks :links="payments.links" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
