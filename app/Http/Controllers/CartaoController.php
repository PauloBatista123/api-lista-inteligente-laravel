<?php

namespace App\Http\Controllers;

use App\Http\Resources\Produtos\Cartao\CartaoCollection;
use App\Models\Produto\Cartao;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartaoController extends Controller
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

            $cartoes = Cartao::with(['historicos', 'cooperado', 'pontoAtendimento', 'produto'])
            ->when($request->get('nome') || $request->get('cpfCnpj'), function ($query) use ($request){
                $query->withWhereHas('cooperado', function ($query) use ($request){
                    if($request->get('nome')){
                        $query->where('nome', 'like', '%'.$request->get('nome').'%');
                    }
                    if($request->get('cpfCnpj')){
                        $query->where('cpf_cnpj', 'like', '%'.$request->get('cpfCnpj').'%');
                    }
                });
            })
            ->when($request->get('status'), function($query) use ($request){
                $query->where('status', $request->get('status'));
            })
            ->when($request->get('dataInicioCriacao') && $request->get('dataFimCriacao'), function($query) use ($request){
                $query->whereBetween('movimento', [
                    $request->get('dataInicioCriacao'),
                    $request->get('dataFimCriacao')
                ]);
            })
            ->paginate(10);

            return new CartaoCollection($cartoes);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
