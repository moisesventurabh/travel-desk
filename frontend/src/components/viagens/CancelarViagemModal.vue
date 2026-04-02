<script setup lang="ts">
import { useViagemStore } from '@/stores/viagens'
import { useToast }       from '@/composables/useToast'
import type { Viagem }    from '@/types'

const props = defineProps<{ 
  viagem: Viagem | null 
}>()

const emit = defineEmits<{ 
  fechar: [], 
  confirmado: [id: number] 
}>()

const store = useViagemStore()
const toast = useToast()

async function confirmar() {
  if (!props.viagem) return

  try {
    console.log(props.viagem.id);
    // Agora chamamos o método de deletar/remover
    await store.removerViagem(props.viagem.id)
    
    toast.success(`Viagem removida com sucesso.`)
    emit('confirmado', props.viagem.id)
    emit('fechar')
  } catch (error) {
    toast.error('Erro ao remover a viagem.')
  }
}
</script>

<template>
  <Transition name="fade">
    <div v-if="viagem" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
      <div class="bg-white rounded-[28px] p-7 max-w-sm w-full shadow-2xl border border-slate-100 animate-scale-in">
        
        <div class="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center mb-5">
          <svg class="w-7 h-7 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
          </svg>
        </div>

        <h3 class="text-xl font-bold text-slate-900 leading-tight">
          Confirmar cancelamento?
        </h3>
        
        <p class="text-sm text-slate-500 mt-3 leading-relaxed">
          Você está prestes a cancelar sua viagem de <span class="font-semibold text-slate-800">{{ viagem.solicitante }}</span> saindo de  <span class="font-semibold text-slate-800">{{ viagem.origem }}</span> para <span class="font-semibold text-slate-800">{{ viagem.destino }}</span>. 
          <br><br>
          Esta ação não poderá ser revertida.
        </p>

        <div class="flex gap-3 mt-8">
          <button
            type="button"
            class="flex-1 px-4 py-3 text-sm font-bold text-slate-500 bg-slate-100 rounded-xl hover:bg-slate-200 transition-all"
            @click="emit('fechar')"
          >
            Voltar
          </button>
          
          <button
            type="button"
            :disabled="store.enviando"
            class="flex-1 px-4 py-3 text-sm font-bold text-white bg-red-500 rounded-xl hover:bg-red-600 shadow-lg shadow-red-200 disabled:opacity-50 transition-all flex items-center justify-center gap-2"
            @click="confirmar"
          >
            <svg v-if="store.enviando" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12\" cy="12" r="10" stroke="currentColor" stroke-width="4" />
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
            </svg>
            Sim, cancelar
          </button>
        </div>
      </div>
    </div>
  </Transition>
</template>

<style scoped>
.fade-enter-active, .fade-leave-active { transition: opacity 0.3s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }

.animate-scale-in {
  animation: scaleIn 0.2s ease-out;
}

@keyframes scaleIn {
  from { transform: scale(0.95); opacity: 0; }
  to { transform: scale(1); opacity: 1; }
}
</style>

