<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Sensor extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'sensor_data';

    protected $fillable = ['_id', 'name', 'data', 'room_id', 'date_time']; 

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->timestamps = false;
    }
}
