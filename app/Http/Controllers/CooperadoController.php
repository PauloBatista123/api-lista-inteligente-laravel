<?php

namespace App\Http\Controllers;

use App\Http\Resources\CooperadoCollection;
use App\Http\Resources\CooperadoResource;
use App\Http\Services\CooperadoService;
use App\Models\Cooperado;
use Illuminate\Http\Request;

class CooperadoController extends Controller
{

    public function __construct(protected CooperadoService $cooperadoService) {}

    /**
     * Função buscar cooperado
     *
     * Responsável por buscar todos os cooperados do sistema
     *
     * @param Request $request
     * @return Response
     * @throws Exception
     **/
    public function buscar(Request $request)
    {
        try {
            $cooperado = Cooperado::with(['cartoesLimiteFabrica'])->when($request->get('nome'), function($query) use ($request) {
                $query->where('nome', '%'.$request->get('nome').'%');
            })
            ->when($request->get('sigla'), function($query) use ($request) {
                $query->where('sigla', $request->get('sigla'));
            })
            ->when($request->get('cpfCnpj'), function($query) use ($request) {
                $query->where('cpf_cnpj', $request->get('cpfCnpj'));
            })
            ->when($request->get('pontoAtendimento'), function($query) use ($request) {
                $query->where('ponto_atendimento_id', $request->get('pontoAtendimento'));
            })
            ->orderBy('nome')->paginate(10);

            return new CooperadoCollection($cooperado);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Buscar Por ID
     *
     * Função responsável por buscar cooperado por ID
     *
     * @param string $id
     * @return Response
     * @throws Exception
     **/
    public function buscarPorId(string $id)
    {
        try{

            return new CooperadoResource(Cooperado::findOrFail($id));

        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
