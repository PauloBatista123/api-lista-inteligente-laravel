<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioProdutoVisualizacao extends Model
{
    use HasFactory;

    protected $fillable = ['usuario_id', 'model', 'tabela', 'registro_id', 'visualizacoes'];

    protected $with = ['usuario'];

    protected $hidden = ['model', 'tabela', 'registro_id', 'usuario_id'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id', 'id');
    }
}
