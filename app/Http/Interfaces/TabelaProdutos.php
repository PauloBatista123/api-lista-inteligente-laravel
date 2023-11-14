<?php

namespace App\Http\Interfaces;

enum TabelaProdutos: string
{

    case CARTAO = 'cartao';
    case COOPERADO = 'cooperado';
    case COOPERADO_SEM_LIMITE = 'cartao_sem_limite_implantado';
    case COOPERADO_COM_LIMITE_E_BLOQUEIO = 'cartao_com_limite_e_com_bloqueio';
    case LIMITES_COOPERADO_SEM_LIMITE = 'limites_cooperado_sem_limite_implantado';

    public function label(): string
    {
        return match($this) {
            static::CARTAO => 'Pending',
            static::COOPERADO => 'Active',
            static::COOPERADO_SEM_LIMITE => 'Suspended',
            static::COOPERADO_COM_LIMITE_E_BLOQUEIO => 'Canceled by user',
            static::LIMITES_COOPERADO_SEM_LIMITE => 'Canceled by user',
        };
    }
}


