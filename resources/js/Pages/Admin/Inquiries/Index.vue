<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PaginationLinks from '@/Components/PaginationLinks.vue';
import { Head, Link, router } from '@inertiajs/vue3';

defineProps({
    inquiries: Object,
    stats: Object,
});

const statusOptions = [
    { value: 'new', label: 'Nouvelle' },
    { value: 'qualified', label: 'Qualifiee' },
    { value: 'visit_planned', label: 'Visite planifiee' },
    { value: 'converted', label: 'Convertie' },
    { value: 'archived', label: 'Archivee' },
];

const updateStatus = (inquiryId, status) => {
    router.patch(
        route('admin.inquiries.update', inquiryId),
        { status },
        {
            preserveScroll: true,
        },
    );
};

const deleteInquiry = (inquiryId) => {
    if (confirm('Supprimer cette demande ?')) {
        router.delete(route('admin.inquiries.destroy', inquiryId));
    }
};

const formatCurrency = (amount) =>
    amount
        ? new Intl.NumberFormat('fr-FR', {
              style: 'currency',
              currency: 'XOF',
              maximumFractionDigits: 0,
          }).format(amount)
        : 'Non precise';

const formatDate = (value) =>
    value ? new Date(value).toLocaleDateString('fr-FR') : 'Aucune date';
</script>

<template>
    <Head title="Demandes - Administration" />

    <AuthenticatedLayout>
        <template #header>
            <div class="admin-shell py-6">
                <div class="grid gap-4 lg:grid-cols-[1.3fr_0.7fr]">
                    <div class="admin-card overflow-hidden bg-gradient-to-br from-slate-900 to-slate-800 p-8 text-white">
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-white/60">Leads</p>
                        <h1 class="mt-3 font-display text-3xl">Demandes de visite et opportunites</h1>
                        <p class="mt-3 max-w-2xl text-sm leading-6 text-white/70">
                            Les formulaires publics arrivent ici pour qualifer, planifier une visite et suivre les conversions.
                        </p>
                    </div>

                    <div class="admin-card p-6">
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-400">Vue pipeline</p>
                        <h2 class="mt-3 text-xl font-semibold text-slate-900">Priorites du moment</h2>
                        <p class="mt-2 text-sm text-slate-500">
                            Passe rapidement d'une demande brute a une visite programmee puis a une opportunite gagnee.
                        </p>
                        <Link :href="route('properties.index')" class="admin-button-secondary mt-5">
                            Voir le catalogue public
                        </Link>
                    </div>
                </div>
            </div>
        </template>

        <div class="admin-shell py-8">
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">
                <div class="admin-card p-5">
                    <div class="text-sm text-slate-500">Total</div>
                    <div class="mt-2 text-3xl font-semibold text-slate-900">{{ stats.total }}</div>
                </div>
                <div class="admin-card p-5">
                    <div class="text-sm text-slate-500">Nouvelles</div>
                    <div class="mt-2 text-3xl font-semibold text-slate-900">{{ stats.new }}</div>
                </div>
                <div class="admin-card p-5">
                    <div class="text-sm text-slate-500">Qualifiees</div>
                    <div class="mt-2 text-3xl font-semibold text-slate-900">{{ stats.qualified }}</div>
                </div>
                <div class="admin-card p-5">
                    <div class="text-sm text-slate-500">Visites</div>
                    <div class="mt-2 text-3xl font-semibold text-slate-900">{{ stats.visits }}</div>
                </div>
                <div class="admin-card p-5">
                    <div class="text-sm text-slate-500">Converties</div>
                    <div class="mt-2 text-3xl font-semibold text-slate-900">{{ stats.converted }}</div>
                </div>
            </div>

            <div class="admin-card mt-6 overflow-hidden">
                <div class="flex flex-col gap-3 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Pipeline</p>
                        <h2 class="mt-2 text-xl font-semibold text-slate-900">Demandes recues depuis le site</h2>
                    </div>
                    <div class="text-sm text-slate-500">
                        {{ inquiries.total }} lead{{ inquiries.total > 1 ? 's' : '' }}
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Contact</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Bien</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Projet</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Statut</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            <tr v-for="inquiry in inquiries.data" :key="inquiry.id">
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-900">{{ inquiry.name }}</div>
                                    <div class="mt-1 text-sm text-slate-500">{{ inquiry.phone }}</div>
                                    <div class="text-sm text-slate-500">{{ inquiry.email || 'Email non renseigne' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-900">{{ inquiry.property?.title || 'Bien indisponible' }}</div>
                                    <div class="mt-1 text-sm text-slate-500">{{ inquiry.property?.location || '-' }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    <div>Visite souhaitee: {{ formatDate(inquiry.preferred_visit_date) }}</div>
                                    <div>Budget: {{ formatCurrency(inquiry.budget) }}</div>
                                    <div class="mt-2 max-w-sm text-slate-500">
                                        {{ inquiry.message || 'Aucun message complementaire.' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <select class="admin-input max-w-[220px]" :value="inquiry.status" @change="updateStatus(inquiry.id, $event.target.value)">
                                        <option v-for="option in statusOptions" :key="option.value" :value="option.value">
                                            {{ option.label }}
                                        </option>
                                    </select>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-end gap-3">
                                        <a
                                            v-if="inquiry.phone"
                                            :href="`https://wa.me/${inquiry.phone.replace(/[^0-9]/g, '')}`"
                                            target="_blank"
                                            class="rounded-full border border-emerald-200 px-4 py-2 text-sm font-medium text-emerald-700 transition hover:bg-emerald-50"
                                        >
                                            WhatsApp
                                        </a>
                                        <button type="button" class="rounded-full border border-red-200 px-4 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50" @click="deleteInquiry(inquiry.id)">
                                            Supprimer
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="px-6 pb-6">
                    <PaginationLinks :links="inquiries.links" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
