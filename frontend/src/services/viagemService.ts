import { api } from './api'
import type { ApiResponse, NovaViagemPayload, Viagem } from '@/types'

export const viagemService = {
  async listar(page = 1): Promise<ApiResponse> {
    const { data } = await api.get('/viagens', { params: { page } })
    return data
  },

  async criar(payload: NovaViagemPayload): Promise<Viagem> {
    const { data } = await api.post('/viagens', payload)
    return data.viagem ?? data
  },

  async buscar(id: number): Promise<Viagem> {
    const { data } = await api.get(`/viagens/${id}`)
    return data.viagem ?? data
  },

  async atualizarStatus(id: number, status: string): Promise<Viagem> {
    const { data } = await api.patch(`/viagens/${id}/status`, { status })
    return data.viagem ?? data
  },
  async remover(id: number) {
    return await api.delete(`/viagens/${id}`);
  }

}
