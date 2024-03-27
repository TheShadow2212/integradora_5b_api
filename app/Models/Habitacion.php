<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{
    use HasFactory;
    protected $table = 'habitaciones';
    protected $primaryKey = 'HabitacionID';
    protected $filleable = ['nombre','status','usuarioID'];
    protected $hidden = ['updated_at', 'created_at'];


    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuarioID');
    }
}
