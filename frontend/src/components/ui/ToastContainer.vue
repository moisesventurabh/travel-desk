<script setup lang="ts">
import { useToast } from '@/composables/useToast'
const { toasts } = useToast()
const bg: Record<string, string> = {
  success: 'bg-emerald-600',
  error:   'bg-red-600',
  warning: 'bg-amber-500',
}
</script>

<template>
  <Teleport to="body">
    <div class="fixed top-4 right-4 z-[200] flex flex-col gap-2 pointer-events-none">
      <TransitionGroup name="toast">
        <div
          v-for="t in toasts" :key="t.id"
          :class="['pointer-events-auto flex items-center gap-2.5 px-4 py-3 rounded-xl text-white text-sm font-semibold shadow-xl min-w-[240px]', bg[t.type]]"
        >
          {{ t.message }}
        </div>
      </TransitionGroup>
    </div>
  </Teleport>
</template>

<style scoped>
.toast-enter-active { transition: all .25s ease; }
.toast-leave-active { transition: all .2s ease; }
.toast-enter-from, .toast-leave-to { opacity: 0; transform: translateX(32px); }
</style>
