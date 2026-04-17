<script setup>
import { computed, onBeforeUnmount, ref, watch } from 'vue';
import AdminIcon from '@/Components/AdminIcon.vue';

const props = defineProps({
    modelValue: {
        type: Array,
        default: () => [],
    },
    existingImages: {
        type: Array,
        default: () => [],
    },
    label: {
        type: String,
        default: 'Déposez vos photos ici',
    },
    helper: {
        type: String,
        default: 'Glissez-déposez des images ou cliquez pour sélectionner plusieurs fichiers.',
    },
});

const emit = defineEmits(['update:modelValue']);

const inputRef = ref(null);
const dragActive = ref(false);
const previewUrls = ref([]);

const revokePreviewUrls = () => {
    previewUrls.value.forEach((url) => URL.revokeObjectURL(url));
    previewUrls.value = [];
};

watch(
    () => props.modelValue,
    (files) => {
        revokePreviewUrls();
        previewUrls.value = (files ?? []).map((file) => URL.createObjectURL(file));
    },
    { immediate: true },
);

onBeforeUnmount(() => revokePreviewUrls());

const setFiles = (fileList) => {
    emit('update:modelValue', Array.from(fileList ?? []));
};

const previews = computed(() =>
    previewUrls.value.map((url, index) => ({
        id: `new-${index}`,
        url,
        name: props.modelValue[index]?.name ?? `Image ${index + 1}`,
        isNew: true,
    })),
);

const existingPreviews = computed(() =>
    props.existingImages.map((image, index) => ({
        id: image.id ?? `existing-${index}`,
        url: `/storage/${image.image_path}`,
        name: `Photo existante ${index + 1}`,
        isNew: false,
    })),
);

const allPreviews = computed(() => [...existingPreviews.value, ...previews.value]);
</script>

<template>
    <div>
        <button
            type="button"
            class="admin-dropzone w-100 p-5 text-center"
            :class="{ 'is-drag': dragActive }"
            @click="inputRef?.click()"
            @dragover.prevent="dragActive = true"
            @dragleave.prevent="dragActive = false"
            @drop.prevent="
                dragActive = false;
                setFiles($event.dataTransfer?.files);
            "
        >
            <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-white shadow-sm" style="width: 3.5rem; height: 3.5rem;">
                <AdminIcon name="upload" class="text-success" style="width: 1.5rem; height: 1.5rem;" />
            </div>
            <div class="fw-semibold fs-5 mt-4">{{ label }}</div>
            <div class="text-secondary mt-2">{{ helper }}</div>
            <div class="small text-uppercase fw-bold text-secondary mt-3" style="letter-spacing: 0.18em;">
                JPG, PNG, WEBP • plusieurs fichiers
            </div>

            <input
                ref="inputRef"
                type="file"
                accept="image/*"
                multiple
                class="d-none"
                @change="setFiles($event.target.files)"
            />
        </button>

        <div v-if="allPreviews.length" class="row g-3 mt-2">
            <div v-for="preview in allPreviews" :key="preview.id" class="col-sm-6 col-xl-3">
                <div class="admin-preview-card h-100">
                    <img :src="preview.url" :alt="preview.name" class="w-100" style="height: 140px; object-fit: cover;" />
                    <div class="p-3 d-flex align-items-center justify-content-between gap-2">
                        <div class="small fw-medium text-truncate">{{ preview.name }}</div>
                        <span class="badge rounded-pill" :class="preview.isNew ? 'text-bg-success-subtle text-success-emphasis' : 'text-bg-secondary'">
                            {{ preview.isNew ? 'Nouveau' : 'Existant' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
