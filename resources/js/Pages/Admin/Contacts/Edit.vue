<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ContactForm from '@/Pages/Admin/Contacts/Partials/ContactForm.vue';

const props = defineProps({
    contact: Object,
});

const form = useForm({
    name: props.contact.name ?? '',
    email: props.contact.email ?? '',
    phone: props.contact.phone ?? '',
    company: props.contact.company ?? '',
    type: props.contact.type ?? 'prospect',
    preferred_channel: props.contact.preferred_channel ?? 'phone',
    notes: props.contact.notes ?? '',
    is_active: props.contact.is_active ?? true,
});

const submit = () => {
    form.put(route('admin.contacts.update', props.contact.id));
};
</script>

<template>
    <Head title="Modifier un contact" />

    <AuthenticatedLayout>
        <template #header>
            <div class="admin-shell py-6">
                <div class="admin-card overflow-hidden bg-gradient-to-r from-slate-900 to-slate-800 p-8 text-white">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-white/60">Edition contact</p>
                    <h1 class="mt-3 font-display text-3xl">{{ contact.name }}</h1>
                    <p class="mt-3 max-w-2xl text-sm text-white/70">
                        Mets a jour les informations de reference et garde la fiche synchronisee avec le portefeuille.
                    </p>
                </div>
            </div>
        </template>

        <div class="admin-shell py-8">
            <div class="mb-4">
                <Link :href="route('admin.contacts.index')" class="text-sm font-medium text-slate-500 transition hover:text-slate-800">
                    Retour aux contacts
                </Link>
            </div>

            <div class="admin-card p-6 sm:p-8">
                <ContactForm :form="form" submit-label="Mettre a jour le contact" @submit="submit" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
