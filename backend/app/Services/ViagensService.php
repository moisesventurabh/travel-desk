<?php

namespace App\Services;

use App\Models\Viagens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViagensService
{

    private function getBaseQuery()
    {
        $user = Auth::user();
        $query = Viagens::where('enabled', 1);

        return $user->role === 'admin' 
            ? $query 
            : $query->where('user_id', $user->id);
    }


    public function listarComFiltros(Request $request, $perPage = 12)
    {
        $query = $this->getBaseQuery()->with('user');

        // Filtro de Texto no dasboard
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('solicitante', 'like', "%{$request->search}%")
                  ->orWhere('destino', 'like', "%{$request->search}%")
                  ->orWhere('origem', 'like', "%{$request->search}%")
                  ->orWhere('id', 'like', "%{$request->search}%");
            });
        }

        // Filtro de Status e Datas
        $query->when($request->status, fn($q) => $q->where('status', $request->status))
              ->when($request->desde, fn($q) => $q->whereDate('data_ida', '>=', $request->desde))
              ->when($request->ate, fn($q) => $q->whereDate('data_ida', '<=', $request->ate));

        return $query->latest()->paginate($perPage);
    }

    public function getStats()
    {
        $base = $this->getBaseQuery();

        return [
            'total'       => (clone $base)->count(),
            'aprovados'   => (clone $base)->where('status', 'aprovado')->count(),
            'solicitados' => (clone $base)->where('status', 'solicitado')->count(),
            'cancelados'  => (clone $base)->where('status', 'cancelado')->count(),
        ];
    }

    public function atualizarStatus($id, $novoStatus)
    {
        $viagem = Viagens::findOrFail($id);

        if (Auth::user()->role !== 'admin') {
            throw new \Exception('Acesso negado. Somente administradores.', 403);
        }

        if ($novoStatus === 'cancelado' && $viagem->status === 'aprovado') {
            throw new \Exception('Não é possível cancelar um pedido já aprovado.', 422);
        }

        $viagem->update(['status' => $novoStatus]);
        return $viagem;
    }

    public function softDelete($id)
    {
        $viagem = Viagens::findOrFail($id);
        return $viagem->update(['enabled' => 0, 'status' => 'cancelado']);
    }

    public function getTopDestinos($limit = 3)
    {
        return Viagens::select('destino', \DB::raw('count(*) as total'))
            ->groupBy('destino')->orderBy('total', 'desc')->take($limit)->get();
    }

    public function getRecent($limit = 8)
    {
        return $this->getBaseQuery()
            ->with('user')
            ->latest()
            ->take($limit)
            ->get();
    }

}