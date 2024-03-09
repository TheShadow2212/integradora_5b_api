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
        Schema::create('detalles_compras', function (Blueprint $table) {
            $table->id('DetalleCompraID');
            $table->foreignId('CompraID')->constrained('compras', 'CompraID');
            $table->foreignId('ProductoID')->constrained('productos', 'ProductoID');
            $table->integer('Cantidad');
            $table->decimal('Precio_Unitario',10,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles_compras');
    }
};
