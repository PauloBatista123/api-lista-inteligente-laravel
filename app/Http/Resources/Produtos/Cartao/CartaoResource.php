<?php

namespace App\Http\Resources\Produtos\Cartao;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartaoResource extends JsonResource
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
            'data_abertura_conta_cartao' => $this->data_abertura_conta_cartao,
            'limite_atribuido' => number_format($this->limite_atribuido, 2, ',', '.'),
            'limite_aprovado_fabrica' => number_format($this->limite_aprovado_fabrica, 2, ',', '.'),
            'status' => $this->status,
            'type' => $this->produtoLista->nome,
            'tipo_contato' => $this->tipo_contato,
            'produto' => $this->produtoLista,
            'historicos' => $this->historicos,
            'visualizacoes' => $this->visualizacoes,
            'cooperado' => $this->cooperado,
            'ponto_atendimento' => $this->pontoAtendimento,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
