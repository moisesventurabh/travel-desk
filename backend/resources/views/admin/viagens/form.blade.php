@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto p-6">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-card p-8">
        <h2 class="text-xl font-bold text-slate-800 mb-6">
            {{ $viagem->exists ? 'Editar Pedido' : 'Novo Pedido de Viagem' }}
        </h2>

        <form action="{{ $viagem->exists ? route('viagens.update', $viagem->id) : route('viagens.store') }}" method="POST">
            @csrf
            @if($viagem->exists) @method('PUT') @endif

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Destino</label>
                    <input type="text" name="destino" value="{{ old('destino', $viagem->destino) }}" required class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500/20 outline-none">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Data de Ida</label>
                        <input type="date" name="data_ida" value="{{ old('data_ida', $viagem->data_ida ? $viagem->data_ida->format('Y-m-d') : '') }}" required class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Data de Volta</label>
                        <input type="date" name="data_volta" value="{{ old('data_volta', $viagem->data_volta ? $viagem->data_volta->format('Y-m-d') : '') }}" required class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl">
                    </div>
                </div>
            </div>

            <div class="mt-8 flex gap-3">
                <button type="submit" class="flex-1 bg-sky-600 text-white font-bold py-3 rounded-xl shadow-lg hover:bg-sky-700 transition-all">
                    {{ $viagem->exists ? 'Salvar Alterações' : 'Criar Pedido' }}
                </button>
                <a href="{{ route('viagens.index') }}" class="px-6 py-3 text-slate-400 font-semibold hover:text-slate-600 transition-colors">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection