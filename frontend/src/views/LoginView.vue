<script setup lang="ts">
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import { useToast } from '@/composables/useToast'

const auth   = useAuthStore()
const router = useRouter()
const toast  = useToast()

const form = reactive({ email: '', password: '' })
const senhaVisivel = ref(false)
const carregando   = ref(false)
const erro         = ref('')

async function entrar() {
  erro.value = ''
  if (!form.email || !form.password) { erro.value = 'Preencha todos os campos.'; return }
  carregando.value = true
  try {
    console.log('Tentando login com:', form);
    await auth.login(form)
    toast.success(`Bem-vindo, ${auth.user?.name}!`)
    router.push('/')
  } catch {
    erro.value = 'E-mail ou senha incorretos.'
  } finally {
    carregando.value = false
  }
}
</script>
<template>
  <div class="min-h-screen flex bg-slate-50">

    <div class="hidden lg:flex w-[44%] bg-slate-900 flex-col px-10 py-10 relative overflow-hidden">
      <div class="absolute inset-0 pointer-events-none opacity-40"
        style="background-image:linear-gradient(rgba(255,255,255,.03) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.03) 1px,transparent 1px);background-size:40px 40px"/>

      <div class="flex items-center gap-3 relative z-10">
        <div class="w-9 h-9 rounded-xl bg-sky-500 flex items-center justify-center shadow-lg">
          <svg class="w-[18px] h-[18px] text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/>
          </svg>
        </div>
        <div>
          <p class="text-sm font-bold text-white">Travel Desk</p>
          <p class="text-[10px] text-slate-500">Gestão de Viagens</p>
        </div>
      </div>

      <div class="flex-1 flex flex-col justify-center relative z-10">
        <h2 class="text-2xl font-extrabold text-white leading-tight mb-3 tracking-tight">
          Controle total das<br>suas viagens corporativas
        </h2>
        <p class="text-sm text-slate-500 leading-relaxed max-w-[240px]">
          Gerencie pedidos, aprovações e notificações em um só lugar.
        </p>
        <div class="grid grid-cols-3 gap-2.5 mt-8">
          <div class="bg-white/[.04] border border-white/[.07] rounded-xl p-3">
            <p class="text-xl font-extrabold text-sky-400">48</p>
            <p class="text-[10px] text-slate-500 mt-0.5 font-medium">Pedidos ativos</p>
          </div>
          <div class="bg-white/[.04] border border-white/[.07] rounded-xl p-3">
            <p class="text-xl font-extrabold text-white">12</p>
            <p class="text-[10px] text-slate-500 mt-0.5 font-medium">Pendentes</p>
          </div>
          <div class="bg-white/[.04] border border-white/[.07] rounded-xl p-3">
            <p class="text-xl font-extrabold text-white">29</p>
            <p class="text-[10px] text-slate-500 mt-0.5 font-medium">Aprovados</p>
          </div>
        </div>
      </div>

      <p class="text-[10px] text-slate-700 relative z-10">© 2026 Travel Desk</p>
    </div>

    <div class="flex-1 flex items-center justify-center px-6 py-10">
      <div class="w-full max-w-sm">

        <div class="flex items-center gap-2.5 mb-8 lg:hidden">
          <div class="w-8 h-8 rounded-lg bg-sky-500 flex items-center justify-center">
            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/>
            </svg>
          </div>
          <p class="text-sm font-bold text-slate-900">Travel Desk</p>
        </div>

        <div class="mb-7">
          <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Bem-vindo de volta</h1>
          <p class="text-sm text-slate-500 mt-1">Entre com suas credenciais para acessar o painel</p>
        </div>

        <Transition name="fade">
          <div v-if="erro" class="flex items-center gap-2 px-3.5 py-3 mb-5 rounded-xl text-sm bg-red-50 text-red-700 border border-red-200">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
            </svg>
            {{ erro }}
          </div>
        </Transition>

        <form class="space-y-4" novalidate @submit.prevent="entrar">
          <div>
            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">E-mail</label>
            <div class="relative">
              <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
              </svg>
              <input  v-model="form.email" type="email" placeholder="seu@email.com.br" autocomplete="email" class="input-base pl-9"/>
            </div>
          </div>

          <div>
            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Senha</label>
            <div class="relative">
              <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
              </svg>
              <input v-model="form.password" :type="senhaVisivel ? 'text' : 'password'" placeholder="••••••••" autocomplete="current-password" class="input-base pl-9 pr-10"/>
              <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors" @click="senhaVisivel = !senhaVisivel">
                <svg v-if="senhaVisivel" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                </svg>
                <svg v-else class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
              </button>
            </div>
          </div>

          <button type="submit" :disabled="carregando" class="btn-primary w-full justify-center py-3 text-sm mt-2">
            <svg v-if="carregando" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
            </svg>
            <svg v-else class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
            </svg>
            {{ carregando ? 'Entrando...' : 'Entrar no painel' }}
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<style scoped>
.fade-enter-active,.fade-leave-active{transition:opacity .2s ease,transform .2s ease;}
.fade-enter-from,.fade-leave-to{opacity:0;transform:translateY(-4px);}
</style>
