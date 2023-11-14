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
        Schema::create('lista_items', function (Blueprint $table) {
            $table->id();
            $table->string('model');
            $table->integer('registro_id')->index();
            $table->date('movimento');
            $table->unsignedBigInteger('produto_id');
            $table->unsignedBigInteger('lista_id');
            $table->unsignedBigInteger('ponto_atendimento_id');
            $table->unsignedBigInteger('cooperado_id');
            $table->enum('tipo_contato', ['agencia', 'email', 'ligacao', 'visita_externa', 'whatsapp'])->nullable();
            $table->enum('status', [
                'aberto', 'pendente_retornar_contato', 'pendente_atualizacao_cadastral', 'pendente_proposta_em_analise', 'pendente_formalizacao',
                'finalizado_contratado', 'finalizado_nao_contratado', 'finalizado_nao_localizado', 'finalizado_indeferido'
            ])->default('aberto');
            $table->timestamps();


            $table->foreign('produto_id')->references('id')->on('produtos');
            $table->foreign('lista_id')->references('id')->on('listas');
            $table->foreign('ponto_atendimento_id')->references('id')->on('ponto_atendimentos');
            $table->foreign('cooperado_id')->references('id')->on('cooperados');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lista_items');
    }
};
