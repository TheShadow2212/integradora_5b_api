<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'notificacion_data';

    protected $fillable = ['_id', 'room_id', 'type', 'data','emergency']; 

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->timestamps = false;
    }
}
