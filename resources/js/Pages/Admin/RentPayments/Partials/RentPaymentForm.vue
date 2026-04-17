<script setup>
import { computed, watch } from 'vue';
import InputError from '@/Components/InputError.vue';

defineEmits(['submit']);

const props = defineProps({
    form: {
        type: Object,
        required: true,
    },
    properties: {
        type: Array,
        default: () => [],
    },
    tenants: {
        type: Array,
        default: () => [],
    },
    submitLabel: {
        type: String,
        required: true,
    },
});

const selectedProperty = computed(() =>
    props.properties.find((property) => property.id === Number(props.form.property_id)),
);

watch(
    selectedProperty,
    (property) => {
        if (property?.tenant_contact_id && !props.form.tenant_contact_id) {
            props.form.tenant_contact_id = property.tenant_contact_id;
        }
    },
);

const statusOptions = [
    { value: 'pending', label: 'En attente' },
    { value: 'paid', label: 'Paye' },
    { value: 'late', label: 'En retard' },
    { value: 'partial', label: 'Partiel' },
    { value: 'cancelled', label: 'Annule' },
];
</script>

<template>
    <form @submit.prevent="$emit('submit')" class="space-y-6">
        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Bien concerne</label>
                <select v-model="form.property_id" class="admin-input">
                    <option value="">Choisir un bien</option>
                    <option v-for="property in properties" :key="property.id" :value="property.id">
                        {{ property.title }} - {{ property.location }}
                    </option>
                </select>
                <InputError class="mt-2" :message="form.errors.property_id" />
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Locataire</label>
                <select v-model="form.tenant_contact_id" class="admin-input">
                    <option value="">Selectionner</option>
                    <option v-for="tenant in tenants" :key="tenant.id" :value="tenant.id">
                        {{ tenant.name }}{{ tenant.phone ? ` - ${tenant.phone}` : '' }}
                    </option>
                </select>
                <InputError class="mt-2" :message="form.errors.tenant_contact_id" />
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Montant</label>
                <input v-model="form.amount" type="number" min="0" class="admin-input" />
                <InputError class="mt-2" :message="form.errors.amount" />
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Periode</label>
                <input v-model="form.period_label" type="text" class="admin-input" placeholder="Ex: Avril 2026" />
                <InputError class="mt-2" :message="form.errors.period_label" />
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Date d'echeance</label>
                <input v-model="form.due_date" type="date" class="admin-input" />
                <InputError class="mt-2" :message="form.errors.due_date" />
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Date de paiement</label>
                <input v-model="form.paid_date" type="date" class="admin-input" />
                <InputError class="mt-2" :message="form.errors.paid_date" />
            </div>

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
                <label class="mb-2 block text-sm font-medium text-slate-700">Reference</label>
                <input v-model="form.reference" type="text" class="admin-input" />
                <InputError class="mt-2" :message="form.errors.reference" />
            </div>
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Notes</label>
            <textarea v-model="form.notes" rows="5" class="admin-input"></textarea>
            <InputError class="mt-2" :message="form.errors.notes" />
        </div>

        <div class="flex justify-end border-t border-slate-200 pt-6">
            <button type="submit" class="admin-button-primary" :disabled="form.processing">
                {{ submitLabel }}
            </button>
        </div>
    </form>
</template>
