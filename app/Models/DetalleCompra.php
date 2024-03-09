<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    use HasFactory;
    protected $table = 'detalle_compras';
    protected $primaryKey = 'DetalleCompraID';
    protected $fillable = ['CompraID', 'ProductoID', 'Cantidad', 'Precio_Unitario'];
}
