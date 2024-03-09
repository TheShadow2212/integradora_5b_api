<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    protected $table = 'provedores';
    protected $primaryKey = 'ProveedorID';
    protected $fillable = ['Nombre', 'Direccion', 'Telefono'];
}
