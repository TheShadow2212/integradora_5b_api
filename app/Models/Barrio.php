<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barrio extends Model
{
    use HasFactory;
    protected $table = 'barrios';
    protected $primaryKey = 'BarrioID';
    protected $fillable = ['Nombre', 'DistritoID'];

    public function barrios()
    {
        return $this->belongsTo(Distrito::class, 'DistritoID');
    }

    public function calles()
    {
        return $this->hasMany(Calle::class, 'BarrioID');
    }
}
