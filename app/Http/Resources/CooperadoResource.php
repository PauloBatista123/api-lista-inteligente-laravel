<?php

namespace App\Http\Resources;

use App\Http\Resources\Cooperado\ProdutoResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CooperadoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // $cartoesComLimite = $this->cartoesComLimiteEBloqueio()->select('id', 'movimento', 'status', 'produto_id')->get();
        // $cartoesFabrica = $this->cartoesLimiteFabrica()->select('id', 'movimento', 'status', 'produto_id')->get();
        // $semLimiteImplantado = $this->limitesSemLimiteImplantado()->select('id', 'movimento', 'status', 'produto_id')->get();
        // $all = $cartoesComLimite->concat($cartoesFabrica)->concat($semLimiteImplantado);

        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'cpf_cnpj' => $this->cpf_cnpj,
            'telefone_celular' => $this->telefone_celular,
            'telefone_residencial' => $this->telefone_residencial,
            'cidade' => $this->cidade,
            'endereco' => $this->endereco,
            'uf' => $this->uf,
            'renda' => number_format($this->renda, 2, ',', '.'),
            'sigla' => $this->sigla,
            'produtos' => ProdutoResource::collection($this->produtos),
            'ponto_atendimento' => $this->pontoAtendimento,
            'created_at' => Carbon::parse($this->created_at)->format('d/m/Y H:i:s'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d/m/Y H:i:s'),
        ];
    }
}
