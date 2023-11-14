<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\PontoAtendimento;
use App\Models\Produto;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        PontoAtendimento::create([
            'nome' => 'Minas Gerais',
            'cidade' => 'Araguari',
            'pa' => '10'
        ]);

        Produto::create([
            'nome' => 'cartao',
            'descricao' => 'LISTA PROPENSOS - LIMITE DA FABRICA'
        ]);

        Produto::create([
            'nome' => 'cartao_sem_limite_implantado',
            'descricao' => 'LISTA CARTOES - COOPERADO SEM LIMITE IMPLANTADO'
        ]);

        Produto::create([
            'nome' => 'cartao_com_limite_e_com_bloqueio',
            'descricao' => 'LISTA CARTOES - COOPERADO COM LIMITE IMPLANTADO E BLOQUEIO DE EMISSAO'
        ]);

        Produto::create([
            'nome' => 'limites_cooperado_sem_limite_implantado',
            'descricao' => 'LIMITES - COOPERADO SEM LIMITE DE CREDITO IMPLANTADO'
        ]);

        User::create([
            'name' => 'Paulo H',
            'email' => 'pauloe4264_00',
            'password' => '123'
        ]);
    }
}
