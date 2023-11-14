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
        Schema::create('l_cooperado_sem_limite_implantados', function (Blueprint $table) {
            $table->id();
            $table->decimal('renda_bruta', 20, 2);
            $table->string('indicador_limite_credito');
            $table->string('conta_corrente');
            $table->date('data_abertura_conta_corrente');
            $table->string('modalidade_conta_corrente');
            $table->string('categoria_conta_corrente');
            $table->string('situacao_conta_corrente');
            $table->integer('dias_sem_movimentacao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('l_cooperado_sem_limite_implantados');
    }
};
