<!-- ════════════════════════════════
     SIDEBAR
════════════════════════════════ -->
<aside class="w-60 flex-shrink-0 bg-slate-900 flex flex-col shadow-sidebar">

  <!-- Logo -->
  <div class="flex items-center gap-3 px-5 py-5 border-b border-slate-800">
    <div class="w-9 h-9 rounded-xl bg-sky-500 flex items-center justify-center flex-shrink-0 shadow-lg">
      <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/>
      </svg>
    </div>
    <div>
      <p class="text-sm font-bold text-white leading-tight">Travel Desk</p>
      <p class="text-[10px] text-slate-500">Gestão de Viagens</p>
    </div>
  </div>

  <!-- Nav -->
  <nav class="flex-1 overflow-y-auto py-3 px-2.5 space-y-0.5">

    <p class="text-[9.5px] font-bold text-slate-600 uppercase tracking-widest px-3 pt-2 pb-1.5">Principal</p>

        <a class="nav-link flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm font-medium transition-all cursor-pointer 
        {{ request()->routeIs('admin.dashboard') ? 'bg-slate-800 text-white active' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}" 
        href="{{ route('admin.dashboard') }}">
            <svg class="nav-icon w-4 h-4 {{ request()->routeIs('admin.dashboard') ? 'text-sky-500' : 'text-slate-500' }}" ...>
                </svg>
            Dashboard
        </a>

        <a class="nav-link flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm font-medium transition-all cursor-pointer 
        {{ request()->routeIs('viagens.*') ? 'bg-slate-800 text-white active' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}" 
        href="{{ route('viagens.index') }}">
            <svg class="nav-icon w-4 h-4 {{ request()->routeIs('viagens.*') ? 'text-sky-500' : 'text-slate-500' }}" ...>
                </svg>
            Viagens
        </a>

  </nav>

  <!-- User -->
  <div class="border-t border-slate-800 p-4">
    <div class="flex items-center gap-2.5">
      <div class="relative">
        <div class="w-8 h-8 rounded-full bg-sky-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">AU</div>
        <span class="absolute bottom-0 right-0 w-2 h-2 bg-emerald-400 rounded-full ring-2 ring-slate-900 pulse"></span>
      </div>
      <div class="flex-1 min-w-0">
        <p class="text-xs font-semibold text-white truncate">Admin User</p>
        <p class="text-[10px] text-slate-500 truncate">admin@empresa.com.br</p>
      </div>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="text-slate-600 hover:text-slate-300 transition-colors">
          <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/></svg>
        </button>
      </form>
    </div>
  </div>
</aside>