@extends('layouts.admin')

@section('content')
  <main class="flex-1 overflow-y-auto bg-slate-50 p-6">




    <!-- ══════════════════════════
         DASHBOARD
    ══════════════════════════ -->
    <div class="page active" id="page-dashboard">
      
      <div class="flex items-start justify-between mb-6">
        <div>
          <h1 class="text-xl font-bold text-slate-900">Dashboard</h1>
          <p class="text-sm text-slate-500 mt-0.5">Visão geral dos pedidos de viagem</p>
        </div>
      </div>

      <!-- Stats -->
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        
        <div class="stat-card bg-white rounded-2xl border border-slate-100 p-5 shadow-card">
          <div class="flex items-start justify-between">
            <div>
              <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total de Pedidos</p>
              <p class="text-3xl font-extrabold text-slate-900 mt-1.5">{{ $stats['total'] }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-sky-50 flex items-center justify-center">
              <svg class="w-5 h-5 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253"/></svg>
            </div>
          </div>
        </div>

        <div class="stat-card bg-white rounded-2xl border border-slate-100 p-5 shadow-card">
          <div class="flex items-start justify-between">
            <div>
              <p class="text-[10px] font-bold text-amber-500 uppercase tracking-wider">Solicitados</p>
              <p class="text-3xl font-extrabold text-slate-900 mt-1.5">{{ $stats['solicitados'] }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
              <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
          </div>
        </div>

        <div class="stat-card bg-white rounded-2xl border border-slate-100 p-5 shadow-card">
          <div class="flex items-start justify-between">
            <div>
              <p class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider">Aprovados</p>
              <p class="text-3xl font-extrabold text-slate-900 mt-1.5">{{ $stats['aprovados'] }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center">
              <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
          </div>
        </div>

        <div class="stat-card bg-white rounded-2xl border border-slate-100 p-5 shadow-card">
          <div class="flex items-start justify-between">
            <div>
              <p class="text-[10px] font-bold text-red-500 uppercase tracking-wider">Cancelados</p>
              <p class="text-3xl font-extrabold text-slate-900 mt-1.5">{{ $stats['cancelados'] }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center">
              <svg class="w-5 h-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
          </div>
        </div>
      </div>

      <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-card overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
          <div>
            <p class="text-sm font-semibold text-slate-800">Pedidos Recentes</p>
            <p class="text-xs text-slate-400">Últimas solicitações</p>
          </div>
          <a href="{{ route('viagens.index') }}" class="text-xs font-semibold text-sky-600 hover:text-sky-700 transition-colors">Ver todos →</a>
        </div>
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                        <th class="text-left px-5 py-2.5">ID / Solicitante</th>
                        <th class="text-left px-5 py-3">Destino</th>
                        <th class="text-left px-5 py-3 hidden md:table-cell">Ida</th>
                        <th class="text-left px-5 py-3 hidden md:table-cell">Volta</th>
                        <th class="text-center px-5 py-3">Status</th>
                        <th class="text-center px-5 py-3">Ações</th>
                    </tr>
                </thead>
                <tbody id="pedidos-tbody">
                  @include('admin.viagens.list_users')
                </tbody>
            </table>




      </div>

    </div>

    <!-- ══════════════════════════
         LISTA DE PEDIDOS
    ══════════════════════════ -->
    <div class="page" id="page-pedidos">
      <div class="flex items-start justify-between mb-5">
        <div>
          <h1 class="text-xl font-bold text-slate-900">Pedidos de Viagem</h1>
          <p class="text-sm text-slate-500 mt-0.5">Gerencie todos os pedidos cadastrados</p>
        </div>
        <button onclick="goto('novo-pedido')" class="inline-flex items-center gap-2 px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white text-sm font-semibold rounded-xl shadow-sm transition-colors">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
          Novo Pedido
        </button>
      </div>

      <!-- Filtros -->
      <div class="bg-white rounded-2xl border border-slate-100 shadow-card p-4 mb-4">
        <div class="flex flex-wrap gap-3 items-end">
          <div class="flex-1 min-w-[200px]">
            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Buscar</label>
            <div class="relative">
              <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
              <input id="filter-search" type="text" placeholder="Solicitante ou destino..." oninput="applyFilters()" class="inp w-full pl-8 pr-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg transition-all">
            </div>
          </div>
          <div>
            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Status</label>
            <select id="filter-status" onchange="applyFilters()" class="inp py-2 pl-3 pr-8 text-sm bg-slate-50 border border-slate-200 rounded-lg transition-all cursor-pointer">
              <option value="">Todos</option>
              <option value="solicitado">Solicitado</option>
              <option value="aprovado">Aprovado</option>
              <option value="cancelado">Cancelado</option>
            </select>
          </div>
          <div>
            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Destino</label>
            <select id="filter-destino" onchange="applyFilters()" class="inp py-2 pl-3 pr-8 text-sm bg-slate-50 border border-slate-200 rounded-lg transition-all cursor-pointer">
              <option value="">Todos</option>
              <option>São Paulo</option><option>Rio de Janeiro</option><option>Brasília</option>
              <option>Salvador</option><option>Curitiba</option><option>Florianópolis</option>
              <option>Fortaleza</option><option>Porto Alegre</option>
            </select>
          </div>
          <div>
            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Data Início</label>
            <input id="filter-de" type="date" onchange="applyFilters()" class="inp py-2 px-3 text-sm bg-slate-50 border border-slate-200 rounded-lg transition-all">
          </div>
          <div>
            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Data Fim</label>
            <input id="filter-ate" type="date" onchange="applyFilters()" class="inp py-2 px-3 text-sm bg-slate-50 border border-slate-200 rounded-lg transition-all">
          </div>
          <button onclick="clearFilters()" class="py-2 px-3 text-sm text-slate-500 border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors">Limpar</button>
        </div>
      </div>

      <!-- Tabela -->
      <div class="bg-white rounded-2xl border border-slate-100 shadow-card overflow-hidden">
        <table class="w-full text-sm">
          <thead><tr class="bg-slate-50 border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
            <th class="text-left px-5 py-3">ID</th>
            <th class="text-left px-5 py-3">Solicitante</th>
            <th class="text-left px-5 py-3">Destino</th>
            <th class="text-left px-5 py-3 hidden md:table-cell">Ida</th>
            <th class="text-left px-5 py-3 hidden md:table-cell">Volta</th>
            <th class="text-center px-5 py-3">Status</th>
            <th class="text-center px-5 py-3">Ações</th>
          </tr></thead>
          <tbody id="pedidos-tbody"></tbody>
        </table>
        <div class="flex items-center justify-between px-5 py-3.5 border-t border-slate-100 bg-slate-50/60">
          <p class="text-xs text-slate-400"><span id="filtered-count" class="font-semibold text-slate-600">12</span> pedidos encontrados</p>
          <div class="flex gap-1" id="pagination"></div>
        </div>
      </div>
    </div>

    <!-- ══════════════════════════
         NOVO PEDIDO
    ══════════════════════════ -->
    <div class="page" id="page-novo-pedido">
      <div class="flex items-center gap-3 mb-6">
        <button onclick="goto('pedidos')" class="p-2 rounded-xl border border-slate-200 text-slate-500 hover:bg-slate-100 transition-colors">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        </button>
        <div>
          <h1 class="text-xl font-bold text-slate-900">Novo Pedido de Viagem</h1>
          <p class="text-sm text-slate-500">Preencha os dados da solicitação</p>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2 space-y-5">

          <!-- Dados do solicitante -->
          <div class="bg-white rounded-2xl border border-slate-100 shadow-card p-6">
            <h3 class="text-sm font-semibold text-slate-800 flex items-center gap-2 mb-5 pb-4 border-b border-slate-100">
              <svg class="w-4 h-4 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
              Dados do Solicitante
            </h3>
            <div class="grid grid-cols-2 gap-4">
              <div class="col-span-2">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Nome Completo *</label>
                <input id="np-nome" type="text" placeholder="Ex.: João da Silva" class="inp w-full px-3 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl transition-all" value="Admin User">
              </div>
              <div>
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Departamento</label>
                <select class="inp w-full px-3 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl transition-all">
                  <option>TI</option><option>Comercial</option><option>Financeiro</option>
                  <option>RH</option><option>Operações</option><option>Diretoria</option>
                </select>
              </div>
              <div>
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Matrícula</label>
                <input type="text" placeholder="EMP-0001" class="inp w-full px-3 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl transition-all">
              </div>
            </div>
          </div>

          <!-- Dados da viagem -->
          <div class="bg-white rounded-2xl border border-slate-100 shadow-card p-6">
            <h3 class="text-sm font-semibold text-slate-800 flex items-center gap-2 mb-5 pb-4 border-b border-slate-100">
              <svg class="w-4 h-4 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3"/></svg>
              Dados da Viagem
            </h3>
            <div class="grid grid-cols-2 gap-4">
              <div class="col-span-2">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Destino *</label>
                <select id="np-destino" class="inp w-full px-3 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl transition-all">
                  <option value="">Selecione o destino...</option>
                  <option>São Paulo – SP</option><option>Rio de Janeiro – RJ</option>
                  <option>Brasília – DF</option><option>Salvador – BA</option>
                  <option>Curitiba – PR</option><option>Florianópolis – SC</option>
                  <option>Fortaleza – CE</option><option>Porto Alegre – RS</option>
                  <option>Recife – PE</option><option>Manaus – AM</option>
                </select>
              </div>
              <div>
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Data de Ida *</label>
                <input id="np-ida" type="date" class="inp w-full px-3 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl transition-all">
              </div>
              <div>
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Data de Volta *</label>
                <input id="np-volta" type="date" class="inp w-full px-3 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl transition-all">
              </div>
              <div>
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Tipo de Transporte</label>
                <select class="inp w-full px-3 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl transition-all">
                  <option>Aéreo</option><option>Rodoviário</option><option>Veículo Próprio</option>
                </select>
              </div>
              <div>
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Hospedagem</label>
                <select class="inp w-full px-3 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl transition-all">
                  <option>Necessária</option><option>Não necessária</option><option>Já reservada</option>
                </select>
              </div>
              <div class="col-span-2">
                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Objetivo da Viagem *</label>
                <textarea id="np-objetivo" rows="3" placeholder="Descreva o motivo e objetivo da viagem..." class="inp w-full px-3 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl transition-all resize-none"></textarea>
              </div>
            </div>
          </div>

          <div class="flex gap-3 justify-end">
            <button onclick="goto('pedidos')" class="px-5 py-2.5 text-sm font-semibold text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-100 transition-colors">Cancelar</button>
            <button onclick="submitPedido()" class="px-6 py-2.5 text-sm font-semibold bg-sky-500 hover:bg-sky-600 text-white rounded-xl shadow-sm transition-colors inline-flex items-center gap-2">
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
              Enviar Pedido
            </button>
          </div>
        </div>

        <!-- Sidebar info -->
        <div class="space-y-5">
          <div class="bg-sky-50 border border-sky-200 rounded-2xl p-5">
            <div class="flex items-center gap-2 mb-3">
              <svg class="w-4 h-4 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
              <p class="text-sm font-semibold text-sky-800">Como funciona</p>
            </div>
            <ol class="space-y-2.5 text-xs text-sky-700">
              <li class="flex gap-2"><span class="w-4 h-4 rounded-full bg-sky-500 text-white flex items-center justify-center text-[9px] font-bold flex-shrink-0 mt-0.5">1</span>Preencha os dados da viagem e envie a solicitação.</li>
              <li class="flex gap-2"><span class="w-4 h-4 rounded-full bg-sky-500 text-white flex items-center justify-center text-[9px] font-bold flex-shrink-0 mt-0.5">2</span>O administrador analisa e aprova ou rejeita.</li>
              <li class="flex gap-2"><span class="w-4 h-4 rounded-full bg-sky-500 text-white flex items-center justify-center text-[9px] font-bold flex-shrink-0 mt-0.5">3</span>Você recebe uma notificação com o resultado.</li>
              <li class="flex gap-2"><span class="w-4 h-4 rounded-full bg-amber-500 text-white flex items-center justify-center text-[9px] font-bold flex-shrink-0 mt-0.5">!</span>Pedidos aprovados <strong>não podem</strong> ser cancelados pelo solicitante.</li>
            </ol>
          </div>
          <div class="bg-white rounded-2xl border border-slate-100 shadow-card p-5">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Status dos seus pedidos</p>
            <div class="space-y-2">
              <div class="flex items-center justify-between text-sm"><span class="text-slate-600">Em aberto</span><span class="font-bold text-amber-600">3</span></div>
              <div class="flex items-center justify-between text-sm"><span class="text-slate-600">Aprovados</span><span class="font-bold text-emerald-600">8</span></div>
              <div class="flex items-center justify-between text-sm"><span class="text-slate-600">Cancelados</span><span class="font-bold text-red-500">2</span></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ══════════════════════════
         APROVAÇÕES (Admin)
    ══════════════════════════ -->
    <div class="page" id="page-aprovacoes">
      <div class="flex items-start justify-between mb-5">
        <div>
          <h1 class="text-xl font-bold text-slate-900">Aprovações Pendentes</h1>
          <p class="text-sm text-slate-500 mt-0.5">Pedidos aguardando análise do administrador</p>
        </div>
        <span class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1.5 rounded-full bg-amber-50 text-amber-700 border border-amber-200">
          <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          <span id="pending-count">0</span> pendentes
        </span>
      </div>

      <!-- Info admin -->
      <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 mb-5 flex items-start gap-3">
        <svg class="w-4 h-4 text-amber-600 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
        <p class="text-xs text-amber-800"><strong>Atenção:</strong> Apenas administradores podem alterar o status de pedidos. O solicitante não pode aprovar ou cancelar seus próprios pedidos aprovados.</p>
      </div>

      <div id="aprovacoes-lista" class="space-y-3"></div>
    </div>

    <!-- ══════════════════════════
         DETALHE DO PEDIDO
    ══════════════════════════ -->
    <div class="page" id="page-detalhe">
      <div class="flex items-center gap-3 mb-6">
        <button onclick="goto('pedidos')" class="p-2 rounded-xl border border-slate-200 text-slate-500 hover:bg-slate-100 transition-colors">
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        </button>
        <div class="flex-1">
          <h1 class="text-xl font-bold text-slate-900" id="det-titulo">Pedido #VGM-0001</h1>
          <p class="text-sm text-slate-500">Detalhes completos da solicitação</p>
        </div>
        <div id="det-actions" class="flex gap-2"></div>
      </div>
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-5" id="det-content"></div>
    </div>

    <!-- ══════════════════════════
         NOTIFICAÇÕES
    ══════════════════════════ -->
    <div class="page" id="page-notificacoes">
      <div class="flex items-start justify-between mb-5">
        <div>
          <h1 class="text-xl font-bold text-slate-900">Notificações</h1>
          <p class="text-sm text-slate-500 mt-0.5">Histórico de notificações do sistema</p>
        </div>
        <button onclick="markAllRead()" class="text-xs font-semibold text-sky-600 hover:text-sky-700 transition-colors">Marcar todas como lidas</button>
      </div>
      <div class="space-y-2" id="notif-lista"></div>
    </div>

    <!-- PÁGINAS GENÉRICAS -->
    <div class="page" id="page-generic">
      <div class="mb-5"><h1 class="text-xl font-bold text-slate-900" id="gen-title">Página</h1></div>
      <div class="bg-white rounded-2xl border border-slate-100 shadow-card p-16 text-center text-slate-400">
        <svg class="w-12 h-12 mx-auto mb-3 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z"/></svg>
        <p class="text-sm font-medium">Esta seção está em desenvolvimento.</p>
      </div>
    </div>

  </main><!-- /content -->

@endsection