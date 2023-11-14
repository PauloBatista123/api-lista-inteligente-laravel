<?php

namespace App\Models;

use App\Models\Produto\Cartao;
use App\Models\Produto\CooperadoComLimiteEBloqueio;
use App\Models\Produto\CooperadoSemLimiteImplantado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cooperado extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome', 'cpf_cnpj', 'telefone_celular', 'telefone_residencial', 'ponto_atendimento_id', 'endereco', 'cidade', 'uf', 'renda', 'sigla'
    ];

    public function cartoesLimiteFabrica()
    {
        return $this->hasMany(Cartao::class, 'cooperado_id', 'id');
    }

    public function cartoesComLimiteEBloqueio()
    {
        return $this->hasMany(CooperadoComLimiteEBloqueio::class, 'cooperado_id', 'id');
    }

    public function limitesSemLimiteImplantado()
    {
        return $this->hasMany(CooperadoSemLimiteImplantado::class, 'cooperado_id', 'id');
    }

    public function pontoAtendimento()
    {
        return $this->belongsTo(PontoAtendimento::class, 'ponto_atendimento_id', 'id');
    }
}
