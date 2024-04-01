<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Notification extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'notificacion_data';

    protected $fillable = ['id', 'room_id', 'type', 'data']; 

    use HasFactory;
}
