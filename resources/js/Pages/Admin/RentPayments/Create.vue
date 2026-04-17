<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import RentPaymentForm from '@/Pages/Admin/RentPayments/Partials/RentPaymentForm.vue';

const props = defineProps({
    properties: Array,
    tenants: Array,
});

const form = useForm({
    property_id: '',
    tenant_contact_id: '',
    amount: '',
    due_date: '',
    paid_date: '',
    status: 'pending',
    period_label: '',
    reference: '',
    notes: '',
});

const submit = () => {
    form.post(route('admin.rent-payments.store'));
};
</script>

<template>
    <Head title="Ajouter un paiement" />

    <AuthenticatedLayout>
        <template #header>
            <div class="admin-shell py-6">
                <div class="admin-card overflow-hidden bg-gradient-to-r from-slate-900 to-slate-800 p-8 text-white">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-white/60">Nouvelle echeance</p>
                    <h1 class="mt-3 font-display text-3xl">Ajouter un suivi de loyer</h1>
                    <p class="mt-3 max-w-2xl text-sm text-white/70">
                        Renseigne le bien, le locataire et l'etat du paiement pour enrichir la vue finance.
                    </p>
                </div>
            </div>
        </template>

        <div class="admin-shell py-8">
            <div class="mb-4">
                <Link :href="route('admin.rent-payments.index')" class="text-sm font-medium text-slate-500 transition hover:text-slate-800">
                    Retour au suivi des loyers
                </Link>
            </div>

            <div class="admin-card p-6 sm:p-8">
                <RentPaymentForm
                    :form="form"
                    :properties="properties"
                    :tenants="tenants"
                    submit-label="Enregistrer le paiement"
                    @submit="submit"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
