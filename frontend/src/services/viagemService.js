import { api } from './api';
export const viagemService = {
    async listar(page = 1) {
        const { data } = await api.get('/viagens', { params: { page } });
        return data;
    },
    async criar(payload) {
        const { data } = await api.post('/viagens', payload);
        return data.viagem ?? data;
    },
    async buscar(id) {
        const { data } = await api.get(`/viagens/${id}`);
        return data.viagem ?? data;
    },
    async atualizarStatus(id, status) {
        const { data } = await api.patch(`/viagens/${id}/status`, { status });
        return data.viagem ?? data;
    },
    async remover(id) {
        return await api.delete(`/viagens/${id}`);
    }
};
