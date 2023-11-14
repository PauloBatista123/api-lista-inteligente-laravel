<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\TabelaModel;
use App\Http\Requests\Historico\CriarHistoricoRequest;
use App\Http\Services\HistoricoService;
use Illuminate\Http\Request;

class HistoricoController extends Controller
{

    public function __construct(protected HistoricoService $historicoService) {}
    /**
     * Criar novo histórico
     *
     * Função responsável por criar um novo comentário do produto
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function criar(CriarHistoricoRequest $request)
    {
        try {
            $this->historicoService->criar(
                $request->get('registroId'),
                $request->get('comentario'),
                $request->get('tabela'),
                $request->get('status')
            );

            return response('', 200);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
