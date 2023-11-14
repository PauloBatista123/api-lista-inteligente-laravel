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
        Schema::create('usuario_produto_visualizacaos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->string('model');
            $table->string('tabela')->index();
            $table->integer('registro_id')->index();
            $table->timestamps();
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->integer('visualizacoes')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario_produto_visualizacaos');
    }
};
