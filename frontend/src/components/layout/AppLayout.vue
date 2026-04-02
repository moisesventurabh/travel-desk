<script setup lang="ts">
import { ref, computed } from 'vue'
import { useRoute } from 'vue-router'
import { useViagemStore } from '@/stores/viagem'
import AppSidebar from './AppSidebar.vue'
import AppTopbar from './AppTopbar.vue'

const store = useViagemStore()
const route = useRoute()

const breadcrumb = computed(() => route.meta.breadcrumb as string ?? '')
</script>

<template>
  <div class="flex h-screen overflow-hidden bg-slate-50">
    <!-- Sidebar -->
    <AppSidebar />

    <!-- Main -->
    <div class="flex-1 flex flex-col overflow-hidden min-w-0">
      <!-- Topbar -->
      <AppTopbar />

      <!-- Breadcrumb -->
      <div class="flex items-center gap-1.5 px-6 py-2.5 bg-white border-b border-slate-100 text-xs text-slate-500 flex-shrink-0">
        <svg class="w-3 h-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
        </svg>
        <span class="text-slate-300">/</span>
        <RouterLink to="/viagens" class="hover:text-brand-500 transition-colors">Viagens</RouterLink>
        <template v-if="breadcrumb && breadcrumb !== 'Viagens'">
          <span class="text-slate-300">/</span>
          <span class="font-medium text-slate-700">{{ breadcrumb }}</span>
        </template>
      </div>

      <!-- Page content -->
      <main class="flex-1 overflow-y-auto p-6">
        <RouterView v-slot="{ Component }">
          <Transition name="page" mode="out-in">
            <component :is="Component" />
          </Transition>
        </RouterView>
      </main>
    </div>
  </div>
</template>

<style scoped>
.page-enter-active,
.page-leave-active {
  transition: opacity 0.18s ease, transform 0.18s ease;
}
.page-enter-from {
  opacity: 0;
  transform: translateY(6px);
}
.page-leave-to {
  opacity: 0;
  transform: translateY(-4px);
}
</style>
