<script setup>
import { defineAsyncComponent, computed } from 'vue';
import AppLayout from '@/sakai/layout/AppLayout.vue';

const props = defineProps({
    view: {
        type: String,
        required: true,
    },
});

const sakaviews = import.meta.glob('../sakai/views/**/*.vue');

const ViewComponent = computed(() => {
    const key = `../sakai/views/${props.view}.vue`;
    if (sakaviews[key]) {
        return defineAsyncComponent(sakaviews[key]);
    }
    return null;
});
</script>

<template>
    <AppLayout>
        <component :is="ViewComponent" v-if="ViewComponent" />
    </AppLayout>
</template>
