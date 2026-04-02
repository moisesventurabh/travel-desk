<script setup lang="ts">
import type { Viagem } from '@/types'
import { useAuthStore } from '@/stores/auth'
import { useViagemStore } from '@/stores/viagens'
import { useToast } from '@/composables/useToast'

const props = defineProps<{ viagem: Viagem }>()
const emit  = defineEmits<{ fechar: [] }>()

const auth  = useAuthStore()
const store = useViagemStore()
const toast = useToast()

const isAdmin = auth.user?.role === 'admin'

const fmtData = (iso: string) =>
  new Date(iso).toLocaleDateString('pt-BR', { day: '2-digit', month: '2-digit', year: 'numeric' })

const duracaoDias = (() => {
  const d = new Date(props.viagem.data_volta).getTime() - new Date(props.viagem.data_ida).getTime()
  return Math.ceil(d / 86_400_000)
})()

const statusCfg: Record<string, { label: string; cls: string }> = {
  solicitado: { label: 'Solicitado', cls: 'bg-amber-50 text-amber-700 ring-1 ring-amber-200' },
  aprovado:   { label: 'Aprovado',   cls: 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200' },
  cancelado:  { label: 'Cancelado',  cls: 'bg-red-50 text-red-700 ring-1 ring-red-200' },
}

async function alterarStatus(novoStatus: string) {
  try {
    await store.atualizarStatus(props.viagem.id, novoStatus)
    toast.success(`Pedido ${novoStatus} com sucesso!`)
    emit('fechar')
  } catch {
    toast.error('Erro ao atualizar status.')
  }
}
</script>

<template>
  <Teleport to="body">
    <div
      class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
      @click.self="emit('fechar')"
    >
      <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md animate-fade-up">

        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
          <div>
            <p class="font-mono text-[10px] font-bold text-slate-400">#VGM-{{ String(viagem.id).padStart(4,'0') }}</p>
            <h2 class="text-base font-bold text-slate-900 leading-tight">{{ viagem.destino }}</h2>
          </div>
          <div class="flex items-center gap-2">
            <span :class="['inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold', statusCfg[viagem.status]?.cls]">
              {{ statusCfg[viagem.status]?.label }}
            </span>
            <button
              class="w-8 h-8 rounded-lg flex items-center justify-center text-red-500 bg-red-100 hover:bg-slate-100 transition-colors"
              @click="emit('fechar')"
            >
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>
        </div>

        <!-- Body -->
        <div class="px-6 py-5 space-y-4">

          <!-- Rota -->
          <div class="flex items-center gap-3 p-3.5 bg-slate-50 rounded-xl">
            <div class="flex-1 text-center">
              <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Origem</p>
              <p class="text-sm font-bold text-slate-800">{{ viagem.origem }}</p>
            </div>
            <svg class="w-5 h-5 text-brand-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
            </svg>
            <div class="flex-1 text-center">
              <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Destino</p>
              <p class="text-sm font-bold text-slate-800">{{ viagem.destino }}</p>
            </div>
          </div>

          <!-- Info grid -->
          <div class="grid grid-cols-2 gap-3">
            <div class="p-3 bg-slate-50 rounded-xl">
              <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Data de Ida</p>
              <p class="text-sm font-semibold text-slate-800">{{ fmtData(viagem.data_ida) }}</p>
            </div>
            <div class="p-3 bg-slate-50 rounded-xl">
              <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Data de Volta</p>
              <p class="text-sm font-semibold text-slate-800">{{ fmtData(viagem.data_volta) }}</p>
            </div>
            <div class="p-3 bg-slate-50 rounded-xl">
              <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Solicitante</p>
              <p class="text-sm font-semibold text-slate-800">{{ viagem.solicitante }}</p>
            </div>
            <div class="p-3 bg-slate-50 rounded-xl">
              <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Duração</p>
              <p class="text-sm font-semibold text-slate-800">{{ duracaoDias }} dia{{ duracaoDias > 1 ? 's' : '' }}</p>
            </div>
          </div>

          <!-- Usuário -->
          <div class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-100">
            <div class="w-8 h-8 rounded-full bg-brand-100 flex items-center justify-center text-brand-700 text-xs font-bold flex-shrink-0">
              {{ viagem.user.name.slice(0,2).toUpperCase() }}
            </div>
            <div>
              <p class="text-sm font-semibold text-slate-800">{{ viagem.user.name }}</p>
              <p class="text-xs text-slate-400">{{ viagem.user.email }}</p>
            </div>
            <span class="ml-auto text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-500 uppercase">
              {{ viagem.user.role }}
            </span>
          </div>

          <!-- Ações admin -->
          <template v-if="isAdmin && viagem.status === 'solicitado'">
            <div class="flex gap-2.5 pt-1">
              <!--
              <button
                class="btn-danger flex-1 justify-center text-sm"
                @click="alterarStatus('cancelado')"
              >
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Cancelar
              </button>
              <button
                class="btn-success flex-1 justify-center text-sm"
                @click="alterarStatus('aprovado')"
              >
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                </svg>
                Aprovar
              </button>
              -->
            </div>
          </template>

          <!-- Aprovado bloqueado -->
          <div
            v-else-if="viagem.status === 'aprovado'"
            class="flex items-center gap-2 p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-xs text-emerald-700"
          >
            <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Pedido aprovado. Não pode ser cancelado automaticamente.
          </div>
        </div>
      </div>
    </div>
  </Teleport>
</template>
