<?php

namespace App\Http\Resources\Produtos\Limites;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LimiteCooperadoSemLimiteImplantadoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'movimento' => $this->movimento,
            'renda_bruta' => number_format($this->renda_bruta, 2, ',', '.'),
            'indicador_limite_credito' => $this->indicador_limite_credito,
            'conta_corrente' => $this->conta_corrente,
            'data_abertura_conta_corrente' => $this->data_abertura_conta_corrente,
            'type' => $this->produto->nome,
            'modalidade_conta_corrente' => $this->modalidade_conta_corrente,
            'categoria_conta_corrente' => $this->categoria_conta_corrente,
            'dias_sem_movimentacao' => $this->dias_sem_movimentacao,
            'situacao_conta_corrente' => $this->situacao_conta_corrente,
            'status' => $this->status,
            'tipo_contato' => $this->tipo_contato,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'visualizacoes' => $this->visualizacoes,
            'historicos' => $this->historicos,
            'cooperado' => $this->cooperado,
            'ponto_atendimento' => $this->pontoAtendimento,
        ];
    }
}
