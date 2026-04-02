<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import { useToast } from '@/composables/useToast'
import { onClickOutside } from '@vueuse/core'

const auth   = useAuthStore()
const router = useRouter()
const toast  = useToast()

const aberto   = ref(false)
const perfil   = ref(false)
const dropdown = ref<HTMLElement>()

onClickOutside(dropdown, () => { aberto.value = false; perfil.value = false })

async function sair() {
  await auth.logout()
  toast.success('Até logo!')
  router.push('/login')
}
</script>

<template>
  <div class="relative" ref="dropdown">

    <!-- Avatar botão -->
    <button
      class="flex items-center gap-2 pl-2 pr-3 py-1.5 rounded-xl hover:bg-slate-100 transition-colors"
      @click="aberto = !aberto; perfil = false"
    >
      <div class="w-7 h-7 rounded-full bg-brand-500 flex items-center justify-center text-white text-[11px] font-bold">
        {{ auth.user?.name.slice(0,2).toUpperCase() ?? 'U' }}
      </div>
      <span class="text-sm font-medium text-slate-700 hidden sm:block">{{ auth.user?.name }}</span>
      <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
      </svg>
    </button>

    <!-- Dropdown -->
    <Transition name="drop">
      <div
        v-if="aberto"
        class="absolute right-0 top-full mt-2 w-64 bg-white rounded-2xl border border-slate-100 shadow-xl z-50 overflow-hidden"
      >
        <!-- Header usuário -->
        <div class="px-4 py-3.5 border-b border-slate-100">
          <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-brand-500 flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
              {{ auth.user?.name.slice(0,2).toUpperCase() ?? 'U' }}
            </div>
            <div class="min-w-0">
              <p class="text-sm font-semibold text-slate-900 truncate">{{ auth.user?.name }}</p>
              <p class="text-xs text-slate-400 truncate">{{ auth.user?.email }}</p>
            </div>
          </div>
          <span class="inline-flex mt-2 text-[10px] font-bold px-2 py-0.5 rounded-full bg-brand-50 text-brand-700 uppercase">
            {{ auth.user?.role }}
          </span>
        </div>

        <!-- Meus dados expandido -->
        <Transition name="slide">
          <div v-if="perfil" class="px-4 py-3 border-b border-slate-100 bg-slate-50/60 text-xs space-y-2">
            <div class="flex justify-between">
              <span class="text-slate-500">Nome</span>
              <span class="font-semibold text-slate-800">{{ auth.user?.name }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-slate-500">E-mail</span>
              <span class="font-semibold text-slate-800 truncate max-w-[140px]">{{ auth.user?.email }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-slate-500">Função</span>
              <span class="font-semibold text-slate-800 capitalize">{{ auth.user?.role }}</span>
            </div>
          </div>
        </Transition>

        <!-- Ações -->
        <div class="p-2">
          <button
            class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm text-slate-600 hover:bg-slate-100 transition-colors text-left"
            @click="perfil = !perfil"
          >
            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
            </svg>
            Meus Dados
            <svg
              class="w-3.5 h-3.5 ml-auto text-slate-400 transition-transform"
              :class="{ 'rotate-180': perfil }"
              fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
            >
              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
            </svg>
          </button>

          <button
            class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm text-red-600 hover:bg-red-50 transition-colors text-left"
            @click="sair"
          >
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
            </svg>
            Sair
          </button>
        </div>
      </div>
    </Transition>
  </div>
</template>

<style scoped>
.drop-enter-active, .drop-leave-active { transition: opacity .15s ease, transform .15s ease; }
.drop-enter-from, .drop-leave-to       { opacity: 0; transform: translateY(-6px); }
.slide-enter-active, .slide-leave-active { transition: all .2s ease; max-height: 200px; overflow: hidden; }
.slide-enter-from, .slide-leave-to      { max-height: 0; opacity: 0; }
</style>
