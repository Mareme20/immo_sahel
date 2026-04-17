<script setup>
import InputError from '@/Components/InputError.vue';

defineEmits(['submit']);

defineProps({
    form: {
        type: Object,
        required: true,
    },
    properties: {
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
});

const priorityOptions = [
    { value: 'low', label: 'Faible' },
    { value: 'medium', label: 'Moyenne' },
    { value: 'high', label: 'Haute' },
    { value: 'urgent', label: 'Urgente' },
];

const statusOptions = [
    { value: 'open', label: 'Ouverte' },
    { value: 'in_progress', label: 'En cours' },
    { value: 'resolved', label: 'Resolue' },
    { value: 'closed', label: 'Cloturee' },
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
                <label class="mb-2 block text-sm font-medium text-slate-700">Demandeur / contact</label>
                <select v-model="form.contact_id" class="admin-input">
                    <option value="">Aucun contact rattache</option>
                    <option v-for="contact in contacts" :key="contact.id" :value="contact.id">
                        {{ contact.name }}{{ contact.phone ? ` - ${contact.phone}` : '' }}
                    </option>
                </select>
                <InputError class="mt-2" :message="form.errors.contact_id" />
            </div>
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Titre</label>
            <input v-model="form.title" type="text" class="admin-input" />
            <InputError class="mt-2" :message="form.errors.title" />
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Description</label>
            <textarea v-model="form.description" rows="5" class="admin-input"></textarea>
            <InputError class="mt-2" :message="form.errors.description" />
        </div>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Priorite</label>
                <select v-model="form.priority" class="admin-input">
                    <option v-for="option in priorityOptions" :key="option.value" :value="option.value">
                        {{ option.label }}
                    </option>
                </select>
                <InputError class="mt-2" :message="form.errors.priority" />
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
                <label class="mb-2 block text-sm font-medium text-slate-700">Cout estime</label>
                <input v-model="form.estimated_cost" type="number" min="0" class="admin-input" />
                <InputError class="mt-2" :message="form.errors.estimated_cost" />
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Date de signalement</label>
                <input v-model="form.reported_at" type="date" class="admin-input" />
                <InputError class="mt-2" :message="form.errors.reported_at" />
            </div>
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Date de resolution</label>
            <input v-model="form.resolved_at" type="date" class="admin-input" />
            <InputError class="mt-2" :message="form.errors.resolved_at" />
        </div>

        <div class="flex justify-end border-t border-slate-200 pt-6">
            <button type="submit" class="admin-button-primary" :disabled="form.processing">
                {{ submitLabel }}
            </button>
        </div>
    </form>
</template>
