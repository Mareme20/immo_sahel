<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ContactForm from '@/Pages/Admin/Contacts/Partials/ContactForm.vue';

const form = useForm({
    name: '',
    email: '',
    phone: '',
    company: '',
    type: 'prospect',
    preferred_channel: 'phone',
    notes: '',
    is_active: true,
});

const submit = () => {
    form.post(route('admin.contacts.store'));
};
</script>

<template>
    <Head title="Ajouter un contact" />

    <AuthenticatedLayout>
        <template #header>
            <div class="admin-shell py-6">
                <div class="admin-card overflow-hidden bg-gradient-to-r from-slate-900 to-slate-800 p-8 text-white">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-white/60">Nouveau contact</p>
                    <h1 class="mt-3 font-display text-3xl">Ajouter une fiche relation</h1>
                    <p class="mt-3 max-w-2xl text-sm text-white/70">
                        La fiche pourra ensuite etre reliee aux biens, demandes de visite, loyers et maintenance.
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
                <ContactForm :form="form" submit-label="Enregistrer le contact" @submit="submit" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
