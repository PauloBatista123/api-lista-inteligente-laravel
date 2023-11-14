<?php

namespace App\Http\Resources\Produtos\Cartao;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CooperadoSemLimiteImplantadoResource extends JsonResource
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
            'conta_cartao' => $this->conta_cartao,
            'ultima_renovacao' => $this->ultima_renovacao,
            'renda_bruta' => number_format($this->renda_bruta, 2, ',', '.'),
            'status' => $this->status,
            'type' => $this->produtoLista->nome,
            'tipo_contato' => $this->tipo_contato,
            'produto_cartao' => $this->produto,
            'historicos' => $this->historicos,
            'visualizacoes' => $this->visualizacoes,
            'cooperado' => $this->cooperado,
            'ponto_atendimento' => $this->pontoAtendimento,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
