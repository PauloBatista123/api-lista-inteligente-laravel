<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\TabelaProdutos;
use App\Http\Requests\ListaCreateRequest;
use App\Http\Resources\ListaCollection;
use App\Http\Services\ListaService;
use App\Models\Lista;
use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Produto\Cartao;
use App\Models\Produto\CooperadoComLimiteEBloqueio;
use App\Models\Produto\CooperadoSemLimiteImplantado;
use App\Models\Produto\Limites\LimitesCooperadoSemLimiteImplantado;
use Illuminate\Http\Response;

class ListaController extends Controller
{
    public function __construct(protected ListaService $listaService){}

    /**
     * Listar as listas no sistema
     *
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function listar(Request $request)
    {
        try {

            $itens = Lista::with(['produto'])->paginate(10);

            return new ListaCollection($itens);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function criar(ListaCreateRequest $request)
    {
        try {
            $this->listaService->salvar($request->get('tag'), $request->get('prazo_final'), $request->get('produto_id'));

            return response('', Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
