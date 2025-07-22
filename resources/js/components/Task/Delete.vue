<template>
    <div v-if="isOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-sm text-center">
            <h2 class="text-lg font-semibold mb-4">Are you sure you want to delete this task?</h2>
            <div class="flex justify-center gap-4">
                <button @click="onCancel" class="bg-gray-300 px-4 py-2 rounded">Cancel</button>
                <button @click="onConfirm" class="bg-red-600 text-white px-4 py-2 rounded">Delete</button>
            </div>
        </div>
    </div>
</template>

<script setup>

const props = defineProps(['isOpen']);
const emit = defineEmits(['confirm', 'cancel']);

const onCancel = () => emit('cancel');
const onConfirm = () => emit('confirm');
</script>
