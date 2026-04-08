<script setup>
import { defineAsyncComponent, computed } from 'vue';
import AppLayout from '@/sakai/layout/AppLayout.vue';

const props = defineProps({
    view: {
        type: String,
        required: true,
    },
});

const sakaiViews = import.meta.glob('../sakai/views/**/*.vue');

const ViewComponent = computed(() => {
    const key = `../sakai/views/${props.view}.vue`;
    if (sakaiViews[key]) {
        return defineAsyncComponent(sakaiViews[key]);
    }
    return null;
});
</script>

<template>
    <AppLayout>
        <component :is="ViewComponent" v-if="ViewComponent" />
        <div v-else class="card">
            <p class="text-muted-color">The requested view could not be found.</p>
        </div>
    </AppLayout>
</template>
