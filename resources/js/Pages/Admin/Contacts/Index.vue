<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PaginationLinks from '@/Components/PaginationLinks.vue';
import { Head, Link, router } from '@inertiajs/vue3';

defineProps({
    contacts: Object,
    stats: Object,
});

const deleteContact = (contactId) => {
    if (confirm('Supprimer ce contact ?')) {
        router.delete(route('admin.contacts.destroy', contactId));
    }
};

const typeLabel = {
    owner: 'Proprietaire',
    tenant: 'Locataire',
    prospect: 'Prospect',
    buyer: 'Acheteur',
    vendor: 'Vendeur',
    other: 'Autre',
};

const channelLabel = {
    phone: 'Telephone',
    whatsapp: 'WhatsApp',
    email: 'Email',
};
</script>

<template>
    <Head title="Contacts - Administration" />

    <AuthenticatedLayout>
        <template #header>
            <div class="admin-shell py-6">
                <div class="grid gap-4 lg:grid-cols-[1.3fr_0.7fr]">
                    <div class="admin-card overflow-hidden bg-gradient-to-br from-slate-900 to-slate-800 p-8 text-white">
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-white/60">Relation client</p>
                        <h1 class="mt-3 font-display text-3xl">Carnet de contacts immobilier</h1>
                        <p class="mt-3 max-w-2xl text-sm leading-6 text-white/70">
                            Centralise proprietaires, locataires et prospects pour mieux connecter les biens, les leads et le suivi commercial.
                        </p>
                    </div>

                    <div class="admin-card p-6">
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-400">Actions</p>
                        <h2 class="mt-3 text-xl font-semibold text-slate-900">Nouveau contact</h2>
                        <p class="mt-2 text-sm text-slate-500">
                            Cree une fiche reutilisable dans les biens, les demandes et les suivis.
                        </p>
                        <Link :href="route('admin.contacts.create')" class="admin-button-primary mt-5">
                            Ajouter un contact
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
                    <div class="text-sm text-slate-500">Proprietaires</div>
                    <div class="mt-2 text-3xl font-semibold text-slate-900">{{ stats.owners }}</div>
                </div>
                <div class="admin-card p-5">
                    <div class="text-sm text-slate-500">Locataires</div>
                    <div class="mt-2 text-3xl font-semibold text-slate-900">{{ stats.tenants }}</div>
                </div>
                <div class="admin-card p-5">
                    <div class="text-sm text-slate-500">Prospects</div>
                    <div class="mt-2 text-3xl font-semibold text-slate-900">{{ stats.prospects }}</div>
                </div>
                <div class="admin-card p-5">
                    <div class="text-sm text-slate-500">Inactifs</div>
                    <div class="mt-2 text-3xl font-semibold text-slate-900">{{ stats.inactive }}</div>
                </div>
            </div>

            <div class="admin-card mt-6 overflow-hidden">
                <div class="flex flex-col gap-3 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Base CRM</p>
                        <h2 class="mt-2 text-xl font-semibold text-slate-900">Contacts relies au portefeuille</h2>
                    </div>
                    <div class="text-sm text-slate-500">
                        {{ contacts.total }} fiche{{ contacts.total > 1 ? 's' : '' }}
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Contact</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Type</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Canal</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Liens</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            <tr v-for="contact in contacts.data" :key="contact.id">
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-900">{{ contact.name }}</div>
                                    <div class="mt-1 text-sm text-slate-500">
                                        {{ contact.phone || 'Telephone non renseigne' }}
                                    </div>
                                    <div class="text-sm text-slate-500">{{ contact.email || 'Email non renseigne' }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ typeLabel[contact.type] || contact.type }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ channelLabel[contact.preferred_channel] || contact.preferred_channel }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    <div>{{ contact.owned_properties_count }} bien(s) proprietaire</div>
                                    <div>{{ contact.tenancy_properties_count }} bien(s) occupant</div>
                                    <div>{{ contact.inquiries_count }} demande(s)</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-end gap-3">
                                        <Link :href="route('admin.contacts.edit', contact.id)" class="rounded-full border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 transition hover:border-slate-300 hover:bg-slate-50">
                                            Modifier
                                        </Link>
                                        <button type="button" class="rounded-full border border-red-200 px-4 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50" @click="deleteContact(contact.id)">
                                            Supprimer
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="px-6 pb-6">
                    <PaginationLinks :links="contacts.links" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
