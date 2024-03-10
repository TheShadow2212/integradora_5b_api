<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquilino extends Model
{
    use HasFactory;

    protected $table = 'inquilinos';
    protected $primaryKey = 'InquilinoID';
    protected $fillable = ['Nombre', 'Apellido','Cedula','Telefono','Email'];

    public function contratosAlquiler()
    {
        return $this->hasMany(ContratoAlquiler::class, 'InquilinoID');
    }
}
