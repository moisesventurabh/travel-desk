import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import { viagemService } from '@/services/viagemService'
import type { Viagem, NovaViagemPayload, ViagemPaginacao } from '@/types'

export const useViagemStore = defineStore('viagens', () => {
  const paginacao  = ref<ViagemPaginacao | null>(null)
  const carregando = ref(false)
  const enviando   = ref(false)
  const erro       = ref<string | null>(null)

  const viagens = computed(() => paginacao.value?.data ?? [])

  const stats = computed(() => {
    const all = viagens.value
    return {
      total:       all.length,
      solicitados: all.filter(v => v.status === 'solicitado').length,
      aprovados:   all.filter(v => v.status === 'aprovado').length,
      cancelados:  all.filter(v => v.status === 'cancelado').length,
    }
  })

  async function carregar(page = 1) {
    carregando.value = true
    erro.value = null
    try {
      const res = await viagemService.listar(page)
      paginacao.value = res.viagens
    } catch (e: unknown) {
      erro.value = (e as Error).message ?? 'Erro ao carregar viagens.'
    } finally {
      carregando.value = false
    }
  }

  async function criar(payload: NovaViagemPayload): Promise<Viagem> {
    enviando.value = true
    try {
      const nova = await viagemService.criar(payload)
      await carregar()
      return nova
    } finally {
      enviando.value = false
    }
  }

  async function atualizarStatus(id: number, status: string) {
    const atualizada = await viagemService.atualizarStatus(id, status)
    if (paginacao.value) {
      const idx = paginacao.value.data.findIndex(v => v.id === id)
      if (idx !== -1) paginacao.value.data[idx] = atualizada
    }
  }

  // src/stores/viagens.ts
  async function removerViagem(id: number) {

    enviando.value = true 
    try {
      await viagemService.remover(id);  
      console.log('Remoção concluída com sucesso no backend');

      if (paginacao.value) {
        paginacao.value.data = paginacao.value.data.filter(v => v.id !== id);
      }

      return true;
    } catch (e) {
      console.error('Erro ao remover viagem na store:', e);
      throw e;
    } finally {
      enviando.value = false 
    }
  }
return {
  paginacao,
  carregando,
  enviando,
  erro,
  viagens,
  stats,
  carregar,
  criar,
  atualizarStatus,
  removerViagem // Certifique-se de que esta linha existe!
}
})
