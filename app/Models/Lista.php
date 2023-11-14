<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lista extends Model
{
    use HasFactory;

    protected $fillable = ['tag', 'produto_id', 'prazo_final'];

    public function produto()
    {
        return $this->belongsTo(Produto::class, 'produto_id', 'id');
    }
}
