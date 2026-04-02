import { ref } from 'vue';
const toasts = ref([]);
export function useToast() {
    function show(message, type = 'success', ms = 3500) {
        const id = crypto.randomUUID();
        toasts.value.push({ id, message, type });
        setTimeout(() => { toasts.value = toasts.value.filter(t => t.id !== id); }, ms);
    }
    return {
        toasts,
        success: (m) => show(m, 'success'),
        error: (m) => show(m, 'error'),
        warning: (m) => show(m, 'warning'),
    };
}
