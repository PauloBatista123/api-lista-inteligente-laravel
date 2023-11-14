<?php

namespace App\Http\Controllers;

use App\Http\Resources\Produtos\Cartao\CooperadoSemLimiteImplantadoCollection;
use App\Http\Resources\Produtos\Limites\LimiteCooperadoSemLimiteImplantadoCollection;
use App\Models\Produto\Limites\LimitesCooperadoSemLimiteImplantado;
use Illuminate\Http\Request;

class LimitesCooperadoSemLimiteImplantadoController extends Controller
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

            $cartoes = LimitesCooperadoSemLimiteImplantado::when($request->get('cpfCnpj'), function($query) use ($request){
                $query->where('cpf_cnpj', $request->get('cpfCnpj'));
            })
            ->paginate(10);

            return new LimiteCooperadoSemLimiteImplantadoCollection($cartoes);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
