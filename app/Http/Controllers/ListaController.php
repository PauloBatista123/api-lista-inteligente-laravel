<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListaCreateRequest;
use App\Http\Resources\ListaCollection;
use App\Http\Resources\ListaResource;
use App\Http\Services\ListaService;
use App\Models\Lista;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ListaController extends Controller
{
    public function __construct(protected ListaService $listaService){}

    /**
     * Listar as listas no sistema
     *
     *
     * @param Request $var Description
     * @return Response
     **/
    public function listar(Request $request)
    {

        $itens = Lista::with(['produtos'])->paginate(10);

        return new ListaCollection($itens);

    }

     /**
     * Detalhes de uma lista
     *
     *
     * @param string $id Description
     * @return Response
     **/
    public function detalhar(string $id)
    {
        $lista = $this->listaService->buscarPorId($id);
        return new ListaResource($lista->load('produtos'));
    }

    /**
     * Criar uma nova Lista
     *
     *
     * @param ListaCreateRequest $request
     * @return Response
     **/
    public function criar(ListaCreateRequest $request)
    {
        $this->listaService->salvar($request->get('tag'), $request->get('prazo_final'));

        return response('', Response::HTTP_CREATED);
    }


    /**
     * Alterar status de um grupo especifico
     *
     *
     * @param string $id
     * @return Response
     **/
    public function alterarStatus(Request $request, string $id)
    {
        $lista = $this->listaService->buscarPorId($id);

        $this->listaService->alterarStatus($lista, $request->get('status'));

        return response('', Response::HTTP_OK);
    }

    /**
     * Vinular listas ao grupo
     *
     *
     * @param string $id
     * @return Response
     **/
    public function vincularProdutos(Request $request, string $id)
    {
        $lista = $this->listaService->buscarPorId($id);

        $this->listaService->vincularProdutos($lista, (array) $request->get('produtos'));

        return response('', Response::HTTP_OK);
    }

    /**
     * Alterar informações do grupo
     *
     *
     * @param string $id
     * @return Response
     **/
    public function alterar(Request $request, string $id)
    {
        $lista = $this->listaService->buscarPorId($id);

        $this->listaService->atualizarDados($lista, $request->get('tag'), $request->get('prazo_final'), $request->get('status'));

        return response('', Response::HTTP_OK);
    }
}
