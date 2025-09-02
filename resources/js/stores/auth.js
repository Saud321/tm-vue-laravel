import {defineStore } from 'pinia';
import axios from "axios";

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null,
    }),
    actions: {

        async getUser() {
            try {

                const token = localStorage.getItem('token')
                axios.defaults.headers.common['Authorization'] = `Bearer ${token}`

                const response = await axios.get('user');
                this.user = response.data;
                return true;

            } catch(err) {
                this.user = null;
                return false;
            }
        },

        async logout() {
            await axios.get('logout');
            localStorage.removeItem('token');
            this.user = null;
            return true;
        }
    }
});
