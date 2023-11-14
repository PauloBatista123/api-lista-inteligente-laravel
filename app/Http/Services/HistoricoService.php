<?php

namespace App\Http\Services;

use App\Http\Interfaces\TabelaModel;
use App\Http\Interfaces\TabelaProdutos;
use App\Models\Historico;
use Exception;

class HistoricoService {

    public function __construct(protected ProdutoService $produtoService) {}

    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function criar(string|int $registroId, string $comentario, string $tabela, string $status)
    {
        $item = $this->produtoService->alterarStatus($registroId, $status);

        return Historico::create([
            'comentario' => $comentario,
            'model' => $item->model,
            'tabela' => $tabela,
            'tabela_id' => $registroId,
            'status' => $status
        ]);
    }
}
