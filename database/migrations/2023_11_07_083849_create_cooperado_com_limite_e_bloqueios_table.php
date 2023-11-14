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
        Schema::create('cooperado_com_limite_e_bloqueios', function (Blueprint $table) {
            $table->id();
            $table->decimal('renda_bruta', 20, 2);
            $table->decimal('limite_atribuido', 20, 2);
            $table->date('ultima_renovacao');
            $table->string('conta_cartao');
            $table->string('produto');
            $table->string('situacao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cooperado_com_limite_e_bloqueios');
    }
};
