<template>
    <th scope="col" class="px-4 py-3" @click="emit('sort')">
        <div class="flex items-center">
            {{ name }}
            <svg v-if="isCurrentSort" class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                viewBox="0 0 32 32">
                <path fill="currentColor"
                    d="m16 28l-7-7l1.41-1.41L16 25.17l5.59-5.58L23 21zm0-24l7 7l-1.41 1.41L16 6.83l-5.59 5.58L9 11z" />
            </svg>
        </div>
    </th>
</template>
<script setup>
defineProps({
    name: String,
    isCurrentSort: { type: Boolean, default: false }
});

const emit = defineEmits(['sort']);

</script>