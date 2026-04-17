<script setup>
import InputError from '@/Components/InputError.vue';

defineEmits(['submit']);

defineProps({
    form: {
        type: Object,
        required: true,
    },
    submitLabel: {
        type: String,
        required: true,
    },
});

const typeOptions = [
    { value: 'owner', label: 'Proprietaire' },
    { value: 'tenant', label: 'Locataire' },
    { value: 'prospect', label: 'Prospect' },
    { value: 'buyer', label: 'Acheteur' },
    { value: 'vendor', label: 'Vendeur' },
    { value: 'other', label: 'Autre' },
];

const channelOptions = [
    { value: 'phone', label: 'Telephone' },
    { value: 'whatsapp', label: 'WhatsApp' },
    { value: 'email', label: 'Email' },
];
</script>

<template>
    <form @submit.prevent="$emit('submit')" class="space-y-6">
        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Nom complet</label>
                <input v-model="form.name" type="text" class="admin-input" />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Societe</label>
                <input v-model="form.company" type="text" class="admin-input" />
                <InputError class="mt-2" :message="form.errors.company" />
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Email</label>
                <input v-model="form.email" type="email" class="admin-input" />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Telephone</label>
                <input v-model="form.phone" type="text" class="admin-input" />
                <InputError class="mt-2" :message="form.errors.phone" />
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Type de contact</label>
                <select v-model="form.type" class="admin-input">
                    <option v-for="option in typeOptions" :key="option.value" :value="option.value">
                        {{ option.label }}
                    </option>
                </select>
                <InputError class="mt-2" :message="form.errors.type" />
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">Canal prefere</label>
                <select v-model="form.preferred_channel" class="admin-input">
                    <option v-for="option in channelOptions" :key="option.value" :value="option.value">
                        {{ option.label }}
                    </option>
                </select>
                <InputError class="mt-2" :message="form.errors.preferred_channel" />
            </div>
        </div>

        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">Notes</label>
            <textarea v-model="form.notes" rows="5" class="admin-input"></textarea>
            <InputError class="mt-2" :message="form.errors.notes" />
        </div>

        <label class="flex items-start gap-3 rounded-3xl border border-slate-200 bg-slate-50 px-5 py-4">
            <input v-model="form.is_active" type="checkbox" class="mt-1 rounded border-slate-300 text-emerald-600" />
            <div>
                <div class="text-sm font-semibold text-slate-900">Contact actif</div>
                <div class="mt-1 text-sm text-slate-500">
                    Les contacts inactifs sont conserves mais moins proposes dans les formulaires.
                </div>
            </div>
        </label>

        <div class="flex flex-col gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end">
            <button type="submit" class="admin-button-primary" :disabled="form.processing">
                {{ submitLabel }}
            </button>
        </div>
    </form>
</template>
