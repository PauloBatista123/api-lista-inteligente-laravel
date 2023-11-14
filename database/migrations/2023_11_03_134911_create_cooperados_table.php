<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cooperados', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cpf_cnpj');
            $table->string('telefone_celular');
            $table->string('telefone_residencial')->nullable();
            $table->string('endereco');
            $table->string('cidade');
            $table->string('uf');
            $table->decimal('renda', 20, 2);
            $table->enum('sigla', ['pf', 'pj']);
            $table->unsignedBigInteger('ponto_atendimento_id');
            $table->timestamps();
            $table->foreign('ponto_atendimento_id')->references('id')->on('ponto_atendimentos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cooperados');
    }
};
