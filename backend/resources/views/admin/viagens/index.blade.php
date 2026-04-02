@extends('layouts.admin')

@section('content')
<main class="flex-1 overflow-y-auto bg-slate-50 p-6">
    <div class="page active" id="page-pedidos">
        <div class="flex items-start justify-between mb-5">
            <div>
                <h1 class="text-xl font-bold text-slate-900">Pedidos de Viagem</h1>
                <p class="text-sm text-slate-500 mt-0.5">Gerencie todos os pedidos cadastrados</p>
            </div>
            <button onclick="openCreateModal()" class="inline-flex items-center gap-2 px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white text-sm font-semibold rounded-xl shadow-sm transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path></svg>
                Novo Pedido
            </button>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-card p-4 mb-4">
            <div class="flex flex-wrap gap-3 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Buscar</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path></svg>
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

        <div class="bg-white rounded-2xl border border-slate-100 shadow-card overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                        <th class="text-left px-5 py-3">ID / Solicitante</th>
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
        <div class="mt-4">
            {{ $viagens->links() }}
        </div>
    </div>
</main>

<div id="modal-status" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md transform scale-95 transition-all duration-300 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 id="modal-title" class="text-lg font-bold text-slate-800">Aprovar Pedido</h3>
            <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <div class="p-6">
            <p id="modal-sub" class="text-xs font-mono text-slate-500 mb-4 uppercase tracking-wider"></p>
            <div id="modal-content"></div>
            <div id="modal-actions" class="flex gap-3 mt-6"></div>
        </div>
    </div>
</div>


<div id="modal-viagem" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/40 backdrop-blur-sm">
    <div class="bg-white w-full max-w-md rounded-2xl shadow-xl overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-slate-900" id="modal-titulo">Novo Pedido de Viagem</h3>
            <button onclick="closeViagemModal()" class="text-slate-400 hover:text-slate-600">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        
        <form id="form-viagem" class="p-6 py-0 mb-5 space-y-4">
            <input type="hidden" id="viagem-id">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Solicitante</label>
                <input type="text" id="v-solicitante" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-sky-500 outline-none transition-all">
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Cidade de Origem</label>
                    <select id="v-origem" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-sky-500 outline-none bg-white">
                        <option value="" disabled selected>Selecione a origem</option>
                        <option value="Belo Horizonte">Belo Horizonte</option>
                        <option value="São Paulo">São Paulo</option>
                        <option value="Rio de Janeiro">Rio de Janeiro</option>
                        <option value="Brasília">Brasília</option>
                        <option value="Curitiba">Curitiba</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Cidade de Destino</label>
                    <select id="v-destino" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-sky-500 outline-none bg-white">
                        <option value="" disabled selected>Selecione o destino</option>
                        <option value="Belo Horizonte">Belo Horizonte</option>
                        <option value="São Paulo">São Paulo</option>
                        <option value="Rio de Janeiro">Rio de Janeiro</option>
                        <option value="Brasília">Brasília</option>
                        <option value="Curitiba">Curitiba</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Data Ida</label>
                    <input type="date" id="v-ida" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Data Volta</label>
                    <input type="date" id="v-volta" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 outline-none">
                </div>
            </div>
            <button type="submit" class="w-full py-3 bg-sky-500 text-white font-bold rounded-xl hover:bg-sky-600 transition-all shadow-lg shadow-sky-200">
                Salvar Pedido
            </button>
        </form>
    </div>
</div>




@endsection