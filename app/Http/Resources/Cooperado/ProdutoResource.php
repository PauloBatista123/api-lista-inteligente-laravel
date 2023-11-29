<?php

namespace App\Http\Resources\Cooperado;

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
            'lista' => $this->lista,
            'ponto_atendimento' => $this->pontoAtendimento,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'produto_lista' => $this->produtoLista,
        ];

        if($this->situacao){
            $response['situacao'] = $this->situacao;
        }

        return $response;
    }
}
