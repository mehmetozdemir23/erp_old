<template>
    <Head :title="title ? `${title} - Laravel` : 'Laravel'">
        <slot />
    </Head>
</template>
<script setup>
import { Head } from '@inertiajs/vue3';
defineProps({
    title: {
        type: String,
        default: ''
    }
});
</script>