 <!-- TOPBAR -->
  <header class="h-14 bg-white border-b border-slate-200 flex items-center px-6 gap-4 flex-shrink-0 z-20">
    <div class="ml-auto flex items-center gap-2">
      <button class="relative p-2 rounded-lg text-slate-500 hover:bg-slate-100 transition-colors" onclick="goto('notificacoes')">
        <svg class="w-4.5 h-4.5 w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
        <span class="absolute top-1.5 right-1.5 w-1.5 h-1.5 bg-red-500 rounded-full ring-2 ring-white"></span>
      </button>
      <div class="w-7 h-7 rounded-full bg-sky-500 flex items-center justify-center text-white text-[11px] font-bold cursor-pointer">AU</div>
    </div>
  </header>

  <!-- BREADCRUMB -->
  <div id="breadcrumb" class="flex items-center gap-1.5 px-6 py-2.5 bg-white border-b border-slate-100 text-xs text-slate-500">
    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
    <span class="text-slate-300">/</span>
    <span id="bc-text" class="font-medium text-slate-700">Dashboard</span>
  </div>