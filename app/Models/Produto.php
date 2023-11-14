<?php

namespace App\Models;

use App\Models\Produto\Cartao;
use App\Models\Produto\CooperadoComLimiteEBloqueio;
use App\Models\Produto\CooperadoSemLimiteImplantado;
use App\Models\Produto\Limites\LimitesCooperadoSemLimiteImplantado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'descricao'];

    protected $hidden = ['cooperado_id', 'ponto_atendimento_id', 'produto_id', 'model'];

    public function countCartao()
    {
        return $this->hasMany(Cartao::class, 'produto_id', 'id')->whereNotIn('status', [
            'finalizado_nao_localizado', 'finalizado_nao_contratado', 'finalizado_contratado', 'finalizado_nao_localizado', 'finalizado_indeferido'
        ])->count();
    }

    public function countCooperadoComLimiteEBloqueio()
    {
        return $this->hasMany(CooperadoComLimiteEBloqueio::class, 'produto_id', 'id')->whereNotIn('status', [
            'finalizado_nao_localizado', 'finalizado_nao_contratado', 'finalizado_contratado', 'finalizado_nao_localizado', 'finalizado_indeferido'
        ])->count();
    }

    public function countCooperadoSemLimite()
    {
        return $this->hasMany(CooperadoSemLimiteImplantado::class, 'produto_id', 'id')->whereNotIn('status', [
            'finalizado_nao_localizado', 'finalizado_nao_contratado', 'finalizado_contratado', 'finalizado_nao_localizado', 'finalizado_indeferido'
        ])->count();
    }

    public function countLimitesCooperadoSemLimite()
    {
        return $this->hasMany(LimitesCooperadoSemLimiteImplantado::class, 'produto_id', 'id')->whereNotIn('status', [
            'finalizado_nao_localizado', 'finalizado_nao_contratado', 'finalizado_contratado', 'finalizado_nao_localizado', 'finalizado_indeferido'
        ])->count();
    }
}
