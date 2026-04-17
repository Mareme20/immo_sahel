<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import MaintenanceRequestForm from '@/Pages/Admin/MaintenanceRequests/Partials/MaintenanceRequestForm.vue';

const props = defineProps({
    properties: Array,
    contacts: Array,
});

const form = useForm({
    property_id: '',
    contact_id: '',
    title: '',
    description: '',
    priority: 'medium',
    status: 'open',
    estimated_cost: '',
    reported_at: '',
    resolved_at: '',
});

const submit = () => {
    form.post(route('admin.maintenance-requests.store'));
};
</script>

<template>
    <Head title="Ajouter une intervention" />

    <AuthenticatedLayout>
        <template #header>
            <div class="admin-shell py-6">
                <div class="admin-card overflow-hidden bg-gradient-to-r from-slate-900 to-slate-800 p-8 text-white">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-white/60">Nouvelle intervention</p>
                    <h1 class="mt-3 font-display text-3xl">Ajouter une demande de maintenance</h1>
                    <p class="mt-3 max-w-2xl text-sm text-white/70">
                        Renseigne le contexte, la priorite et le bien rattache pour alimenter le suivi technique.
                    </p>
                </div>
            </div>
        </template>

        <div class="admin-shell py-8">
            <div class="mb-4">
                <Link :href="route('admin.maintenance-requests.index')" class="text-sm font-medium text-slate-500 transition hover:text-slate-800">
                    Retour a la maintenance
                </Link>
            </div>

            <div class="admin-card p-6 sm:p-8">
                <MaintenanceRequestForm
                    :form="form"
                    :properties="properties"
                    :contacts="contacts"
                    submit-label="Enregistrer la demande"
                    @submit="submit"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
