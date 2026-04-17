<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import RentPaymentForm from '@/Pages/Admin/RentPayments/Partials/RentPaymentForm.vue';

const props = defineProps({
    payment: Object,
    properties: Array,
    tenants: Array,
});

const formatDate = (value) => (value ? value.slice(0, 10) : '');

const form = useForm({
    property_id: props.payment.property_id ?? '',
    tenant_contact_id: props.payment.tenant_contact_id ?? '',
    amount: props.payment.amount ?? '',
    due_date: formatDate(props.payment.due_date),
    paid_date: formatDate(props.payment.paid_date),
    status: props.payment.status ?? 'pending',
    period_label: props.payment.period_label ?? '',
    reference: props.payment.reference ?? '',
    notes: props.payment.notes ?? '',
});

const submit = () => {
    form.put(route('admin.rent-payments.update', props.payment.id));
};
</script>

<template>
    <Head title="Modifier un paiement" />

    <AuthenticatedLayout>
        <template #header>
            <div class="admin-shell py-6">
                <div class="admin-card overflow-hidden bg-gradient-to-r from-slate-900 to-slate-800 p-8 text-white">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-white/60">Edition echeance</p>
                    <h1 class="mt-3 font-display text-3xl">{{ payment.period_label || `Paiement #${payment.id}` }}</h1>
                    <p class="mt-3 max-w-2xl text-sm text-white/70">
                        Ajuste le statut, les dates et le rattachement pour garder un suivi financier fiable.
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
                    submit-label="Mettre a jour le paiement"
                    @submit="submit"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
