<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="max-w-md w-full bg-white p-8 rounded shadow">
            <h2 class="text-2xl font-bold mb-6">Login</h2>

            <form @submit.prevent="submit">
                <div class="mb-4">
                    <label class="block text-gray-700">Email</label>
                    <input v-model="form.email" type="email" required class="w-full border rounded px-3 py-2" />
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700">Password</label>
                    <input v-model="form.password" type="password" required class="w-full border rounded px-3 py-2" />
                </div>

                <div class="mb-6">
                    <label>
                        <input v-model="form.remember" type="checkbox" />
                        Remember Me
                    </label>
                </div>

                <div>
                    <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700" type="submit">
                        Register
                    </button>
                </div>

                <p v-if="errors" class="text-red-600 mt-4">{{ errors }}</p>
            </form>

            <p class="mt-4 text-center">
                Don't have an account?
                <router-link to="/" class="text-blue-600 hover:underline">Login</router-link>.
            </p>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    data() {
        return {
            form: {
                email: '',
                password: '',
                remember: false,
            },
            errors: null,
        };
    },
    methods: {
        async submit() {
            this.errors = null;
            try {
                await axios.get('/sanctum/csrf-cookie'); // Get CSRF cookie
                await axios.post('/login', this.form);
                this.$router.push('/');
            } catch (e) {
                if (e.response && e.response.data && e.response.data.message) {
                    this.errors = e.response.data.message;
                } else {
                    this.errors = 'An unexpected error occurred.';
                }
            }
        },
    },
};
</script>
