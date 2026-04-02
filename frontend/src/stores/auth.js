import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import { authService } from '@/services/authService';
export const useAuthStore = defineStore('auth', () => {
    const user = ref(JSON.parse(localStorage.getItem('user') || 'null'));
    const token = ref(localStorage.getItem('token'));
    const isLogado = computed(() => !!token.value);
    async function login(payload) {
        const res = await authService.login(payload);
        const accessToken = res.access_token || res.token;
        // salva no estado
        token.value = accessToken;
        user.value = res.user ?? null;
        // salva no navegador
        localStorage.setItem('token', accessToken);
        localStorage.setItem('user', JSON.stringify(res.user));
    }
    async function logout() {
        token.value = null;
        user.value = null;
        localStorage.removeItem('token');
        localStorage.removeItem('user');
    }
    return { user, token, isLogado, login, logout };
});
