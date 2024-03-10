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
        Schema::create('calles', function (Blueprint $table) {
            $table->id('CalleID');
            $table->string('Nombre', 50);
            $table->foreignId('BarrioID')->constrained('barrios', 'BarrioID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calles');
    }
};
