<script setup>
import { computed } from 'vue';

const props = defineProps({
    status: {
        type: String,
        required: true,
    },
    kind: {
        type: String,
        default: 'property',
    },
});

const config = computed(() => {
    if (props.kind === 'payment') {
        return {
            paid: { label: 'Payé', className: 'admin-status-paid' },
            late: { label: 'Retard', className: 'admin-status-late' },
            pending: { label: 'À suivre', className: 'admin-status-pending' },
        }[props.status] ?? { label: props.status, className: 'admin-status-draft' };
    }

    if (props.kind === 'publication') {
        return {
            published: { label: 'Publié', className: 'admin-status-published' },
            draft: { label: 'Brouillon', className: 'admin-status-draft' },
        }[props.status] ?? { label: props.status, className: 'admin-status-draft' };
    }

    return {
        available: { label: 'Libre', className: 'admin-status-available' },
        rented: { label: 'Loué', className: 'admin-status-rented' },
        maintenance: { label: 'En travaux', className: 'admin-status-maintenance' },
    }[props.status] ?? { label: props.status, className: 'admin-status-draft' };
});
</script>

<template>
    <span class="admin-status-badge" :class="config.className">
        {{ config.label }}
    </span>
</template>
