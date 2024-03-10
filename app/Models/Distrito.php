<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{
    use HasFactory;
    protected $table = 'distritos';
    protected $primaryKey = 'DistritoID';
    protected $fillable = ['Nombre', 'CiudadID'];

    public function distritos()
    {
        return $this->belongsTo(Ciudad::class, 'CiudadID');
    }

    public function barrios()
    {
        return $this->hasMany(Barrio::class, 'DistritoID');
    }
}
