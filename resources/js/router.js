import {createRouter, createWebHashHistory} from 'vue-router';
import {useAuthStore} from "./stores/auth.js";

import Login from "./Pages/Login.vue";
import Register from "./Pages/Register.vue";
import Task from "./Pages/Task.vue";

const routes = [
    {
        path: "/login",
        component:Login
    },
    {
        path: "/register",
        component:Register,
    },
    { path: '/dashboard', component: Task, meta: { requiresAuth: true } },
    { path: '/', redirect: '/dashboard' }

];

const router = createRouter({
    history: createWebHashHistory(),
    routes
});

router.beforeEach(async (to, from, next) => {
    const auth = useAuthStore()

    if (auth.user === null) {
        // Check once per page reload
        await auth.getUser();
    }

    if (to.meta.requiresAuth && !auth.user) {
        return next('/login')
    }

    next()
});

export default router;
