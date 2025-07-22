<template>
    <nav class="bg-gray-800">
        <div class="mx-auto max-w-8xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">

                <div class="flex items-center">
                    <div class="shrink-0">
                        <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company" class="size-8" />
                    </div>
                    <div class="mx-auto max-w-8xl px-4 py-6 sm:px-6 lg:px-8">
                        <h1 class="text-3xl font-bold tracking-tight text-blue-50">Task Manager</h1>
                    </div>
                </div>

                <div class="hidden md:block">
                    <div class="ml-4 flex items-center md:ml-6">
                        <button @click="logout" type="button" class="primary-btn relative rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 focus:outline-hidden">
                            Log out
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile menu, show/hide based on menu state. -->
        <div id="mobile-menu" class="md:hidden">

            <div class="border-t border-gray-700 pt-4 pb-3">

                <div class="flex items-center px-5">
                    <button @click="logout" type="button" class="relative ml-auto shrink-0 rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 focus:outline-hidden">
                        Log out
                    </button>
                </div>

            </div>
        </div>

    </nav>

    <header class="bg-white shadow-sm">
        <div class="mx-auto max-w-8xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">Dashboard</h1>
        </div>
    </header>
</template>

<script setup>

import router from "../router.js";

import {useAuthStore} from "../stores/auth.js";
const auth = useAuthStore();

const logout = async () => {
    await auth.logout();
    router.push('/login');
}

</script>
