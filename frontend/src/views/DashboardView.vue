<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import { useViagemStore }      from '@/stores/viagens'
import { useAuthStore }        from '@/stores/auth'
import NovaViagemModal         from '@/components/viagens/NovaViagemModal.vue'
import ViagemDetalheModal      from '@/components/viagens/ViagemDetalheModal.vue'
import CancelarViagemModal     from '@/components/viagens/CancelarViagemModal.vue'
import PerfilDropdown          from '@/components/ui/PerfilDropdown.vue'

import type { Viagem }         from '@/types'
import { useToast }            from '@/composables/useToast'


const toast = useToast()

const store = useViagemStore()
const auth  = useAuthStore()



// Modais
const modalNova    = ref(false)
const viagemAtiva  = ref<Viagem | null>(null)
const viagemCancelar = ref<Viagem | null>(null)
const filtroStatus = ref<string>('')

const viagensFiltradas = computed(() =>
  filtroStatus.value
    ? store.viagens.filter(v => v.status === filtroStatus.value)
    : store.viagens
)

const fmtData = (iso: string) =>
  new Date(iso).toLocaleDateString('pt-BR', { day: '2-digit', month: '2-digit', year: 'numeric' })

const statusCfg: Record<string, { label: string; dot: string; cls: string }> = {
  solicitado: { label: 'Solicitado', dot: 'bg-amber-400',   cls: 'bg-amber-50 text-amber-700 ring-1 ring-amber-200' },
  aprovado:   { label: 'Aprovado',   dot: 'bg-emerald-500', cls: 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200' },
  cancelado:  { label: 'Cancelado',  dot: 'bg-red-400',     cls: 'bg-red-50 text-red-700 ring-1 ring-red-200' },
}

function abrirModalCancelamento(viagem: Viagem) {
  console.log('Tentando cancelar:', viagem);
  viagemCancelar.value = viagem; // Aqui deve ser viagemCancelar
}

function trocarPagina(p: number) {
  store.carregar(p)
  window.scrollTo({ top: 0, behavior: 'smooth' })
}

onMounted(() => store.carregar())
</script>

<template>
  <div class="min-h-screen bg-slate-50 flex flex-col">

    <!-- ── TOPBAR ── -->
    <header class="h-14 bg-white border-b border-slate-200 flex items-center px-5 gap-4 flex-shrink-0 sticky top-0 z-30">

      <!-- Logo -->
      <div class="flex items-center gap-2.5">
        <div class="w-8 h-8 rounded-lg bg-sky-500 flex items-center justify-center">
          <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/>
          </svg>
        </div>
        <span class="text-sm font-bold text-slate-900 hidden sm:block">Travel Desk</span>
      </div>

      <!-- Spacer -->
      <div class="flex-1" />

      <!-- Botão nova viagem -->
      <button class="btn-primary text-sm" @click="modalNova = true">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        <span class="hidden sm:inline">Nova Viagem</span>
        <span class="sm:hidden">Nova</span>
      </button>

      <!-- Perfil dropdown -->
      <PerfilDropdown />
    </header>

    <!-- ── CONTENT ── -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 py-6 space-y-5">

      <!-- Heading -->
      <div class="flex items-start justify-between">
        <div>
          <h1 class="text-xl font-bold text-slate-900">Pedidos de Viagem</h1>
          <p class="text-sm text-slate-500 mt-0.5">
            Olá, <span class="font-medium text-slate-700">{{ auth.user?.name }}</span> — aqui estão todas as solicitações.
          </p>
        </div>
      </div>

      <!-- Stats -->
      <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        <button
          class="stat-card text-left"
          :class="filtroStatus === '' ? 'ring-2 ring-sky-400' : ''"
          @click="filtroStatus = ''"
        >
          <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total</p>
          <p class="text-3xl font-extrabold text-slate-900 mt-1 tabular-nums">{{ store.stats.total }}</p>
          <p class="text-xs text-slate-400 mt-2">Todos os pedidos</p>
        </button>

        <button
          class="stat-card text-left"
          :class="filtroStatus === 'solicitado' ? 'ring-2 ring-amber-400' : ''"
          @click="filtroStatus = filtroStatus === 'solicitado' ? '' : 'solicitado'"
        >
          <p class="text-[10px] font-bold text-amber-500 uppercase tracking-wider">Solicitados</p>
          <p class="text-3xl font-extrabold text-slate-900 mt-1 tabular-nums">{{ store.stats.solicitados }}</p>
          <p class="text-xs text-slate-400 mt-2">Aguardando aprovação</p>
        </button>

        <button
          class="stat-card text-left"
          :class="filtroStatus === 'aprovado' ? 'ring-2 ring-emerald-400' : ''"
          @click="filtroStatus = filtroStatus === 'aprovado' ? '' : 'aprovado'"
        >
          <p class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider">Aprovados</p>
          <p class="text-3xl font-extrabold text-slate-900 mt-1 tabular-nums">{{ store.stats.aprovados }}</p>
          <p class="text-xs text-slate-400 mt-2">
            {{ store.stats.total > 0 ? Math.round(store.stats.aprovados / store.stats.total * 100) : 0 }}% do total
          </p>
        </button>

        <button
          class="stat-card text-left"
          :class="filtroStatus === 'cancelado' ? 'ring-2 ring-red-400' : ''"
          @click="filtroStatus = filtroStatus === 'cancelado' ? '' : 'cancelado'"
        >
          <p class="text-[10px] font-bold text-red-500 uppercase tracking-wider">Cancelados</p>
          <p class="text-3xl font-extrabold text-slate-900 mt-1 tabular-nums">{{ store.stats.cancelados }}</p>
          <p class="text-xs text-slate-400 mt-2">
            {{ store.stats.total > 0 ? (store.stats.cancelados / store.stats.total * 100).toFixed(1) : 0 }}% do total
          </p>
        </button>
      </div>

      <!-- Tabela -->
      <div class="bg-white rounded-2xl border border-slate-100 shadow-card overflow-hidden">

        <!-- Cabeçalho da tabela -->
        <div class="flex items-center justify-between px-5 py-3.5 border-b border-slate-100">
          <p class="text-sm font-semibold text-slate-800">
            Lista de Pedidos
            <span v-if="filtroStatus" class="ml-2 text-xs font-normal text-slate-400">
              filtrando por <span class="font-semibold text-slate-600">{{ statusCfg[filtroStatus]?.label }}</span>
            </span>
          </p>
          <p class="text-xs text-slate-400">
            <span class="font-semibold text-slate-600">{{ viagensFiltradas.length }}</span> registros
          </p>
        </div>

        <!-- Loading skeleton -->
        <div v-if="store.carregando">
          <div
            v-for="i in 6" :key="i"
            class="flex items-center gap-4 px-5 py-4 border-b border-slate-50 animate-pulse"
          >
            <div class="h-3 bg-slate-100 rounded w-20" />
            <div class="h-3 bg-slate-100 rounded w-32" />
            <div class="h-3 bg-slate-100 rounded w-28 hidden sm:block" />
            <div class="h-3 bg-slate-100 rounded w-24 hidden md:block" />
            <div class="h-3 bg-slate-100 rounded w-24 hidden md:block" />
            <div class="h-5 bg-slate-100 rounded-full w-20 ml-auto" />
          </div>
        </div>

        <!-- Erro -->
        <div v-else-if="store.erro" class="px-5 py-12 text-center">
          <p class="text-sm text-red-500 font-medium">{{ store.erro }}</p>
          <button class="btn-secondary mt-3 text-xs" @click="store.carregar()">Tentar novamente</button>
        </div>

        <!-- Vazio -->
        <div v-else-if="viagensFiltradas.length === 0" class="px-5 py-14 text-center">
          <svg class="w-10 h-10 mx-auto mb-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3"/>
          </svg>
          <p class="text-sm font-medium text-slate-500">Nenhum pedido encontrado</p>
          <button class="btn-primary mt-4 text-sm" @click="modalNova = true">Criar primeiro pedido</button>
        </div>

        <!-- Tabela de dados -->
        <div v-else class="overflow-x-auto">
          <table class="w-full text-sm min-w-[640px]">
            <thead>
              <tr class="bg-slate-50 border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                <th class="text-left px-5 py-3">ID / Solicitante</th>
                <th class="text-left px-5 py-3">Origem</th>
                <th class="text-left px-5 py-3">Destino</th>
                <th class="text-left px-5 py-3">Data Ida</th>
                <th class="text-left px-5 py-3">Data Volta</th>
                <th class="text-center px-5 py-3">Status</th>
                <th class="text-center px-5 py-3 w-20">Ver</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="viagem in viagensFiltradas"
                :key="viagem.id"
                class="trow cursor-pointer"
                @click="viagemAtiva = viagem"
              >


                <!-- Solicitante -->
                <td class="px-5 py-3.5">
                  <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-full bg-sky-100 flex items-center justify-center text-sky-700 text-[10px] font-bold flex-shrink-0">
                      {{ viagem.solicitante.slice(0, 2).toUpperCase() }}
                    </div>

                    <div class="flex flex-col"> 
                      <span class="font-medium text-slate-700 truncate max-w-[140px] leading-tight">
                        {{ viagem.solicitante }}
                      </span>
                      <span class="font-mono text-[12px] font-semibold text-slate-400 leading-tight">
                        #VGM-{{ String(viagem.id).padStart(4, '0') }}
                      </span>
                    </div>
                  </div>
                </td>

                <!-- Origem -->
                <td class="px-5 py-3.5 text-slate-600">{{ viagem.origem }}</td>

                <!-- Destino -->
                <td class="px-5 py-3.5">
                  <div class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-sky-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                      <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                    </svg>
                    <span class="font-medium text-slate-700">{{ viagem.destino }}</span>
                  </div>
                </td>

                <!-- Data Ida -->
                <td class="px-5 py-3.5 text-slate-500 text-xs">{{ fmtData(viagem.data_ida) }}</td>

                <!-- Data Volta -->
                <td class="px-5 py-3.5 text-slate-500 text-xs">{{ fmtData(viagem.data_volta) }}</td>

                <!-- Status -->
                <td class="px-5 py-3.5 text-center">
                  <span :class="['inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold', statusCfg[viagem.status]?.cls]">
                    <span :class="['w-1.5 h-1.5 rounded-full', statusCfg[viagem.status]?.dot]" />
                    {{ statusCfg[viagem.status]?.label }}
                  </span>
                </td>

                <!-- Ação -->
                <td class="px-5 py-3.5">
                  <div class="flex items-center justify-center gap-x-2">
                    
                    <button @click.stop="viagemAtiva = viagem" class=" w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center
                            text-sky-500 hover:border-sky-400 hover:text-sky-500 hover:bg-sky-50 transition-all"
                      title="Ver detalhes"
                    >
                      <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                      </svg>
                    </button>

                    <button 
                      type="button"
                      :title="viagem.enabled === 0 ? 'Registro desabilitado' : (viagem.status === 'aprovado' ? 'Não é possível cancelar viagens aprovadas' : 'Remover')"
                      @click.stop="viagemCancelar = viagem" 
                      :disabled="viagem.status === 'aprovado' || viagem.enabled === 0"
                      class="w-7 h-7 rounded-lg border flex items-center justify-center transition-all"
                      :class="[ 
                        (viagem.status === 'aprovado' || viagem.status === 'cancelado')
                          ? 'bg-slate-50 border-slate-100 text-slate-300 cursor-not-allowed opacity-60' 
                          : 'border-slate-200 bg-white text-red-500 hover:border-red-400 hover:bg-red-50'
                      ]"
                    >
                      <svg v-if="viagem.status === 'aprovado' || viagem.status === 'cancelado'" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                      </svg>

                      <svg v-else class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path d="M6 18L18 6M6 6l12 12"></path>
                      </svg>
                    </button>

                  </div>
                </td>

              </tr>
            </tbody>
          </table>
        </div>

        <!-- Paginação -->
        <div
          v-if="!store.carregando && store.paginacao && store.paginacao.last_page > 1"
          class="flex items-center justify-between px-5 py-3.5 border-t border-slate-100 bg-slate-50/60"
        >
          <p class="text-xs text-slate-400">
            Página <span class="font-semibold text-slate-600">{{ store.paginacao.current_page }}</span>
            de <span class="font-semibold text-slate-600">{{ store.paginacao.last_page }}</span>
            · <span class="font-semibold text-slate-600">{{ store.paginacao.total }}</span> registros
          </p>
          <div class="flex gap-1">
            <button
              class="w-8 h-8 rounded-lg border border-slate-200 bg-white text-xs font-semibold text-slate-500
                     hover:bg-slate-50 disabled:opacity-40 disabled:cursor-not-allowed transition-colors"
              :disabled="store.paginacao.current_page === 1"
              @click="trocarPagina(store.paginacao!.current_page - 1)"
            >←</button>

            <button
              v-for="p in store.paginacao.last_page"
              :key="p"
              :class="[
                'w-8 h-8 rounded-lg border text-xs font-semibold transition-colors',
                p === store.paginacao.current_page
                  ? 'bg-sky-500 border-sky-500 text-white'
                  : 'border-slate-200 bg-white text-slate-500 hover:bg-slate-50'
              ]"
              @click="trocarPagina(p)"
            >{{ p }}</button>

            <button
              class="w-8 h-8 rounded-lg border border-slate-200 bg-white text-xs font-semibold text-slate-500
                     hover:bg-slate-50 disabled:opacity-40 disabled:cursor-not-allowed transition-colors"
              :disabled="store.paginacao.current_page === store.paginacao.last_page"
              @click="trocarPagina(store.paginacao!.current_page + 1)"
            >→</button>
          </div>
        </div>
      </div>
    </main>
  </div>

  <!-- Modal: Nova Viagem -->
  <NovaViagemModal
    v-if="modalNova"
    @fechar="modalNova = false"
  />

 <ViagemDetalheModal
  v-if="viagemAtiva"
  :viagem="viagemAtiva"
  @fechar="viagemAtiva = null"
/>

  <CancelarViagemModal 
  v-if="viagemCancelar"
  :viagem="viagemCancelar" 
  @fechar="viagemCancelar = null" 
  @confirmado="store.carregar()" 
/>

</template>