<?php

namespace App\Http\Services;

use App\Http\Interfaces\TabelaModel;
use App\Http\Interfaces\TabelaProdutos;
use App\Models\Historico;
use App\Models\ListaItem;
use App\Models\Produto\Cartao;
use Carbon\Carbon;
use Exception;

class ProdutoService {

    /**
     *
     * Buscar por ID
     *
     * @param string $registroId
     * @return ListaItem
     * @throws Exception
     **/
    public function buscarItemPorId(string $registroId)
    {
        return ListaItem::findOrFail($registroId);
    }

    /**
     *
     * Alterar status de um produto
     *
     * @param string $model
     * @param string $registroId
     * @param string $status
     * @return ListaItem
     * @throws Exception
     **/
    public function alterarStatus(string $registroId, string $status)
    {
        $registro = $this->buscarItemPorId($registroId);

        $registro->update([
            'status' => $status,
        ]);

        return $registro;
    }

    /**
     *
     * Alterar o tipo de contato
     *
     * @param string $model
     * @param string $registroId
     * @param string $status
     * @return true|false
     * @throws Exception
     **/
    public function alterarTipoContato(string $registroId, string $tipoContato)
    {
        $registro = $this->buscarItemPorId($registroId);

        return $registro->update([
            'tipo_contato' => $tipoContato
        ]);
    }

    public function getModelClass($tabela)
    {
        switch($tabela) {
            case TabelaProdutos::CARTAO->value:
                return TabelaModel::CARTAOS->value;
                break;
            case TabelaProdutos::COOPERADO_SEM_LIMITE->value:
                return TabelaModel::COOPERADO_SEM_LIMITE->value;
                break;
            case TabelaProdutos::COOPERADO_COM_LIMITE_E_BLOQUEIO->value:
                return TabelaModel::COOPERADO_COM_LIMITE_E_BLOQUEIO->value;
                break;
            case TabelaProdutos::LIMITES_COOPERADO_SEM_LIMITE->value:
                return TabelaModel::LIMITES_COOPERADO_SEM_LIMITE->value;
                break;
            default:
                throw new Exception('Model não encontrado ou inválido');
        }
    }

    /**
     * undocumented function summary
     *
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function criar(
        int $cooperadoId,
        int $pontoAtendimentoId,
        int $produtoId,
        ?Carbon $movimento,
        string $model,
        int $registroId,
        int $listaId
    )
    {
        return ListaItem::create([
            'cooperado_id' => $cooperadoId,
            'ponto_atendimento_id' => $pontoAtendimentoId,
            'produto_id' => $produtoId,
            'movimento' => $movimento->toDateString() ?? now(),
            'model' => $model,
            'registro_id' => $registroId,
            'lista_id' => $listaId,
        ]);
    }


}
