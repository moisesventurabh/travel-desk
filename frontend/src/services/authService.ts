import { api } from './api'
import type { LoginPayload, AuthUser } from '@/types'

export const authService = {
  async login(payload: LoginPayload): Promise<{ token: string; user: AuthUser }> {
    const { data } = await api.post('/login', payload)
    return data
  },

  async logout(): Promise<void> {
    await api.post('/logout')
  },

  async me(): Promise<AuthUser> {
    const { data } = await api.get('/me')
    return data.user ?? data
  },
}
