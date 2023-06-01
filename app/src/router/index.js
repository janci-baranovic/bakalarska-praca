import { createRouter, createWebHistory } from "vue-router"
import { useAuthStore } from "../stores/auth";

const routes = [
    {
        path: '/',
        name: 'Home',
        component: () => import('../views/Home.vue'),
        meta: {
            hasBackgroundImage: true,
            requiresAuth: false,
            requiresAdmin: false
        },
    },
    {
        path: '/login',
        name: 'Login',
        component: () => import('../views/Auth/Login.vue'),
        meta: {
            hasBackgroundImage: false,
            requiresAuth: false,
            requiresAdmin: false
        },
    },
    {
        path: '/register',
        name: 'Register',
        component: () => import('../views/Auth/Register.vue'),
        meta: {
            hasBackgroundImage: false,
            requiresAuth: false,
            requiresAdmin: false
        },
    },
    {
        path: '/tests',
        name: 'Tests',
        component: () => import('../views/Test/Tests.vue'),
        meta: {
            hasBackgroundImage: false,
            requiresAuth: true,
            requiresAdmin: false
        },
    },
    {
        path: '/test/:id',
        name: 'Test',
        component: () => import('../views/Test/Test.vue'),
        meta: {
            hasBackgroundImage: false,
            requiresAuth: true,
            requiresAdmin: false
        },
    },
    {
        path: '/test/create',
        name: 'TestCreate',
        component: () => import('../views/Test/TestCreate.vue'),
        meta: {
            hasBackgroundImage: false,
            requiresAuth: true,
            requiresAdmin: true
        },
    },
    {
        path: '/test/:id/edit',
        name: 'TestEdit',
        component: () => import('../views/Test/TestEdit.vue'),
        meta: {
            hasBackgroundImage: false,
            requiresAuth: true,
            requiresAdmin: true
        },
    },
    {
        path: '/lections',
        name: 'Lections',
        component: () => import('../views/Lection/Lections.vue'),
        meta: {
            hasBackgroundImage: false,
            requiresAuth: false,
            requiresAdmin: false
        },
    },
    {
        path: '/lection/:id',
        name: 'Lection',
        component: () => import('../views/Lection/Lection.vue'),
        meta: {
            hasBackgroundImage: false,
            requiresAuth: false,
            requiresAdmin: false
        },
    },
    {
        path: '/lection/:id/edit',
        name: 'LectionEdit',
        component: () => import('../views/Lection/LectionEdit.vue'),
        meta: {
            hasBackgroundImage: false,
            requiresAuth: true,
            requiresAdmin: true
        },
    },
    {
        path: '/lection/create',
        name: 'LectionCreate',
        component: () => import('../views/Lection/LectionCreate.vue'),
        meta: {
            hasBackgroundImage: false,
            requiresAuth: true,
            requiresAdmin: true
        },
    },
    {
        path: '/tests/completed/:user?',
        name: 'CompletedTests',
        component: () => import('../views/Test/CompletedTests.vue'),
        meta: {
            hasBackgroundImage: false,
            requiresAuth: true,
            requiresAdmin: false
        },
    },
    {
        path: '/tests/completed/:test/:attempt/:user?',
        name: 'TestAttempt',
        component: () => import('../views/Test/TestAttempt.vue'),
        meta: {
            hasBackgroundImage: false,
            requiresAuth: true,
            requiresAdmin: false
        },
    },
    {
        path: '/dashboard',
        name: 'Dashboard',
        component: () => import('../views/Dashboard.vue'),
        meta: {
            hasBackgroundImage: true,
            requiresAuth: true,
            requiresAdmin: true
        },
    },
    {
        path: '/user',
        name: 'Profile',
        component: () => import('../views/Profile.vue'),
        meta: {
            hasBackgroundImage: false,
            requiresAuth: true,
            requiresAdmin: false
        },
    },
    {
        path: '/unauthorized',
        name: 'Unauthorized',
        component: () => import('../views/Unauthorized.vue'),
        meta: {
            hasBackgroundImage: false,
            requiresAuth: false,
            requiresAdmin: false
        },
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'NotFound',
        component: () => import('../views/NotFound.vue'),
        meta: {
            hasBackgroundImage: false,
            requiresAuth: false,
            requiresAdmin: false
        },
    }
]


const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from, next) => {
    const authStore = useAuthStore();
    const isAuthenticated = authStore.authUser !== null;
    const isAdmin = authStore.authUser !== null && authStore.authUser.is_admin === 1;

    if (to.meta.requiresAuth && !isAuthenticated) {
        next({ name: "Login" });
    } else if (to.meta.requiresAdmin && !isAdmin) {
        next({ name: "Unauthorized" });
    } else {
        next();
    }
});

export default router