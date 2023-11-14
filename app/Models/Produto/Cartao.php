<?php

namespace App\Models\Produto;

use App\Models\Cooperado;
use App\Models\Historico;
use App\Models\PontoAtendimento;
use App\Models\Produto;
use App\Models\UsuarioProdutoVisualizacao;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cartao extends Model
{
    use HasFactory;

    protected $hidden = ['cooperado_id', 'ponto_atendimento_id', 'produto_id', 'id'];

    protected $fillable = [
        'movimento', 'conta_cartao', 'data_abertura_conta_cartao', 'limite_atribuido', 'limite_aprovado_fabrica', 'ponto_atendimento_id', 'produto_id', 'cooperado_id', 'status', 'tipo_contato'
    ];

}
