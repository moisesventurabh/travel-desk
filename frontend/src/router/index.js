import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '@/stores/auth';
const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/login',
            name: 'login',
            component: () => import('@/views/LoginView.vue'),
            meta: { guest: true },
        },
        {
            path: '/',
            name: 'dashboard',
            component: () => import('@/views/DashboardView.vue'),
            meta: { auth: true },
        },
        { path: '/:pathMatch(.*)*', redirect: '/' },
    ],
});
router.beforeEach(async (to) => {
    const auth = useAuthStore();
    //if (auth.token && !auth.user) await auth.carregarUsuario()
    if (to.meta.auth && !auth.token) {
        return { name: 'login' };
    }
    if (to.meta.guest && auth.token) {
        return { name: 'dashboard' };
    }
});
export default router;
