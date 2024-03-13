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
        Schema::create('apartamentos', function (Blueprint $table) {
            $table->id('ApartamentoID');
            $table->string('Nombre', 50);
            $table->foreignId('EdificioID')
            ->constrained('edificios', 'EdificioID')
            ->onDelete('cascade');
            $table->string('Descripcion', 255);
            $table->integer('Estado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartamentos');
    }
};
