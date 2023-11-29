<?php

namespace App\Http\Controllers;

use App\Http\Resources\PontoAtendimento\PontoAtendimentoCollection;
use App\Http\Services\PontoAtendimentoService;
use App\Models\PontoAtendimento;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PontoAtendimentoController extends Controller
{

    public function __construct(protected PontoAtendimentoService $pontoAtendimentoService) {}

    /**
     * Listar todos os pas
     *
     *
     * @param Request $request
     **/
    public function listar(Request $request)
    {
        $pas = PontoAtendimento::when($request->get('page'), function ($query) use ($request) {
            if($request->get('page') < 0){
                return $query->get();
            }

            return $query->paginate(12);
        }, function($query){
            return $query->get();
        });;;

        return new PontoAtendimentoCollection($pas);
    }

    /**
     * Cadastrar novo ponto atendimento
     *
     *
     * @param Type $request
     * @return Response
     **/
    public function cadastrar(Request $request)
    {
        $this->pontoAtendimentoService->cadastrar($request->get('numero'), $request->get('nome'), $request->get('cidade'));

        return response('', Response::HTTP_CREATED);
    }

}
