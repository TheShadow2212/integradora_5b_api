<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Interaction extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'interactions';

    protected $fillable = ['user_id', 'route' , 'interaction_type', 'interaction_query', 'interaction_date', 'interaction_time'];

    protected $hidden = ['updated_at', 'created_at'];

    use HasFactory;
}
