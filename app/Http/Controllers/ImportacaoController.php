<?php

namespace App\Http\Controllers;

use App\Http\Requests\Importacao\UploadRequest;
use App\Http\Resources\ImportacaoResource;
use App\Http\Resources\ImportacaoResourceCollection;
use App\Http\Services\ImportacaoService;
use App\Models\Importacao;
use App\Models\JobStatus;
use App\Models\Produto;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ImportacaoController extends Controller
{
    public function __construct(protected ImportacaoService $importacaoService) {}

    /**
     *
     * Buscar por ID
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function buscar($id)
    {
        try{

            return response()->json(JobStatus::findOrFail($id));

        }catch(Exception $e){
            return response()->json(['message' => $e->getMessage(), 'line' => $e->getLine(), 'file' => $e->getFile()], 500);
        }
    }

    /**
     * Função upload arquivo
     *
     * Função responsavel por realizar e tratar o upload do arquivo
     *
     * @param Request $reques
     * @return Response
     * @throws Exception
     **/
    public function upload(UploadRequest $request)
    {
        try{

            $this->importacaoService->validarHeaderArquivo($request->file('arquivo'), $request->get('lista'));

            $this->importacaoService->processarArquivo(
                $request->file('arquivo'),
                $request->get('lista'),
                $request->get('grupo'),
            );

            return response()->json(['message' => 'Arquivo enviado para processamento']);

        }catch(Exception $e){
            return response()->json(['message' => $e->getMessage(), 'line' => $e->getLine(), 'file' => $e->getFile()], 500);
        }
    }

    /**
     * Função listar
     *
     * Função responsável por listar todas as importações
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function listar(Request $request)
    {
        try {

            $registros = JobStatus::with('produto')->select('type', 'progress_max', 'input', 'created_at', 'updated_at', 'id', 'produto_id')->orderBy('created_at', 'desc')->paginate(10);

            return new ImportacaoResourceCollection($registros);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
