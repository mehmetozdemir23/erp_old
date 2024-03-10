<template>
    <tr class="border-b hover:bg-sky-100 cursor-default">
        <td class="px-4 py-3">
            <input type="checkbox" name="" id="">
        </td>
        <td v-for="(field, index) in displayedFields" :key="index" class="px-4 py-3 truncate max-w-[12rem]">{{ row[field] }}
        </td>
    </tr>
</template>
<script setup>

const props = defineProps({
    row: {
        type: Object,
        required: true
    },
    displayedFields: {
        type: Array,
        required: true
    },
});

</script>