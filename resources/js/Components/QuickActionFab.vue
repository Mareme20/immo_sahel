<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import AdminIcon from '@/Components/AdminIcon.vue';

const open = ref(false);

const actions = [
    {
        label: 'Ajouter un bien',
        hint: 'Créer une nouvelle fiche',
        href: route('admin.properties.create'),
    },
    {
        label: 'Nouveau contact',
        hint: 'Alimenter le CRM',
        href: route('admin.contacts.create'),
    },
    {
        label: 'Nouveau loyer',
        hint: 'Ajouter une échéance',
        href: route('admin.rent-payments.create'),
    },
    {
        label: 'Nouvelle maintenance',
        hint: 'Ouvrir un dossier',
        href: route('admin.maintenance-requests.create'),
    },
    {
        label: 'Demandes reçues',
        hint: 'Suivre les leads',
        href: route('admin.inquiries.index'),
    },
];
</script>

<template>
    <div class="admin-floating-action">
        <div v-if="open" class="admin-fab-menu mb-3 p-2">
            <div class="d-grid gap-2">
                <Link
                    v-for="action in actions"
                    :key="action.label"
                    :href="action.href"
                    class="admin-fab-link"
                >
                    <div>
                        <div class="fw-semibold">{{ action.label }}</div>
                        <div class="small text-secondary mt-1">{{ action.hint }}</div>
                    </div>
                    <AdminIcon name="plus" class="text-secondary" style="width: 1rem; height: 1rem;" />
                </Link>
            </div>
        </div>

        <button type="button" class="admin-fab-button d-inline-flex align-items-center justify-content-center" @click="open = !open">
            <AdminIcon name="plus" style="width: 1.6rem; height: 1.6rem;" />
        </button>
    </div>
</template>
