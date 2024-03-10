<template>
    <label :for="'select-' + column" class="sr-only">select {{ column }}</label>
    <select :id="'select-' + column" @change="handleFilterChange"
        class="block py-2.5 px-4 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer">
        <option value="all">All {{ column }}</option>
        <option v-for="option in options" :key="option" :value="option" :selected="isSelected(option)">
            {{ option }}
        </option>
    </select>
</template>
<script setup>
const props = defineProps({
    column: String,
    options: Array,
    selectedFilter: [String, Number]
});

const emit = defineEmits(['filterChanged']);

function isSelected(option) {
    return props.selectedFilter === option;
}

function handleFilterChange(event) {
    emit('filterChanged', event.target.value);
};

</script>