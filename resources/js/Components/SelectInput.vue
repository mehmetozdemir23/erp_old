<template>
    <label :for="id" class="sr-only">{{ label }}</label>
    <select :id="id" v-model="selectedValue"
        class="block py-2.5 px-4 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer">
        <option v-for="value in values" :key="value" :value="value">
            {{ value }}
        </option>
    </select>
</template>
<script setup>
const props = defineProps({
    id: String,
    label: String,
    values: Array
});

const selectedValue = defineModel();
</script>