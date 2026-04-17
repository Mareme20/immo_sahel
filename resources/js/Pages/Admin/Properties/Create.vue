<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PropertyForm from '@/Pages/Admin/Properties/Partials/PropertyForm.vue';

const props = defineProps({
    categories: Array,
    contacts: Array,
});

const form = useForm({
    title: '',
    category_id: '',
    owner_contact_id: '',
    tenant_contact_id: '',
    description: '',
    price: '',
    location: '',
    address_line: '',
    city: '',
    district: '',
    latitude: '',
    longitude: '',
    type: 'sale',
    status: 'available',
    area: '',
    rooms: '',
    bathrooms: '',
    parking_spaces: '',
    featured: false,
    is_published: true,
    seo_title: '',
    seo_description: '',
    images: [],
});

const submit = () => {
    form.post(route('admin.properties.store'), {
        forceFormData: true,
    });
};
</script>

<template>
    <Head title="Ajouter un bien" />

    <AuthenticatedLayout>
        <template #header>
            <div class="admin-shell py-6">
                <div class="admin-card overflow-hidden bg-gradient-to-r from-slate-900 to-slate-800 p-8 text-white">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-white/60">Nouveau bien</p>
                    <h1 class="mt-3 font-display text-3xl">Creer une fiche complete</h1>
                    <p class="mt-3 max-w-2xl text-sm text-white/70">
                        On ajoute en une fois la vitrine publique, les rattachements CRM et les champs de pilotage interne.
                    </p>
                </div>
            </div>
        </template>

        <div class="admin-shell py-8">
            <div class="mb-4">
                <Link :href="route('admin.properties.index')" class="text-sm font-medium text-slate-500 transition hover:text-slate-800">
                    Retour au portefeuille
                </Link>
            </div>

            <PropertyForm
                :form="form"
                :categories="categories"
                :contacts="contacts"
                submit-label="Enregistrer le bien"
                @submit="submit"
            />
        </div>
    </AuthenticatedLayout>
</template>
