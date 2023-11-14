<?php

namespace App\Http\Controllers;

use App\Http\Resources\Produtos\Cartao\CooperadoComLimiteEBloqueioCollection;
use App\Models\Produto\CooperadoComLimiteEBloqueio;
use Illuminate\Http\Request;

class CooperadoComLimiteEBloqueioController extends Controller
{
    /**
     *
     * Listar todos os registros
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     **/
    public function listar(Request $request)
    {
        try {

            $cartoes = CooperadoComLimiteEBloqueio::when($request->get('cpfCnpj'), function($query) use ($request){
                $query->where('cpf_cnpj', $request->get('cpfCnpj'));
            })
            ->paginate(10);

            return new CooperadoComLimiteEBloqueioCollection($cartoes);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
