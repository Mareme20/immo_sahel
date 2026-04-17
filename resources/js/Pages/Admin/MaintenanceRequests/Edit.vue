<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import MaintenanceRequestForm from '@/Pages/Admin/MaintenanceRequests/Partials/MaintenanceRequestForm.vue';

const props = defineProps({
    maintenanceRequest: Object,
    properties: Array,
    contacts: Array,
});

const formatDate = (value) => (value ? value.slice(0, 10) : '');

const form = useForm({
    property_id: props.maintenanceRequest.property_id ?? '',
    contact_id: props.maintenanceRequest.contact_id ?? '',
    title: props.maintenanceRequest.title ?? '',
    description: props.maintenanceRequest.description ?? '',
    priority: props.maintenanceRequest.priority ?? 'medium',
    status: props.maintenanceRequest.status ?? 'open',
    estimated_cost: props.maintenanceRequest.estimated_cost ?? '',
    reported_at: formatDate(props.maintenanceRequest.reported_at),
    resolved_at: formatDate(props.maintenanceRequest.resolved_at),
});

const submit = () => {
    form.put(route('admin.maintenance-requests.update', props.maintenanceRequest.id));
};
</script>

<template>
    <Head title="Modifier une intervention" />

    <AuthenticatedLayout>
        <template #header>
            <div class="admin-shell py-6">
                <div class="admin-card overflow-hidden bg-gradient-to-r from-slate-900 to-slate-800 p-8 text-white">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-white/60">Edition maintenance</p>
                    <h1 class="mt-3 font-display text-3xl">{{ maintenanceRequest.title }}</h1>
                    <p class="mt-3 max-w-2xl text-sm text-white/70">
                        Mets a jour la progression du dossier, les couts et la resolution.
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
                    submit-label="Mettre a jour l'intervention"
                    @submit="submit"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
