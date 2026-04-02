<?php

namespace App\Http\Controllers;

use App\Models\Viagens;
use Illuminate\Http\Request;
use App\Services\ViagensService;
use App\Mail\StatusViagemAlterado;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ViagensController extends Controller
{
    protected $viagensService;

    public function __construct(ViagensService $viagensService)
    {
        $this->viagensService = $viagensService;
    }

    public function index(Request $request)
    {
        $perPage = ($request->wantsJson() || $request->ajax()) ? 99 : 12;
        
        $viagens = $this->viagensService->listarComFiltros($request, $perPage);
        $stats = $this->viagensService->getStats();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['viagens' => $viagens, 'stats' => $stats]);
        }

        return view('admin.viagens.index', [
            'viagens' => $viagens,
            'stats' => $stats,
            'topDestinos' => $this->viagensService->getTopDestinos()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'destino'     => 'required|string|max:255',
            'origem'      => 'required|string',
            'data_ida'    => 'required|date|after_or_equal:today',
            'data_volta'  => 'required|date|after:data_ida',
            'solicitante' => 'required|string|max:255',
        ]);

        $viagem = Viagens::create(array_merge($validated, [
            'user_id' => Auth::id(),
            'status'  => 'solicitado'
        ]));

        return response()->json($viagem, 201);
    }



    public function updateStatus(Request $request, $id)
    {
        try {
            $viagem = Viagens::findOrFail($id);
            $statusAnterior = $viagem->status;
            $novoStatus = $request->status;

            $viagemAtualizada = $this->viagensService->atualizarStatus($id, $novoStatus);

            //if ($statusAnterior !== $novoStatus) {
                if (in_array($novoStatus, ['aprovado', 'cancelado']) && $viagemAtualizada->user) {
                    Mail::to($viagemAtualizada->user->email)->send(
                        new StatusViagemAlterado($viagemAtualizada, $request->observacao)
                    );
                }
            //}

            return response()->json(['message' => 'Status atualizado com sucesso!']);

        } catch (\Exception $e) {
            $statusCode = $e->getCode() ?: 403;
            return response()->json(['error' => $e->getMessage()], $statusCode);
        }
    }


    public function destroy($id)
    {
        try {
            $this->viagensService->softDelete($id);
            return response()->json(['message' => 'Registro removido'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id) { return response()->json(Viagens::with('user')->findOrFail($id)); }
    public function create() { return view('admin.viagens.form', ['viagem' => new Viagens()]); }
    public function edit($id) { return view('admin.viagens.form', ['viagem' => Viagens::findOrFail($id)]); }
}