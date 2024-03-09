<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    protected $table = 'categorias_productos';
    protected $primaryKey = 'CategoriaID';
    protected $fillable = ['Nombre'];
}
