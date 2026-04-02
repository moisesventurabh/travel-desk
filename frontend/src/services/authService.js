import { api } from './api';
export const authService = {
    async login(payload) {
        const { data } = await api.post('/login', payload);
        return data;
    },
    async logout() {
        await api.post('/logout');
    },
    async me() {
        const { data } = await api.get('/me');
        return data.user ?? data;
    },
};
