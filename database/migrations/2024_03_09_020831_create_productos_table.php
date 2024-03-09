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
        Schema::create('productos', function (Blueprint $table) {
            $table->id('ProductoID');
            $table->string('Nombre');
            $table->string('Descripcion');
            $table->decimal('Precio',10,2);
            $table->string('Cantidad');
            $table->foreignId('CategoriaID')->constrained('categorias_productos', 'CategoriaID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
