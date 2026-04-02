<script setup lang="ts">
import { ref } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useViagemStore } from '@/stores/viagem'

const store  = useViagemStore()
const route  = useRoute()
const router = useRouter()

const submenuAberto = ref<Record<string, boolean>>({ viagens: true })

function toggleSubmenu(key: string) {
  submenuAberto.value[key] = !submenuAberto.value[key]
}

function isActive(name: string) {
  return route.name === name
}
</script>

<template>
  <aside class="w-60 flex-shrink-0 bg-slate-900 flex flex-col shadow-sidebar z-30">

    <!-- Logo -->
    <div class="flex items-center gap-3 px-5 py-5 border-b border-slate-800">
      <div class="w-9 h-9 rounded-xl bg-brand-500 flex items-center justify-center shadow-lg flex-shrink-0">
        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/>
        </svg>
      </div>
      <div>
        <p class="text-sm font-bold text-white leading-tight">Travel Desk</p>
        <p class="text-[10px] text-slate-500">Gestão de Viagens</p>
      </div>
    </div>

    <!-- Nav -->
    <nav class="flex-1 overflow-y-auto py-3 px-2.5 space-y-0.5">

      <p class="text-[9.5px] font-bold text-slate-600 uppercase tracking-widest px-3 pt-2 pb-1.5">
        Principal
      </p>

      <!-- Dashboard link -->
      <RouterLink
        to="/viagens"
        class="nav-item"
        :class="{ active: isActive('viagens') }"
      >
        <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/>
        </svg>
        Painel
      </RouterLink>

      <!-- Viagens submenu -->
      <div>
        <button
          class="nav-item w-full"
          :class="{ active: submenuAberto['viagens'] }"
          @click="toggleSubmenu('viagens')"
        >
          <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3"/>
          </svg>
          <span class="flex-1 text-left">Viagens</span>
          <svg
            class="w-3 h-3 text-slate-600 transition-transform duration-200"
            :class="{ 'rotate-90': submenuAberto['viagens'] }"
            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"
          >
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
          </svg>
        </button>

        <!-- Submenu items -->
        <Transition name="submenu">
          <div v-if="submenuAberto['viagens']" class="overflow-hidden">
            <RouterLink
              to="/viagens"
              class="sub-item"
              :class="{ active: isActive('viagens') }"
            >
              Todos os Pedidos
            </RouterLink>
            <RouterLink
              to="/viagens/nova"
              class="sub-item"
              :class="{ active: isActive('viagens-nova') }"
            >
              Novo Pedido
            </RouterLink>
          </div>
        </Transition>
      </div>

      <p class="text-[9.5px] font-bold text-slate-600 uppercase tracking-widest px-3 pt-4 pb-1.5">
        Sistema
      </p>

      <button class="nav-item w-full relative">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
        </svg>
        Notificações
        <span
          v-if="store.notificacoesNaoLidas > 0"
          class="ml-auto bg-brand-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded-full"
        >
          {{ store.notificacoesNaoLidas }}
        </span>
      </button>
    </nav>

    <!-- User -->
    <div class="border-t border-slate-800 p-4">
      <div class="flex items-center gap-2.5">
        <div class="relative flex-shrink-0">
          <div class="w-8 h-8 rounded-full bg-brand-500 flex items-center justify-center text-white text-xs font-bold">
            AU
          </div>
          <span class="absolute bottom-0 right-0 w-2 h-2 bg-emerald-400 rounded-full ring-2 ring-slate-900 animate-pulse-dot"/>
        </div>
        <div class="flex-1 min-w-0">
          <p class="text-xs font-semibold text-white truncate">Admin User</p>
          <p class="text-[10px] text-slate-500 truncate">admin@empresa.com.br</p>
        </div>
        <button class="text-slate-600 hover:text-slate-300 transition-colors">
          <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
          </svg>
        </button>
      </div>
    </div>
  </aside>
</template>

<style scoped>
.submenu-enter-active,
.submenu-leave-active {
  transition: max-height 0.26s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.2s ease;
  max-height: 200px;
  overflow: hidden;
}
.submenu-enter-from,
.submenu-leave-to {
  max-height: 0;
  opacity: 0;
}
</style>
