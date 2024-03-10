<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;
    protected $table = 'regiones';
    protected $primaryKey = 'RegionID';
    protected $fillable = ['Nombre', 'ID_País'];

    public function regiones()
    {
        return $this->belongsTo(Pais::class, 'PaisID');
    }

    public function ciudades()
    {
        return $this->hasMany(Ciudad::class, 'RegionID');
    }
}
