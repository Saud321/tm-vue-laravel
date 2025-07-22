<!-- components/TaskFilter.vue -->
<template>
    <div class="flex flex-wrap gap-2 my-4">
        <button
            v-for="option in filters"
            :key="option.value"
            @click="$emit('filter', option.value)"
            class="px-3 py-1 rounded bg-gray-200 hover:bg-gray-300 text-sm"
        >
            {{ option.label }}
        </button>
    </div>
</template>

<script setup>
const filters = [
    { label: 'All', value: 'all' },
    { label: 'Completed', value: 'completed' },
    { label: 'Pending', value: 'pending' },
    { label: 'Work', value: 'work' },
    { label: 'Personal', value: 'personal' },
    { label: 'Urgent', value: 'urgent' },
];
</script>
