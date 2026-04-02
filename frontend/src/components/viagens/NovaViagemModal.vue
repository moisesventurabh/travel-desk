<script setup lang="ts">
import { reactive, ref, computed } from 'vue'
import { useViagemStore } from '@/stores/viagens'
import { useAuthStore }   from '@/stores/auth'
import { useToast }       from '@/composables/useToast'
import type { NovaViagemPayload } from '@/types'

const emit = defineEmits<{ fechar: [] }>()

const store = useViagemStore()
const auth  = useAuthStore()
const toast = useToast()

const form = reactive<NovaViagemPayload>({
  solicitante: auth.user?.name ?? '',
  origem:      '',
  destino:     '',
  data_ida:    '',
  data_volta:  '',
})

const erros = reactive<Partial<Record<keyof NovaViagemPayload, string>>>({})

const hoje = new Date().toISOString().split('T')[0]!

const duracaoDias = computed(() => {
  if (!form.data_ida || !form.data_volta) return 0
  const d = new Date(form.data_volta).getTime() - new Date(form.data_ida).getTime()
  return Math.max(0, Math.ceil(d / 86_400_000))
})

function validar() {
  Object.keys(erros).forEach(k => delete erros[k as keyof NovaViagemPayload])
  if (!form.solicitante.trim()) erros.solicitante = 'Obrigatório.'
  if (!form.origem.trim())      erros.origem      = 'Obrigatório.'
  if (!form.destino.trim())     erros.destino     = 'Obrigatório.'
  if (!form.data_ida)           erros.data_ida    = 'Obrigatório.'
  if (!form.data_volta)         erros.data_volta  = 'Obrigatório.'
  else if (form.data_volta < form.data_ida) erros.data_volta = 'Deve ser após a ida.'
  return Object.keys(erros).length === 0
}

async function submeter() {
  if (!validar()) return
  try {
    await store.criar({ ...form })
    toast.success('Pedido criado com sucesso!')
    emit('fechar')
  } catch {
    toast.error('Erro ao criar pedido. Tente novamente.')
  }
}
</script>

<template>
  <Teleport to="body">
    <div
      class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
      @click.self="emit('fechar')"
    >
      <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg animate-fade-up">

        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
          <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-brand-500 flex items-center justify-center">
              <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
              </svg>
            </div>
            <h2 class="text-base font-bold text-slate-900">Nova Viagem</h2>
          </div>
          <button
            class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-colors"
            @click="emit('fechar')"
          >
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>

        <!-- Body -->
        <form class="px-6 py-5 space-y-4" novalidate @submit.prevent="submeter">

          <!-- Solicitante -->
          <div>
            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">
              Solicitante
            </label>
            <input
              v-model="form.solicitante"
              type="text"
              placeholder="Nome do solicitante"
              class="input-base"
              :class="{ 'border-red-400 focus:border-red-400': erros.solicitante }"
            />
            <p v-if="erros.solicitante" class="text-xs text-red-500 mt-1">{{ erros.solicitante }}</p>
          </div>

          <!-- Origem / Destino -->
          <div class="grid grid-cols-2 gap-3">
            <div>
              <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">
                Origem
              </label>
              <select 
                v-model="form.origem"
                class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-sky-500 outline-none bg-white text-sm text-slate-700"
                required
              >
                <option value="" disabled selected>Selecione a origem</option>
                <option value="Belo Horizonte">Belo Horizonte</option>
                <option value="São Paulo">São Paulo</option>
                <option value="Rio de Janeiro">Rio de Janeiro</option>
                <option value="Brasília">Brasília</option>
                <option value="Curitiba">Curitiba</option>
              </select>
            </div>

            <div>
              <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">
                Destino
              </label>
              <select 
                v-model="form.destino"
                class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-sky-500 outline-none bg-white text-sm text-slate-700"
                required
              >
                <option value="" disabled selected>Selecione o destino</option>
                <option value="Belo Horizonte">Belo Horizonte</option>
                <option value="São Paulo">São Paulo</option>
                <option value="Rio de Janeiro">Rio de Janeiro</option>
                <option value="Brasília">Brasília</option>
                <option value="Curitiba">Curitiba</option>
              </select>
            </div>
          </div>

          <!-- Datas -->
          <div class="grid grid-cols-2 gap-3">
            <div>
              <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">
                Data de Ida
              </label>
              <input
                v-model="form.data_ida"
                type="date"
                :min="hoje"
                class="input-base"
                :class="{ 'border-red-400': erros.data_ida }"
              />
              <p v-if="erros.data_ida" class="text-xs text-red-500 mt-1">{{ erros.data_ida }}</p>
            </div>
            <div>
              <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">
                Data de Volta
              </label>
              <input
                v-model="form.data_volta"
                type="date"
                :min="form.data_ida || hoje"
                class="input-base"
                :class="{ 'border-red-400': erros.data_volta }"
              />
              <p v-if="erros.data_volta" class="text-xs text-red-500 mt-1">{{ erros.data_volta }}</p>
            </div>
          </div>

          <!-- Duração calculada -->
          <div v-if="duracaoDias > 0" class="flex items-center gap-2 text-xs text-brand-600 font-medium">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ duracaoDias }} dia{{ duracaoDias > 1 ? 's' : '' }} de viagem
          </div>

          <!-- Ações -->
          <div class="flex gap-2.5 pt-2">
            <button
              type="button"
              class="btn-secondary flex-1 justify-center"
              @click="emit('fechar')"
            >
              Cancelar
            </button>
            <button
              type="submit"
              :disabled="store.enviando"
              class="btn-primary flex-1 justify-center"
            >
              <svg v-if="store.enviando" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
              </svg>
              {{ store.enviando ? 'Salvando...' : 'Criar Pedido' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </Teleport>
</template>
