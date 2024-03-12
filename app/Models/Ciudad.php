<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    use HasFactory;
    protected $table = 'ciudades';
    protected $primaryKey = 'CiudadID';
    protected $fillable = ['Nombre', 'RegionID'];

    public function ciudades()
    {
        return $this->belongsTo(Region::class, 'RegionID');
    }

    public function distritos()
    {
        return $this->hasMany(Distrito::class, 'CiudadID');
    }
}
