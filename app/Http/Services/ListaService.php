<?php

namespace App\Http\Services;

use App\Models\Lista;
use App\Models\UsuarioProdutoVisualizacao;
use Carbon\Carbon;

/**
 * Service de para tratar as Listas
 */

class ListaService {

    /**
     *
     * Atualizar ou criar nova lista
     *
     * @param string $tag,
     * @param string $prazoFinal,
     * @param string $produtoId
     **/
    public function salvar(string $tag, string $prazoFinal, string $produtoId)
    {
        Lista::create([
            'tag' => $tag,
            'prazo_final' => Carbon::parse($prazoFinal)->toDateTimeString(),
            'produto_id' => $produtoId
        ]);
    }

}
