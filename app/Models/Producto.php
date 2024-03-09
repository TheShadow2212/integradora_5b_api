<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'productos';
    protected $primaryKey = 'ProductoID';
    protected $fillable = ['Nombre', 'Precio', 'Stock', 'CategoriaID'];
}
