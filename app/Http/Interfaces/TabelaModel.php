<?php

namespace App\Http\Interfaces;

use App\Models\Cooperado;
use App\Models\Produto\Cartao;
use App\Models\Produto\CooperadoComLimiteEBloqueio;
use App\Models\Produto\CooperadoSemLimiteImplantado;
use App\Models\Produto\Limites\LimitesCooperadoSemLimiteImplantado;

enum TabelaModel: string
{
    case CARTAOS = Cartao::class;
    case COOPERADO = Cooperado::class;
    case COOPERADO_SEM_LIMITE = CooperadoSemLimiteImplantado::class;
    case COOPERADO_COM_LIMITE_E_BLOQUEIO = CooperadoComLimiteEBloqueio::class;
    case LIMITES_COOPERADO_SEM_LIMITE = LimitesCooperadoSemLimiteImplantado::class;

    public function label(): string
    {
        return match($this) {
            static::CARTAOS => 'Pending',
            static::COOPERADO => 'Active',
            static::COOPERADO_SEM_LIMITE => 'Suspended',
            static::COOPERADO_COM_LIMITE_E_BLOQUEIO => 'Canceled by user',
            static::LIMITES_COOPERADO_SEM_LIMITE => 'Canceled by user',
        };
    }
}
