<template>
    <div v-html="menu"></div>
</template>

<script>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';


export default {
    name: 'SidebarLinks',
    setup() {
        return { menu: computed(() => usePage().props.menu) };
    },
};
</script>

<style scoped></style>
