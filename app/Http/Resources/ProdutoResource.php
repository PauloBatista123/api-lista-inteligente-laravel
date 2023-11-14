<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProdutoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = [
            'id' => $this->id,
            'movimento' => $this->movimento,
            'status' => $this->status,
            'type' => $this->produtoLista->nome,
            'tipo_contato' => $this->tipo_contato,
            'produto_lista' => $this->produtoLista,
            'lista' => $this->lista,
            'historicos' => $this->historicos,
            'visualizacoes' => $this->visualizacoes,
            'cooperado' => $this->cooperado,
            'ponto_atendimento' => $this->pontoAtendimento,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        if($this->situacao){
            $response['situacao'] = $this->situacao;
        }

        return $response;
    }
}
