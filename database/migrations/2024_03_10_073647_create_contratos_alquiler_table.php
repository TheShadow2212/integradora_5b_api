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
        Schema::create('contratos_alquiler', function (Blueprint $table) {
            $table->id('ContratoID');
            $table->date('Fecha_Inicio');
            $table->date('Fecha_Final');
            $table->foreignId('InquilinoID')->constrained('inquilinos', 'InquilinoID')->onDelete('cascade');
            $table->foreignId('ApartamentoID')->constrained('apartamentos', 'ApartamentoID')->onDelete('cascade');
            $table->decimal('Monto', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contratos_alquiler');
    }
};
