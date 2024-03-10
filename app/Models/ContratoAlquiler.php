<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContratoAlquiler extends Model
{
    use HasFactory;

    protected $table = 'contratos_alquiler';
    protected $primaryKey = 'ContratoID';
    protected $fillable = ['Fecha_Inicio', 'Fecha_Final', 'InquilinoID', 'ApartamentoID'];

    public function inquilino()
    {
        return $this->belongsTo(Inquilino::class, 'InquilinoID');
    }

    public function apartamento()
    {
        return $this->belongsTo(Apartamento::class, 'ApartamentoID');
    }
}
