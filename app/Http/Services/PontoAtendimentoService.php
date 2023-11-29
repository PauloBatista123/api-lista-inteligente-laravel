<?php

namespace App\Http\Services;

use App\Models\PontoAtendimento;

/**
 * Service de Ponto Atendimento
 */
class PontoAtendimentoService {

    /**
     * Cadastrar novo ponto atendimento
     *
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function cadastrar(int $numero, string $nome, string $cidade)
    {
        return PontoAtendimento::create([
            'id' => (int) $numero,
            'pa' => $numero,
            'cidade' => $cidade,
            'nome' => $nome,
        ]);
    }
}
