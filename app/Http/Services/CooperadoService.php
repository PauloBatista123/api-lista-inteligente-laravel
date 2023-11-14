<?php

namespace App\Http\Services;

use App\Http\Interfaces\TabelaModel;
use App\Http\Interfaces\TabelaProdutos;
use App\Models\Cooperado;
use App\Models\Historico;

class CooperadoService {

    /**
     * Buscar por ID
     *
     *
     * @param string $id
     * @return Cooperado
     * @throws conditon
     **/
    public function buscarPorId(string $id)
    {
        return Cooperado::findOrFail($id);
    }
}
