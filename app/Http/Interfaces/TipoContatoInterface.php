<?php

namespace App\Http\Interfaces;

enum TipoContatoInterface: string
{
    case AGENCIA = 'agencia';
    case EMAIL = 'email';
    case LIGACAO = 'ligacao';
    case VISITA_EXTERNA = 'visita_externa';
    case WHATSAPP = 'whatsapp';

    public function all(): array
    {
        return array(self::AGENCIA, self::EMAIL, self::LIGACAO, self::VISITA_EXTERNA, self::WHATSAPP);
    }

}

