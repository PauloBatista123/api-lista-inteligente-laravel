<?php

namespace App\Http\Resources\PontoAtendimento;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PontoAtendimentoResource extends JsonResource
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
            'nome' => $this->nome,
            'pa' => $this->pa,
            'cidade' => $this->cidade,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
