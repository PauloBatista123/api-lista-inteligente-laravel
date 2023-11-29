<?php

namespace App\Http\Resources;

use App\Http\Interfaces\TabelaModel;
use App\Http\Interfaces\TabelaProdutos;
use App\Models\Cooperado;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImportacaoResource extends JsonResource
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
            'type' => $this->produto != null ? $this->produto->descricao : 'cooperado',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'input' => $this->input,
            'progress_max' => $this->progress_max,
            'progress_now' => $this->progress_now,
        ];
    }
}
