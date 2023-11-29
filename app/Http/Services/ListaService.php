<?php

namespace App\Http\Services;

use App\Models\Lista;
use App\Models\Produto;
use App\Models\UsuarioProdutoVisualizacao;
use Carbon\Carbon;

/**
 * Service de para tratar as Listas
 */

class ListaService {

    /**
     * Buscar um grupo por ID
     *
     *
     * @param string $id
     * @return Lista
     **/
    public function buscarPorId(string $id)
    {
        return Lista::findOrFail($id);
    }

    /**
     *
     * Atualizar ou criar nova lista
     *
     * @param string $tag,
     * @param string $prazoFinal,
     **/
    public function salvar(string $tag, string $prazoFinal)
    {
        Lista::create([
            'tag' => $tag,
            'prazo_final' => Carbon::parse($prazoFinal)->toDateTimeString(),
        ]);
    }

    /**
     * Atualizar status de um grupo
     *
     *
     * @param Lista $lista
     * @return bool
     **/
    public function alterarStatus(Lista $lista, string $status)
    {
        return $lista->update([
            'status' => $status
        ]);
    }

    /**
     * Adicionar produtos ao grupo
     *
     *
     * @param Lista $lista
     * @param array $produtos
     * @return bool
     **/
    public function vincularProdutos(Lista $lista, array $produtos)
    {
        if(is_array($produtos)){
            foreach($produtos as $produto){
                if($produto = Produto::find($produto)){
                    if(!$lista->produtos->contains($produto->id)){
                        $lista->produtos()->attach($produto->id);
                    }
                }
            }

            return true;
        }
    }

    /**
     * Atualizar dados do grupo
     *
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function atualizarDados(Lista $lista, string $tag, string $prazoFinal, string $status)
    {
        return $lista->update([
            'tag' => $tag,
            'prazo_final' => $prazoFinal,
            'status' => $status
        ]);
    }

}
