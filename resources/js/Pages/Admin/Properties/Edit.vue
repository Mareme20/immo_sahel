<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PropertyForm from '@/Pages/Admin/Properties/Partials/PropertyForm.vue';

const props = defineProps({
    property: Object,
    categories: Array,
    contacts: Array,
});

const form = useForm({
    _method: 'PUT',
    title: props.property.title ?? '',
    category_id: props.property.category_id ?? '',
    owner_contact_id: props.property.owner_contact_id ?? '',
    tenant_contact_id: props.property.tenant_contact_id ?? '',
    description: props.property.description ?? '',
    price: props.property.price ?? '',
    location: props.property.location ?? '',
    address_line: props.property.address_line ?? '',
    city: props.property.city ?? '',
    district: props.property.district ?? '',
    latitude: props.property.latitude ?? '',
    longitude: props.property.longitude ?? '',
    type: props.property.type ?? 'sale',
    status: props.property.status ?? 'available',
    area: props.property.area ?? '',
    rooms: props.property.rooms ?? '',
    bathrooms: props.property.bathrooms ?? '',
    parking_spaces: props.property.parking_spaces ?? '',
    featured: props.property.featured ?? false,
    is_published: props.property.is_published ?? true,
    seo_title: props.property.seo_title ?? '',
    seo_description: props.property.seo_description ?? '',
    images: [],
});

const submit = () => {
    form.post(route('admin.properties.update', props.property.id), {
        forceFormData: true,
    });
};
</script>

<template>
    <Head title="Modifier un bien" />

    <AuthenticatedLayout>
        <template #header>
            <div class="admin-shell py-6">
                <div class="admin-card overflow-hidden bg-gradient-to-r from-slate-900 to-slate-800 p-8 text-white">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-white/60">Edition</p>
                    <h1 class="mt-3 font-display text-3xl">{{ property.title }}</h1>
                    <p class="mt-3 max-w-2xl text-sm text-white/70">
                        Mets a jour la fiche publique, la galerie, les contacts relies et les champs SEO sans sortir du back-office.
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
                :existing-images="property.images"
                :property-id="property.id"
                submit-label="Mettre a jour le bien"
                @submit="submit"
            />
        </div>
    </AuthenticatedLayout>
</template>
