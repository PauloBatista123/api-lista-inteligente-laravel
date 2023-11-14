<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PontoAtendimento extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'pa', 'cidade'];
}
