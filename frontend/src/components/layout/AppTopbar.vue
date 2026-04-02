<script setup lang="ts">
import { useViagemStore } from '@/stores/viagem'
import { useRouter } from 'vue-router'

const store  = useViagemStore()
const router = useRouter()
</script>

<template>
  <header class="h-14 bg-white border-b border-slate-200 flex items-center px-6 gap-4 flex-shrink-0 z-20">

    <!-- Search -->
    <div class="flex-1 max-w-sm relative">
      <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400 pointer-events-none"
        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
      </svg>
      <input
        type="search"
        placeholder="Buscar pedidos, destinos..."
        class="w-full pl-8 pr-3 py-1.5 text-sm bg-slate-50 border border-slate-200 rounded-lg
               focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-400 transition-all"
        @input="(e) => store.aplicarFiltros({ busca: (e.target as HTMLInputElement).value })"
      />
    </div>

    <!-- Actions -->
    <div class="ml-auto flex items-center gap-2">

      <!-- Novo pedido shortcut -->
      <RouterLink
        to="/viagens/nova"
        class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold
               bg-brand-50 text-brand-600 hover:bg-brand-100 rounded-lg transition-colors"
      >
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        Novo Pedido
      </RouterLink>

      <!-- Notificações -->
      <button class="relative p-2 rounded-lg text-slate-500 hover:bg-slate-100 transition-colors">
        <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
        </svg>
        <span
          v-if="store.notificacoesNaoLidas > 0"
          class="absolute top-1.5 right-1.5 w-1.5 h-1.5 bg-red-500 rounded-full ring-2 ring-white"
        />
      </button>

      <!-- Avatar -->
      <div class="w-7 h-7 rounded-full bg-brand-500 flex items-center justify-center text-white text-[11px] font-bold cursor-pointer">
        AU
      </div>
    </div>
  </header>
</template>
