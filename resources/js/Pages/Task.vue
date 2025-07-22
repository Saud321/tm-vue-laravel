<template>

    <div class="min-h-full">
        <Navbar />

        <main>

            <div class="max-w mx-auto bg-white p-8 rounded shadow">

                <div class="flex items-center justify-between gap-8 mb-8">
                    <div>
                        <h5
                            class="block font-sans text-xl antialiased font-semibold leading-snug tracking-normal text-blue-gray-900">
                            Task list
                        </h5>
                    </div>

                    <div class="flex flex-col gap-2 shrink-0 sm:flex-row">
                        <button
                            @click="openCreate"
                            class="flex select-none items-center gap-3 rounded-lg bg-gray-900 py-2 px-4 text-center align-middle font-sans text-xs font-bold uppercase text-white shadow-md shadow-gray-900/10 transition-all hover:shadow-lg hover:shadow-gray-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                            type="button">
                            <font-awesome-icon :icon="['fas', 'plus']" class="px-1"/> Create Task
                        </button>
                    </div>

                </div>

                <div class="flex items-center justify-between gap-8 mb-8">
                    <div>
                        <TaskFilter @filter="applyFilter" />
                    </div>
                </div>

                <Spinner v-if="loading" />

                <div v-else
                     class="relative flex flex-col w-full h-full overflow-scroll text-gray-700 bg-white shadow-md rounded-xl bg-clip-border">

                    <TaskIndex
                        :tasks="tasks"
                        :pagination="pagination"
                        @edit="openEdit"
                        @delete="openDelete"
                        @toggle="toggleComplete"
                        @prev="fetchTasks(pagination.current - 1)"
                        @next="fetchTasks(pagination.current + 1)"
                    />

                </div>
            </div>
        </main>

        <Create
            :isOpen="showModal"
            :isEdit="!!currentTask"
            :task="currentTask"
            @close="closeModal"
            @submit="saveTask"
        />

        <Delete
            :isOpen="showDeleteModal"
            @cancel="closeDelete"
            @confirm="deleteTask"
        />


    </div>

</template>

<script setup>

import { ref, onMounted} from "vue";


import TaskFilter from '../components/Task/TaskFilter.vue';
import Create from '../components/Task/Create.vue';
import Delete from '../components/Task/Delete.vue';
import Spinner from '../components/Spinner.vue'
import Navbar from "../components/Navbar.vue";
import TaskIndex from "../components/Task/TaskIndex.vue";
import {useToast} from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

const $toast = useToast();

const tasks = ref([]);

const loading = ref(false);
const showModal = ref(false);
const currentTask = ref(null);
const showDeleteModal = ref(false);
const deleteId = ref(null);
const currentFilter = ref('all');
const pagination = ref({});

const closeModal = () => {

    currentTask.value = null;
    showModal.value = false
};

const applyFilter = (filter) => {
    currentFilter.value = filter;
    fetchTasks(1, filter);
};

const fetchTasks = async (page = 1, filter = currentFilter.value) => {

    loading.value = true;

    try {
        const url =
            filter === 'all'
                ? `/tasks?page=${page}`
                : `/tasks/filter/${encodeURIComponent(filter)}?page=${page}`;

        const token = localStorage.getItem('token');
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        const res = await axios.get(url);
        tasks.value = res.data.data.data;
        pagination.value = {
            current: res.data.data.current_page,
            last: res.data.data.last_page,
        };
    } catch (e) {
        $toast.error('Failed to load tasks.', {
            status: 500,
            duration: 5000,
        });
    } finally {
        loading.value = false;
    }

}

const openCreate = () => {
    currentTask.value = null;
    showModal.value = true;
};

const openEdit = (task) => {
    currentTask.value = task;
    showModal.value = true;
};

const saveTask = async (data) => {
    try {
        if (currentTask.value) {
            await axios.put(`tasks/${currentTask.value.id}`, data);
        } else {
            await axios.post('tasks', data);
        }
        await fetchTasks();
        showModal.value = false;
        $toast.success('Task saved successfully.', {
            duration: 3000,
        });
    } catch (err) {
        $toast.error('Something went wrong while saving tasks.', {
            duration: 3000,
        });
    }
};

const openDelete = (id) => {
    deleteId.value = id;
    showDeleteModal.value = true;
};

const deleteTask = async () => {
    try {
        await axios.delete(`tasks/${deleteId.value}`);
        showDeleteModal.value = false;

        await fetchTasks();
        $toast.success('Task deleted successfully.', {
            duration: 3000,
        });
    } catch (e) {
        $toast.error('Failed to delete task.', {
            duration: 3000,
        });
    }

};

const toggleComplete = async (taskId) => {
    try {

        await axios.put(`/tasks/${taskId}`, { status: 'completed' });
        await fetchTasks();
        $toast.success('Task completed successfully.', {
            duration: 3000,
        });

    } catch (e) {
        $toast.error('Failed to mark task complete.', {
            duration: 3000,
        });
    }
}
const closeDelete = () => showDeleteModal.value = false;

onMounted(fetchTasks);

</script>
