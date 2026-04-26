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
        Schema::create('graficos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('caso_id')->constrained('casos')->onDelete('cascade');
            $table->enum('tipo', ['genograma', 'mapa_redes', 'ecomapa']);
            $table->json('datos')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('graficos');
    }
};
