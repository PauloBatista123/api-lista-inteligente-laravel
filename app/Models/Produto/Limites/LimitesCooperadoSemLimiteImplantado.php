<?php

namespace App\Models\Produto\Limites;

use App\Models\Cooperado;
use App\Models\Historico;
use App\Models\PontoAtendimento;
use App\Models\Produto;
use App\Models\UsuarioProdutoVisualizacao;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LimitesCooperadoSemLimiteImplantado extends Model
{
    use HasFactory;

    protected $table = 'l_cooperado_sem_limite_implantados';

    protected $hidden = ['cooperado_id', 'ponto_atendimento_id', 'produto_id', 'id'];

    protected $fillable = ['movimento', 'produto_id', 'ponto_atendimento_id', 'cooperado_id', 'renda_bruta', 'indicador_limite_credito',
                            'conta_corrente', 'data_abertura_conta_corrente', 'modalidade_conta_corrente', 'categoria_conta_corrente', 'situacao_conta_corrente',
                            'dias_sem_movimentacao', 'status', 'tipo_contato'];
}
