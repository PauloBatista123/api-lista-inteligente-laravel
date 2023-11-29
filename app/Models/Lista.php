<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lista extends Model
{
    use HasFactory;

    public const STATUS_FINALIZADO = ['finalizado_contratado','finalizado_nao_contratado','finalizado_nao_localizado','finalizado_indeferido'];
    public const STATUS_PENDENTE = ['pendente_retornar_contato','pendente_atualizacao_cadastral','pendente_proposta_em_analise','pendente_formalizacao'];

    protected $fillable = ['tag', 'prazo_final', 'status'];

    public function produtos()
    {
        return $this->belongsToMany(Produto::class, 'produto_lista');
    }
}
