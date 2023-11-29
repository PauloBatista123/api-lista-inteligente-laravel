<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\TabelaProdutos;
use App\Http\Requests\Produto\AlterarStatusRequest;
use App\Http\Requests\Produto\AlterarTipoContatoRequest;
use App\Http\Requests\Produto\CriarNovoProdutoRequest;
use App\Http\Resources\ListaCollection;
use App\Http\Resources\ListaResource;
use App\Http\Resources\ProdutoCollection;
use App\Http\Services\ProdutoService;
use App\Http\Services\VisualizacaoService;
use App\Models\ListaItem;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

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
        $itens = ListaItem::with(['cooperado', 'pontoAtendimento', 'produtoLista', 'lista'])
        ->when($request->get('isFinished'), function ($query) use ($request){
            $query->whereHas('lista', function ($query) use ($request){
                if($request->get('isFinished') === 'false'){
                    $query->where('status', 'ativa');
                }
            });
        })
        ->when($request->get('grupos'), function($query) use ($request){
            $query->whereIn('lista_id', $request->get('grupos'));
        })
        ->when($request->get('produtos'), function($query) use ($request){
            $query->whereIn('produto_id', $request->get('produtos'));
        })
        ->when($request->get('pas'), function($query) use ($request){
            $query->whereIn('ponto_atendimento_id', $request->get('pas'));
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
        }, function ($query) use ($request){
            $query->whereNotIn('status', ['finalizado_indeferido', 'finalizado_nao_localizado', 'finalizado_nao_contratado', 'finalizado_contratado']);
        })
        ->when($request->get('dataInicioCriacao') && $request->get('dataFimCriacao'), function($query) use ($request){
            $query->whereBetween('movimento', [
                $request->get('dataInicioCriacao'),
                $request->get('dataFimCriacao')
            ]);
        })
        ->paginate(12);

        return new ProdutoCollection($itens);
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

        $item = $this->produtoService->buscarItemPorId($id);

        $item['type'] = $item->produtoLista->nome;

        $this->visualizacaoService->salvar($id, $item->produtoLista->nome, 1);

        $itemDetalhes = app($item->model)->findOrFail($item->registro_id);

        $item->load('visualizacoes', 'historicos', 'pontoAtendimento', 'lista', 'cooperado');

        $registro = array_merge($item->toArray(), $itemDetalhes->toArray());

        return response()->json($registro);

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

        $this->produtoService->alterarTipoContato($id, $request->get('tipoContato'));

        return response('', Response::HTTP_OK);

    }

    /**
     *
     * Listar os produtos cadastrados
     *
     * @param Request $request
     * @return Response
     * @throws Exception
     **/
    public function listas(Request $request)
    {
        $produtos = Produto::when($request->get('status'), function($query) use ($request){
            $query->where('status', $request->get('status'));
        })->orderBy('nome')
        ->when($request->get('page'), function ($query) use ($request) {
            if($request->get('page') < 0){
                return $query->get();
            }

            return $query->paginate(12);
        }, function($query){
            return $query->get();
        });;

        return new ListaCollection($produtos);
    }

    /**
     * Criar um novo produto
     *
     *
     * @param CriarNovoProdutoRequest
     * @return Response
     * @throws Exception
     **/
    public function criar(CriarNovoProdutoRequest $request)
    {
        Produto::create([
            'nome' => Str::of($request->get('descricao'))->slug('_'),
            'descricao' => $request->get('descricao'),
        ]);

        return response('', Response::HTTP_CREATED);
    }

    /**
     * undocumented function summary
     *
     *
     * @param Request $var Description
     * @return Response
     **/
    public function alterarStatus(AlterarStatusRequest $request, string $id)
    {
        Produto::where('id', $id)->update([
            'status' => $request->get('status')
        ]);

        return response('', Response::HTTP_OK);
    }

    /**
     * Alterar dados do produto
     *
     * @param Request $request
     * @param string $id
     * @return Response
     **/
    public function alterar(Request $request, string $id)
    {
        Produto::findOrFail($id)->update([
            'status' => $request->get('status'),
            'descricao' => $request->get('descricao'),
        ]);

        return response('', Response::HTTP_OK);
    }
}
