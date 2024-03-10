<template>
    <Table>
        <template #head>
            <th class="w-10"></th>
            <DataTableColumn v-for="(column, index) in columns" :key="index" :name="column"
                :is-sorted="column === sortedColumn" @sort="sortBy(column)" />
        </template>
        <template #body>
            <DataTableRow :displayed-fields="columns" v-for="row in rows" :key="row.id" :row="row" />
        </template>
    </Table>
</template>
<script setup>
import DataTableColumn from '@/Components/DataTableColumn.vue';
import DataTableRow from '@/Components/DataTableRow.vue';
import Table from '@/Components/Table.vue';

const props = defineProps({
    columns: {
        type: Array,
        required: true
    },
    rows: {
        type: Object,
        required: true
    },
    sortedColumn: {
        type: String,
        required: true
    },
});

const emit = defineEmits(['sort']);

function sortBy(column) {
    emit('sort', column)
}
</script>