<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calle extends Model
{
    use HasFactory;
    protected $table = 'calles';
    protected $primaryKey = 'Calle';
    protected $fillable = ['Nombre', 'BarrioID'];

    public function calles()
    {
        return $this->belongsTo(Barrio::class, 'BarrioID');
    }

    public function edificios()
    {
        return $this->hasMany(Edificio::class, 'CalleID');
    }
}
