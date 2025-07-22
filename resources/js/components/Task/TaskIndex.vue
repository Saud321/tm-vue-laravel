<template>
    <table class="w-full text-left table-auto min-w-max">
        <thead>
        <tr>
            <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                    Title
                </p>
            </th>
            <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                    Deadline
                </p>
            </th>

            <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                    Category
                </p>
            </th>

            <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                    Status
                </p>
            </th>
            <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                    Actions
                </p>
            </th>
            <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                <p class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70"></p>
            </th>
        </tr>
        </thead>

        <tbody>

        <tr v-for="task in tasks" :key="task.id">
            <td class="p-4 border-b border-blue-gray-50">
                <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                    {{ task.title }}
                </p>
            </td>
            <td class="p-4 border-b border-blue-gray-50">
                <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                    {{ task.deadline }}
                </p>
            </td>
            <td class="p-4 border-b border-blue-gray-50">
                <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                    {{ task.category }}
                </p>
            </td>
            <td class="p-4 border-b border-blue-gray-50">
                <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                    {{ task.status }}
                </p>
            </td>
            <td class="p-4 border-b border-blue-gray-50">

                <button @click="$emit('edit', task)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full m-1">
                    <font-awesome-icon :icon="['fas', 'edit']" class="px-1"/>
                </button>
                <button  @click="$emit('delete', task)" class="bg-red-700 hover:bg-red-800 text-white font-bold py-2 px-4 rounded-full">
                    <font-awesome-icon :icon="['fas', 'trash']" class="px-1"/>
                </button>

            </td>

            <td class="p-4 border-b border-blue-gray-50">
                <button @click="$emit('toggle', task.id)" :class="{'line-through text-gray-400': task.status==='completed'}">
                    {{ (task.status === 'completed') ? '✅ Completed' : '⬜ Mark Complete' }}
                </button>
            </td>
        </tr>

        </tbody>
    </table>


    <div class="flex justify-center gap-2 mt-6 py-2" v-if="pagination.last > 1" >
        <button
            @click="$emit( 'prev')"
            :disabled="pagination.current === 1"
            class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300"
        >
            Prev
        </button>

        <button
            @click="$emit('next')"
            :disabled="pagination.current === pagination.last"
            class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300"
        >
            Next
        </button>
    </div>

</template>

<script setup>
defineProps(['tasks', 'pagination']);
</script>
