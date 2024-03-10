<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    use HasFactory;
    protected $table = 'paises';
    protected $primaryKey = 'PaisID';
    protected $fillable = ['Nombre'];

    public function paises()
    {
        return $this->hasMany(Region::class, 'PaisID');
    }
}
