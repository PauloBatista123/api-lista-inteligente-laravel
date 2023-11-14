<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\TabelaProdutos;
use App\Http\Requests\Produto\AlterarTipoContatoRequest;
use App\Http\Resources\ProdutoCollection;
use App\Http\Services\ProdutoService;
use App\Http\Services\VisualizacaoService;
use App\Models\ListaItem;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProdutoController extends Controller
{

    public function __construct(protected ProdutoService $produtoService, protected VisualizacaoService $visualizacaoService) {}

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

            $itens = ListaItem::with(['cooperado', 'pontoAtendimento', 'produtoLista', 'lista'])
            ->when($request->get('produto_id'), function($query) use ($request){
                $query->where('produto_id', $request->get('produto_id'));
            })
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

            return new ProdutoCollection($itens);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    /**
     *
     * Buscar produto por ID
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function buscarPorId(string $id)
    {
        try {

            $item = $this->produtoService->buscarItemPorId($id);

            $item['type'] = $item->produtoLista->nome;

            $this->visualizacaoService->salvar($id, $item->produtoLista->nome, 1);

            $itemDetalhes = app($item->model)->findOrFail($item->registro_id);

            $item->load('visualizacoes', 'historicos', 'pontoAtendimento', 'lista', 'cooperado');

            $registro = array_merge($item->toArray(), $itemDetalhes->toArray());

            return response()->json($registro);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

    }

    /**
     *
     * Alterar o tipo de contato
     *
     * @param AlterarTipoContatoRequest $request
     * @param string $id
     * @throws Exception
     **/
    public function alterarTipoContato(AlterarTipoContatoRequest $request, string $id)
    {
        try {
            $this->produtoService->alterarTipoContato($id, $request->get('tipoContato'));

            return response('', Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function listas(Request $request)
    {
        try {

            $produtos = Produto::all()->map(function ($produto){
                switch($produto->nome){
                    case TabelaProdutos::CARTAO->value:
                        $produto['pendentes'] = $produto->countCartao();
                        return $produto;
                    case TabelaProdutos::COOPERADO_COM_LIMITE_E_BLOQUEIO->value:
                        $produto['pendentes'] = $produto->countCooperadoComLimiteEBloqueio();
                        return $produto;
                    case TabelaProdutos::COOPERADO_SEM_LIMITE->value:
                        $produto['pendentes'] = $produto->countCooperadoSemLimite();
                        return $produto;
                    case TabelaProdutos::LIMITES_COOPERADO_SEM_LIMITE->value:
                        $produto['pendentes'] = $produto->countLimitesCooperadoSemLimite();
                        return $produto;
                    default:
                        return $produto;
                }
            });

            return response()->json(['data' => $produtos]);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
