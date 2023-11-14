<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaItem extends Model
{
    use HasFactory;

    protected $hidden = ['model', 'registro_id', 'produto_id', 'lista_id', 'ponto_atendimento_id'];

    protected $fillable = ['movimento', 'produto_id', 'lista_id', 'ponto_atendimento_id', 'cooperado_id',' tipo_contato', 'status', 'model', 'registro_id'];

    public function historicos()
    {
        return $this->hasMany(Historico::class, 'tabela_id', 'id');
    }

    public function cooperado()
    {
        return $this->belongsTo(Cooperado::class, 'cooperado_id', 'id');
    }

    public function pontoAtendimento()
    {
        return $this->belongsTo(PontoAtendimento::class, 'ponto_atendimento_id', 'id');
    }

    public function produtoLista()
    {
        return $this->belongsTo(Produto::class, 'produto_id', 'id');
    }

    public function visualizacoes()
    {
        return $this->hasMany(UsuarioProdutoVisualizacao::class, 'registro_id', 'id');
    }

    public function lista()
    {
        return $this->belongsTo(Lista::class, 'lista_id', 'id');
    }
}
