<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Edificio extends Model
{
    use HasFactory;
    protected $table = 'edificios';
    protected $primaryKey = 'Edificio';
    protected $fillable = ['Nombre', 'CalleID'];

    public function edificios()
    {
        return $this->belongsTo(Calle::class, 'CalleID');
    }

    public function apartamentos()
    {
        return $this->hasMany(Apartamento::class, 'EdificioID');
    }
}
