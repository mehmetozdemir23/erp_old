<template>
    <div v-if="localMessage"
        class="z-50 fixed top-8 left-1/2 -translate-x-1/2 p-4 text-sm text-green-800 rounded-lg bg-green-100 shadow-sm shadow-green-300">
        {{ message }}
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const props = defineProps({
    message: String
});

const localMessage = ref(props.message);

onMounted(() => {
    setTimeout(() => {
        localMessage.value = '';
    }, 5000);
});
</script>