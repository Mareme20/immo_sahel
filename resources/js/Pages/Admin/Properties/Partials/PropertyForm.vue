<script setup>
import { computed } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import FileDropzone from '@/Components/FileDropzone.vue';
import InputError from '@/Components/InputError.vue';

defineEmits(['submit']);

const props = defineProps({
    form: {
        type: Object,
        required: true,
    },
    categories: {
        type: Array,
        default: () => [],
    },
    contacts: {
        type: Array,
        default: () => [],
    },
    submitLabel: {
        type: String,
        required: true,
    },
    existingImages: {
        type: Array,
        default: () => [],
    },
    propertyId: {
        type: Number,
        default: null,
    },
});

const statusOptions = [
    { value: 'available', label: 'Libre' },
    { value: 'rented', label: 'Loue' },
    { value: 'maintenance', label: 'En travaux' },
];

const typeOptions = [
    { value: 'sale', label: 'Vente' },
    { value: 'rent', label: 'Location' },
];

const ownerContacts = computed(() =>
    props.contacts.filter((contact) => ['owner', 'vendor', 'other'].includes(contact.type)),
);

const tenantContacts = computed(() =>
    props.contacts.filter((contact) => ['tenant', 'buyer', 'prospect', 'other'].includes(contact.type)),
);

const sortedExistingImages = computed(() =>
    [...props.existingImages].sort((a, b) => (a.sort_order ?? 0) - (b.sort_order ?? 0)),
);

const setMainImage = (imageId) => {
    if (!props.propertyId) return;

    router.patch(route('admin.properties.images.main', [props.propertyId, imageId]), {}, { preserveScroll: true });
};

const deleteImage = (imageId) => {
    if (!props.propertyId || !confirm('Supprimer cette image ?')) return;

    router.delete(route('admin.properties.images.destroy', [props.propertyId, imageId]), { preserveScroll: true });
};

const moveImage = (imageId, direction) => {
    if (!props.propertyId) return;

    const order = sortedExistingImages.value.map((image) => image.id);
    const index = order.indexOf(imageId);
    const targetIndex = direction === 'up' ? index - 1 : index + 1;

    if (index < 0 || targetIndex < 0 || targetIndex >= order.length) {
        return;
    }

    [order[index], order[targetIndex]] = [order[targetIndex], order[index]];

    router.patch(
        route('admin.properties.images.reorder', props.propertyId),
        { order },
        { preserveScroll: true },
    );
};
</script>

<template>
    <form @submit.prevent="$emit('submit')" class="space-y-6">
        <div class="grid gap-6 xl:grid-cols-[1.25fr_0.75fr]">
            <section class="admin-card p-6 sm:p-8">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Identite du bien</p>
                        <h2 class="mt-2 text-2xl font-semibold text-slate-900">Informations commerciales</h2>
                    </div>
                </div>

                <div class="mt-6 grid gap-6 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-slate-700">Titre</label>
                        <input v-model="form.title" type="text" class="admin-input" />
                        <InputError class="mt-2" :message="form.errors.title" />
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Categorie</label>
                        <select v-model="form.category_id" class="admin-input">
                            <option value="">Choisir</option>
                            <option v-for="category in categories" :key="category.id" :value="category.id">
                                {{ category.name }}
                            </option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.category_id" />
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Type</label>
                        <select v-model="form.type" class="admin-input">
                            <option v-for="option in typeOptions" :key="option.value" :value="option.value">
                                {{ option.label }}
                            </option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.type" />
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-slate-700">Description</label>
                        <textarea v-model="form.description" rows="6" class="admin-input"></textarea>
                        <InputError class="mt-2" :message="form.errors.description" />
                    </div>
                </div>
            </section>

            <div class="space-y-6">
                <section class="admin-card p-6 sm:p-8">
                    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Diffusion</p>
                    <h2 class="mt-2 text-xl font-semibold text-slate-900">Visibilite et mise en avant</h2>

                    <div class="mt-6 space-y-4">
                        <label class="flex items-start gap-3 rounded-3xl border border-slate-200 bg-slate-50 px-5 py-4">
                            <input v-model="form.featured" type="checkbox" class="mt-1 rounded border-slate-300 text-emerald-600" />
                            <div>
                                <div class="text-sm font-semibold text-slate-900">Mettre en avant</div>
                                <div class="mt-1 text-sm text-slate-500">Le bien remonte dans les selections premium.</div>
                            </div>
                        </label>

                        <label class="flex items-start gap-3 rounded-3xl border border-slate-200 bg-slate-50 px-5 py-4">
                            <input v-model="form.is_published" type="checkbox" class="mt-1 rounded border-slate-300 text-emerald-600" />
                            <div>
                                <div class="text-sm font-semibold text-slate-900">Publier sur le site public</div>
                                <div class="mt-1 text-sm text-slate-500">Decoche pour garder le bien en brouillon interne.</div>
                            </div>
                        </label>
                    </div>
                </section>

                <section class="admin-card p-6 sm:p-8">
                    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Contacts relies</p>
                    <h2 class="mt-2 text-xl font-semibold text-slate-900">Proprietaire et occupant</h2>

                    <div class="mt-6 space-y-5">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">Proprietaire</label>
                            <select v-model="form.owner_contact_id" class="admin-input">
                                <option value="">Aucun</option>
                                <option v-for="contact in ownerContacts" :key="contact.id" :value="contact.id">
                                    {{ contact.name }}{{ contact.phone ? ` - ${contact.phone}` : '' }}
                                </option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.owner_contact_id" />
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">Locataire / occupant</label>
                            <select v-model="form.tenant_contact_id" class="admin-input">
                                <option value="">Aucun</option>
                                <option v-for="contact in tenantContacts" :key="contact.id" :value="contact.id">
                                    {{ contact.name }}{{ contact.phone ? ` - ${contact.phone}` : '' }}
                                </option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.tenant_contact_id" />
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            <section class="admin-card p-6 sm:p-8">
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Tarification et caracteristiques</p>
                <h2 class="mt-2 text-2xl font-semibold text-slate-900">Donnees du bien</h2>

                <div class="mt-6 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Statut</label>
                        <select v-model="form.status" class="admin-input">
                            <option v-for="option in statusOptions" :key="option.value" :value="option.value">
                                {{ option.label }}
                            </option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.status" />
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Prix / loyer</label>
                        <input v-model="form.price" type="number" min="0" class="admin-input" />
                        <InputError class="mt-2" :message="form.errors.price" />
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Surface</label>
                        <input v-model="form.area" type="number" min="0" class="admin-input" />
                        <InputError class="mt-2" :message="form.errors.area" />
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Chambres / pieces</label>
                        <input v-model="form.rooms" type="number" min="0" class="admin-input" />
                        <InputError class="mt-2" :message="form.errors.rooms" />
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Salles d'eau</label>
                        <input v-model="form.bathrooms" type="number" min="0" class="admin-input" />
                        <InputError class="mt-2" :message="form.errors.bathrooms" />
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Places de parking</label>
                        <input v-model="form.parking_spaces" type="number" min="0" class="admin-input" />
                        <InputError class="mt-2" :message="form.errors.parking_spaces" />
                    </div>
                </div>
            </section>

            <section class="admin-card p-6 sm:p-8">
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Localisation</p>
                <h2 class="mt-2 text-2xl font-semibold text-slate-900">Adresse et precision geographique</h2>

                <div class="mt-6 grid gap-6 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-slate-700">Libelle public de localisation</label>
                        <input v-model="form.location" type="text" class="admin-input" placeholder="Ex: Almadies, Dakar" />
                        <InputError class="mt-2" :message="form.errors.location" />
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-slate-700">Adresse</label>
                        <input v-model="form.address_line" type="text" class="admin-input" />
                        <InputError class="mt-2" :message="form.errors.address_line" />
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Ville</label>
                        <input v-model="form.city" type="text" class="admin-input" />
                        <InputError class="mt-2" :message="form.errors.city" />
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Quartier</label>
                        <input v-model="form.district" type="text" class="admin-input" />
                        <InputError class="mt-2" :message="form.errors.district" />
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Latitude</label>
                        <input v-model="form.latitude" type="number" step="0.0000001" class="admin-input" />
                        <InputError class="mt-2" :message="form.errors.latitude" />
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Longitude</label>
                        <input v-model="form.longitude" type="number" step="0.0000001" class="admin-input" />
                        <InputError class="mt-2" :message="form.errors.longitude" />
                    </div>
                </div>
            </section>
        </div>

        <section class="admin-card p-6 sm:p-8">
            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">SEO et partage</p>
            <h2 class="mt-2 text-2xl font-semibold text-slate-900">Optimisation de la fiche</h2>

            <div class="mt-6 grid gap-6 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Titre SEO</label>
                    <input v-model="form.seo_title" type="text" class="admin-input" />
                    <InputError class="mt-2" :message="form.errors.seo_title" />
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Description SEO</label>
                    <textarea v-model="form.seo_description" rows="4" class="admin-input"></textarea>
                    <InputError class="mt-2" :message="form.errors.seo_description" />
                </div>
            </div>
        </section>

        <section class="admin-card p-6 sm:p-8">
            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Galerie</p>
            <h2 class="mt-2 text-2xl font-semibold text-slate-900">Photos et ordre d'affichage</h2>

            <div class="mt-6">
                <FileDropzone
                    v-model="form.images"
                    :existing-images="existingImages"
                    label="Ajoutez de nouvelles photos"
                    helper="Glissez-deposez vos images ou cliquez pour en selectionner plusieurs."
                />
                <InputError class="mt-2" :message="form.errors.images" />
                <InputError class="mt-2" :message="form.errors['images.0']" />
            </div>

            <div v-if="sortedExistingImages.length" class="mt-8">
                <div class="mb-4 flex items-center justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">Images existantes</h3>
                        <p class="text-sm text-slate-500">Definis l'image principale, ajuste l'ordre ou supprime une photo.</p>
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                    <article v-for="image in sortedExistingImages" :key="image.id" class="overflow-hidden rounded-[1.5rem] border border-slate-200 bg-white">
                        <img :src="`/storage/${image.image_path}`" alt="" class="h-44 w-full object-cover" />
                        <div class="space-y-3 p-4">
                            <div class="flex items-center justify-between gap-3">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold" :class="image.is_main ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600'">
                                    {{ image.is_main ? 'Principale' : `Ordre ${image.sort_order + 1}` }}
                                </span>
                            </div>

                            <div class="grid grid-cols-2 gap-2">
                                <button type="button" class="rounded-full border border-slate-200 px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50" @click="moveImage(image.id, 'up')">
                                    Monter
                                </button>
                                <button type="button" class="rounded-full border border-slate-200 px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50" @click="moveImage(image.id, 'down')">
                                    Descendre
                                </button>
                            </div>

                            <button
                                v-if="!image.is_main"
                                type="button"
                                class="w-full rounded-full border border-emerald-200 px-4 py-2 text-sm font-medium text-emerald-700 transition hover:bg-emerald-50"
                                @click="setMainImage(image.id)"
                            >
                                Definir comme principale
                            </button>

                            <button type="button" class="w-full rounded-full border border-red-200 px-4 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50" @click="deleteImage(image.id)">
                                Supprimer
                            </button>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <div class="flex flex-col gap-3 sm:flex-row sm:justify-between">
            <Link :href="route('admin.properties.index')" class="admin-button-secondary">
                Retour a la liste
            </Link>

            <button type="submit" class="admin-button-primary" :disabled="form.processing">
                {{ submitLabel }}
            </button>
        </div>
    </form>
</template>
