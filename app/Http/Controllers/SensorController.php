<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sensor;

class SensorController extends Controller
{
    public function getSensorsByRoomId($id)
    {
        $id = (int)$id;

        $sensors = Sensor::where('room_id', $id)->get()->map(function($sensor) {
            return [
                'name' => $sensor->name,
                'data' => $sensor->data,
            ];
        });
        return response()->json($sensors);
    }
}
