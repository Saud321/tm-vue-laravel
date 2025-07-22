<template>
    <div v-if="isOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h2 class="text-xl font-bold mb-4">{{ isEdit ? 'Edit' : 'Create' }} Task</h2>
            <form @submit.prevent="submitForm">
                <input v-model="form.title" type="text" placeholder="Title" class="w-full mb-2 p-2 border rounded" />
                <textarea v-model="form.description" placeholder="Description" class="w-full mb-2 p-2 border rounded"></textarea>
                <input v-model="form.deadline" type="date" class="w-full mb-2 p-2 border rounded" />
                <select v-model="form.category" class="w-full mb-2 p-2 border rounded">
                    <option disabled value="">Select category</option>
                    <option value="personal">Personal</option>
                    <option value="work">Work</option>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                    <option value="urgent">Urgent</option>
                </select>

                <div class="flex justify-end gap-2">
                    <button type="button" @click="close" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
                        {{ isEdit ? 'Update' : 'Create' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
const props = defineProps(['isOpen', 'task', 'isEdit']);
const emit = defineEmits(['close', 'submit']);

const form = ref({
    title: '',
    description: '',
    deadline: '',
    category: '',
});

watch(() => props.task, (newVal) => {
    if (newVal) Object.assign(form.value, newVal);
}, { immediate: true });

function close() {
    form.value = { title: '', description: '', deadline: '', category: '' };
    emit('close');
}

function submitForm() {
    emit('submit', { ...form.value });
}
</script>
