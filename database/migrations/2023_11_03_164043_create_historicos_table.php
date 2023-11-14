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
        Schema::create('historicos', function (Blueprint $table) {
            $table->id();
            $table->string('model');
            $table->longText('comentario');
            $table->string('tabela')->index();
            $table->enum('status', [
                'aberto', 'pendente_retornar_contato', 'pendente_atualizacao_cadastral', 'pendente_proposta_em_analise', 'pendente_formalizacao',
                'finalizado_contratado', 'finalizado_nao_contratado', 'finalizado_nao_localizado', 'finalizado_indeferido'
            ])->default('aberto');
            $table->integer('tabela_id')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historicos');
    }
};
