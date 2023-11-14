<?php

namespace App\Models\Produto;

use App\Models\Cooperado;
use App\Models\Historico;
use App\Models\PontoAtendimento;
use App\Models\Produto;
use App\Models\UsuarioProdutoVisualizacao;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CooperadoSemLimiteImplantado extends Model
{
    use HasFactory;

    protected $hidden = ['cooperado_id', 'ponto_atendimento_id', 'produto_id', 'id'];

    protected $fillable = ['movimento', 'produto_id', 'ponto_atendimento_id', 'cooperado_id', 'renda_bruta', 'ultima_renovacao', 'conta_cartao', 'produto', 'situacao', 'status', 'tipo_contato'];
}
