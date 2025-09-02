<template>

    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company" class="mx-auto h-10 w-auto" />
            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Sign in to your account</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form @submit.prevent="login" class="space-y-6">
                <div>
                    <div v-if="errorMessage" class="mb-4 p-4 rounded-md bg-red-50 border border-red-200">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                          clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Login failed</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <p>{{ errorMessage }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <label for="email" class="block text-sm/6 font-medium text-gray-900">Email address</label>
                    <div class="mt-2">
                        <input v-model="email"
                               id="email"
                               type="email"
                               :class="{'input-error': v$.email.$error}"
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1
                               -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2
                               focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                        />
                    </div>
                    <p v-for="err in v$.email.$errors" :key="err.$uid" class="text-red-600 text-sm mt-1">
                        {{ err.$message }}
                    </p>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>
                    </div>
                    <div class="mt-2">
                        <input
                            v-model="password"
                            id="password"
                            type="password"
                            :class="{'input-error': v$.password.$error}"
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1
                            -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2
                            focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                        />
                    </div>
                    <p v-for="err in v$.password.$errors" :key="err.$uid" class="text-red-600 text-sm mt-1">
                        {{ err.$message }}
                    </p>
                </div>

                <div>
                    <button
                        type = "submit"
                        :disabled = "loading"
                        :class="{'btn-loading': loading}"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6
                        font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2
                        focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Sign in
                    </button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm/6 text-gray-500">
                Not a member?
                <router-link to="/" class="font-semibold text-indigo-600 hover:text-indigo-500">
                    Register
                </router-link>
            </p>
        </div>
    </div>

</template>

<script setup>

import {ref, watch } from "vue";
import useVuelidate from "@vuelidate/core";

import router from "../router.js";
import {useAuthStore} from "../stores/auth.js";
import {loginValidationRules} from "../validations/loginValidation.js";

const auth = useAuthStore();
const email = ref("");
const password = ref("");

const loading = ref(false);
const errorMessage = ref("");

const v$ = useVuelidate(loginValidationRules, { email, password });

// Real-time validation
watch(email, () => v$.value.email.$touch());
watch(password, () => v$.value.password.$touch())

const login = async () => {

    const isValid = await v$.value.$validate();
    if (!isValid) return;

    loading.value = true;
    errorMessage.value = "";

    try {

        await axios.get('http://localhost:8000/sanctum/csrf-cookie');
        const res = await axios.post('login', {email: email.value, password: password.value});

        if (res.status === 200) {
            const token = res.data.data.token;
            localStorage.setItem('token', token);
            await auth.getUser();
            router.push('/dashboard');

        } else {
            errorMessage.value = "Invalid credentials";
        }

    } catch (e) {
        errorMessage.value = "Invalid credentials";
        setTimeout(() => (errorMessage.value = ""), 5000);
    } finally {
        loading.value = false;
    }

}

</script>
