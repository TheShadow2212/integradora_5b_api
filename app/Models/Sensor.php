<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Sensor extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'sensor_data';

    protected $fillable = ['id', 'name', 'room_id', 'data']; 


    use HasFactory;
}
