<?php

namespace App\Http\Controllers;

use App\Http\Resources\CooperadoCollection;
use App\Http\Resources\CooperadoResource;
use App\Http\Services\CooperadoService;
use App\Models\Cooperado;
use App\Models\Lista;
use App\Models\ListaItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            $cooperado = Cooperado::has('produtos')
            ->when($request->get('nome'), function($query) use ($request) {
                $query->where('nome', 'like','%'.$request->get('nome').'%');
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

    /**
     * Função para agrupar as listas e quantidades
     *
     * @return Response
     **/
    public function summary(string $id)
    {
        $produtos = DB::table('lista_items as li')
                        ->join('produtos', 'li.produto_id', '=', 'produtos.id')
                        ->select('produtos.descricao', DB::raw('count(li.id) as quantidade'))
                        ->where('cooperado_id', $id)
                        ->whereNotIn('li.status', Lista::STATUS_FINALIZADO)
                        ->groupBy('li.produto_id')
                        ->get();

        return response()->json($produtos);
    }
}
