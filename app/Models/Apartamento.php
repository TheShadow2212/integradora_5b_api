<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartamento extends Model
{
    use HasFactory;

    protected $table = 'apartamentos';
    protected $primaryKey = 'ApartamentoID';
    protected $fillable = ['Nombre', 'EdificioID', 'Descripcion', 'Estado'];

    public function edificio()
    {
        return $this->belongsTo(Edificio::class, 'EdificioID');
    }

    public function contratosAlquiler()
    {
        return $this->hasMany(ContratoAlquiler::class, 'ApartamentoID');
    }
}
