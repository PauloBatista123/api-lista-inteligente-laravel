<?php

namespace App\Http\Services;

use App\Http\Interfaces\TabelaModel;
use App\Http\Interfaces\TabelaProdutos;
use App\Models\Historico;
use App\Models\UsuarioProdutoVisualizacao;
use Exception;

/**
 * Service de visualização de registros
 */

class VisualizacaoService {

    public function __construct(protected ProdutoService $produtoService) {}

    /**
     *
     * Atualizar ou criar nova visualização
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function salvar(string|int $registroId, string $tabela, int $usuarioId)
    {
        $model = $this->produtoService->getModelClass($tabela);

        if(
            $visualizacao = UsuarioProdutoVisualizacao::where([
                ['registro_id', '=', $registroId],
                ['model', '=', $model],
                ['usuario_id', '=', $usuarioId]
            ])->first()
        ){
            $visualizacao->update([
                'visualizacoes' => $visualizacao->visualizacoes + 1,
            ]);
        } else {
            UsuarioProdutoVisualizacao::create([
                'model' => $model,
                'usuario_id' => $usuarioId,
                'tabela' => $tabela,
                'registro_id' => $registroId,
                'visualizacoes' => 1
            ]);
        }
    }

}
