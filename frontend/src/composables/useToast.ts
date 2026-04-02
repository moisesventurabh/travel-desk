import { ref } from 'vue'

export type ToastType = 'success' | 'error' | 'warning'
interface Toast { id: string; message: string; type: ToastType }
const toasts = ref<Toast[]>([])

export function useToast() {
  function show(message: string, type: ToastType = 'success', ms = 3500) {
    const id = crypto.randomUUID()
    toasts.value.push({ id, message, type })
    setTimeout(() => { toasts.value = toasts.value.filter(t => t.id !== id) }, ms)
  }
  return {
    toasts,
    success: (m: string) => show(m, 'success'),
    error:   (m: string) => show(m, 'error'),
    warning: (m: string) => show(m, 'warning'),
  }
}
