<script setup>
import PublicFooter from '@/Components/PublicFooter.vue';
import PropertyMap from '@/Components/PropertyMap.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    property: Object,
    related_properties: {
        type: Array,
        default: () => [],
    },
});

const activeImage = ref(0);
const shareNotice = ref('');
const phoneNumber = '+221769499638';

const form = useForm({
    name: '',
    email: '',
    phone: '',
    preferred_contact: 'whatsapp',
    preferred_visit_date: '',
    budget: props.property.price ?? '',
    message: '',
});

const images = computed(() => {
    if (props.property.images?.length) {
        return props.property.images;
    }

    return props.property.main_image ? [props.property.main_image] : [];
});

const currentImageUrl = computed(() => {
    if (!images.value.length || !images.value[activeImage.value]) {
        return null;
    }

    return `/storage/${images.value[activeImage.value].image_path}`;
});

const metaDescription = computed(() => {
    if (props.property.seo_description) {
        return props.property.seo_description;
    }

    return (props.property.description || '').slice(0, 160);
});

const pageTitle = computed(() => props.property.seo_title || `${props.property.title} - Agence Immo Sahel`);

const propertyStats = computed(() => [
    { label: 'Surface', value: props.property.area ? `${props.property.area} m²` : 'Non precise' },
    { label: 'Chambres', value: props.property.rooms || 'Non precise' },
    { label: 'Salles d eau', value: props.property.bathrooms || 'Non precise' },
    { label: 'Parking', value: props.property.parking_spaces || 'Non precise' },
    { label: 'Ville', value: props.property.city || 'Non precise' },
    { label: 'Quartier', value: props.property.district || 'Non precise' },
]);

const formatPrice = (price) =>
    new Intl.NumberFormat('fr-FR', {
        style: 'currency',
        currency: 'XOF',
        maximumFractionDigits: 0,
    }).format(price ?? 0);

const relatedImage = (property) =>
    property?.main_image?.image_path ? `/storage/${property.main_image.image_path}` : null;

const whatsappUrl = computed(() => {
    const message = encodeURIComponent(
        `Bonjour, je suis interesse par le bien "${props.property.title}".`,
    );

    return `https://wa.me/${phoneNumber.replace('+', '')}?text=${message}`;
});

const submitInquiry = () => {
    form.post(route('properties.inquiries.store', props.property.slug), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            form.preferred_contact = 'whatsapp';
        },
    });
};

const shareListing = async () => {
    const url = window.location.href;

    try {
        if (navigator.share) {
            await navigator.share({
                title: pageTitle.value,
                text: metaDescription.value,
                url,
            });

            shareNotice.value = 'Annonce partagee.';
            return;
        }

        await navigator.clipboard.writeText(url);
        shareNotice.value = 'Lien copie dans le presse-papiers.';
    } catch (error) {
        shareNotice.value = 'Le partage a ete annule ou indisponible.';
    }

    window.setTimeout(() => {
        shareNotice.value = '';
    }, 2500);
};
</script>

<template>
    <Head :title="pageTitle">
        <meta head-key="description" name="description" :content="metaDescription" />
        <meta head-key="og:title" property="og:title" :content="pageTitle" />
        <meta head-key="og:description" property="og:description" :content="metaDescription" />
    </Head>

    <div class="min-h-screen bg-white">
        <header class="sticky top-0 z-50 border-b border-slate-200 bg-white/95 backdrop-blur">
            <nav class="sahel-shell flex h-20 items-center justify-between gap-4">
                <Link href="/" class="flex items-center gap-3">
                    <div class="rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold tracking-[0.2em] text-white">AIS</div>
                    <div>
                        <div class="font-display text-lg font-semibold text-slate-950">Agence Immo Sahel</div>
                        <div class="text-xs uppercase tracking-[0.25em] text-slate-400">Fiche detaillee</div>
                    </div>
                </Link>

                <div class="hidden items-center gap-8 text-sm font-medium text-slate-600 md:flex">
                    <Link href="/" class="transition hover:text-slate-950">Accueil</Link>
                    <Link :href="route('properties.index')" class="transition hover:text-slate-950">Catalogue</Link>
                    <a :href="`tel:${phoneNumber}`" class="transition hover:text-slate-950">Contact</a>
                </div>

                <Link :href="route('properties.index')" class="sahel-button-secondary">
                    Retour catalogue
                </Link>
            </nav>
        </header>

        <section class="relative overflow-hidden bg-slate-950 py-16 text-white">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(16,185,129,0.18),transparent_35%)]"></div>
            <div class="sahel-shell relative">
                <div class="grid gap-8 lg:grid-cols-[1.2fr_0.8fr] lg:items-end">
                    <div>
                        <div class="flex flex-wrap gap-3">
                            <span class="rounded-full bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-white/80">
                                {{ property.category?.name }}
                            </span>
                            <span class="rounded-full bg-emerald-500/15 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-emerald-200">
                                {{ property.type === 'sale' ? 'A vendre' : 'A louer' }}
                            </span>
                            <span v-if="property.featured" class="rounded-full bg-amber-500 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-white">
                                Premium
                            </span>
                        </div>

                        <h1 class="mt-6 font-display text-4xl leading-tight sm:text-5xl">{{ property.title }}</h1>
                        <p class="mt-4 text-lg text-white/70">{{ property.location }}</p>
                    </div>

                    <div class="rounded-[2rem] border border-white/10 bg-white/10 p-6 backdrop-blur">
                        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-white/50">Prix affiche</p>
                        <p class="mt-3 text-4xl font-semibold text-white">{{ formatPrice(property.price) }}</p>
                        <p class="mt-3 text-sm leading-6 text-white/70">
                            Une fiche enrichie pour declencher plus facilement un appel, une visite ou une prise d information.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-12">
            <div class="sahel-shell">
                <div class="grid gap-8 lg:grid-cols-[1.15fr_0.85fr]">
                    <div class="space-y-8">
                        <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-[0_20px_60px_rgba(15,23,42,0.06)]">
                            <div class="h-[420px] bg-slate-100">
                                <img v-if="currentImageUrl" :src="currentImageUrl" :alt="property.title" class="h-full w-full object-cover" />
                            </div>

                            <div v-if="images.length > 1" class="grid grid-cols-4 gap-3 border-t border-slate-200 p-4 sm:grid-cols-5">
                                <button
                                    v-for="(image, index) in images"
                                    :key="image.id || index"
                                    type="button"
                                    class="overflow-hidden rounded-2xl"
                                    :class="activeImage === index ? 'ring-2 ring-emerald-500 ring-offset-2' : 'opacity-70 transition hover:opacity-100'"
                                    @click="activeImage = index"
                                >
                                    <img :src="`/storage/${image.image_path}`" :alt="`${property.title} ${index + 1}`" class="h-20 w-full object-cover sm:h-24" />
                                </button>
                            </div>
                        </div>

                        <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-[0_20px_60px_rgba(15,23,42,0.06)] sm:p-8">
                            <div class="flex flex-wrap gap-4">
                                <div v-for="item in propertyStats" :key="item.label" class="min-w-[170px] flex-1 rounded-[1.5rem] border border-slate-200 bg-slate-50 px-4 py-4">
                                    <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ item.label }}</div>
                                    <div class="mt-2 text-lg font-semibold text-slate-900">{{ item.value }}</div>
                                </div>
                            </div>

                            <div class="mt-8 border-t border-slate-200 pt-8">
                                <h2 class="text-2xl font-semibold text-slate-950">Description</h2>
                                <p class="mt-4 whitespace-pre-wrap leading-7 text-slate-600">
                                    {{ property.description || 'La description detaillee sera disponible prochainement.' }}
                                </p>
                            </div>
                        </div>

                        <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-[0_20px_60px_rgba(15,23,42,0.06)] sm:p-8">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Localisation</div>
                                    <h2 class="mt-2 text-2xl font-semibold text-slate-950">Situer le bien</h2>
                                </div>
                                <div class="text-sm text-slate-500">{{ property.location }}</div>
                            </div>
                            <div class="mt-6">
                                <PropertyMap :location="property.location" />
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6 lg:sticky lg:top-24 lg:self-start">
                        <div class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-[0_20px_60px_rgba(15,23,42,0.06)] sm:p-8">
                            <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Prise de contact</div>
                            <h2 class="mt-2 text-2xl font-semibold text-slate-950">Demander une visite</h2>
                            <p class="mt-3 text-sm leading-6 text-slate-500">
                                Le formulaire enregistre un lead dans l'administration, en plus du canal WhatsApp et du contact telephonique.
                            </p>

                            <div v-if="$page.props.flash?.message" class="mt-5 rounded-[1.5rem] border border-emerald-200 bg-emerald-50 px-4 py-4 text-sm font-medium text-emerald-700">
                                {{ $page.props.flash.message }}
                            </div>

                            <div class="mt-6 space-y-3">
                                <a :href="whatsappUrl" target="_blank" class="flex items-center justify-center rounded-full bg-emerald-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-emerald-700">
                                    Contacter sur WhatsApp
                                </a>
                                <a :href="`tel:${phoneNumber}`" class="flex items-center justify-center rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-950">
                                    Appeler l'agence
                                </a>
                                <button type="button" class="flex w-full items-center justify-center rounded-full border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50" @click="shareListing">
                                    Partager l'annonce
                                </button>
                                <div v-if="shareNotice" class="rounded-[1.25rem] border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
                                    {{ shareNotice }}
                                </div>
                            </div>

                            <form class="mt-6 space-y-4" @submit.prevent="submitInquiry">
                                <input v-model="form.name" type="text" class="sahel-input" placeholder="Votre nom" />
                                <div v-if="form.errors.name" class="text-sm text-red-600">{{ form.errors.name }}</div>

                                <input v-model="form.phone" type="text" class="sahel-input" placeholder="Telephone" />
                                <div v-if="form.errors.phone" class="text-sm text-red-600">{{ form.errors.phone }}</div>

                                <input v-model="form.email" type="email" class="sahel-input" placeholder="Email" />
                                <div v-if="form.errors.email" class="text-sm text-red-600">{{ form.errors.email }}</div>

                                <select v-model="form.preferred_contact" class="sahel-input">
                                    <option value="whatsapp">WhatsApp</option>
                                    <option value="phone">Telephone</option>
                                    <option value="email">Email</option>
                                </select>

                                <input v-model="form.preferred_visit_date" type="date" class="sahel-input" />
                                <div v-if="form.errors.preferred_visit_date" class="text-sm text-red-600">{{ form.errors.preferred_visit_date }}</div>

                                <input v-model="form.budget" type="number" min="0" class="sahel-input" placeholder="Budget estime" />
                                <div v-if="form.errors.budget" class="text-sm text-red-600">{{ form.errors.budget }}</div>

                                <textarea v-model="form.message" rows="4" class="sahel-input" placeholder="Precisez votre projet, vos delais ou vos criteres"></textarea>
                                <div v-if="form.errors.message" class="text-sm text-red-600">{{ form.errors.message }}</div>

                                <button type="submit" class="sahel-button-primary w-full" :disabled="form.processing">
                                    Envoyer la demande
                                </button>
                            </form>

                            <div class="mt-6 rounded-[1.5rem] border border-dashed border-slate-200 px-4 py-4">
                                <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Reference</div>
                                <div class="mt-2 text-lg font-semibold text-slate-900">ANN-{{ property.id }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section v-if="related_properties.length" class="bg-slate-50 py-12">
            <div class="sahel-shell">
                <div class="flex items-end justify-between gap-4">
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Suggestions</div>
                        <h2 class="mt-2 text-3xl font-semibold text-slate-950">Autres biens a decouvrir</h2>
                    </div>
                    <Link :href="route('properties.index')" class="text-sm font-semibold text-emerald-700">
                        Retour au catalogue
                    </Link>
                </div>

                <div class="mt-8 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    <article v-for="relatedProperty in related_properties" :key="relatedProperty.id" class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-[0_20px_60px_rgba(15,23,42,0.06)]">
                        <div class="h-64 bg-slate-100">
                            <img v-if="relatedImage(relatedProperty)" :src="relatedImage(relatedProperty)" :alt="relatedProperty.title" class="h-full w-full object-cover" />
                        </div>
                        <div class="p-6">
                            <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ relatedProperty.category?.name }}</div>
                            <h3 class="mt-3 text-2xl font-semibold text-slate-950">{{ relatedProperty.title }}</h3>
                            <p class="mt-2 text-sm text-slate-500">{{ relatedProperty.location }}</p>
                            <div class="mt-5 flex items-center justify-between gap-4">
                                <div class="text-xl font-semibold text-slate-950">{{ formatPrice(relatedProperty.price) }}</div>
                                <Link :href="route('properties.show', relatedProperty.slug)" class="sahel-button-primary">
                                    Voir
                                </Link>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <PublicFooter />
    </div>
</template>
