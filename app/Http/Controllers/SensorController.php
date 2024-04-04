<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sensor;
use App\Models\Habitacion;
use App\Models\User;

class SensorController extends Controller
{

    public function create(Request $request)
    {
        $sensor = new Sensor();
        $sensor->name = $request->name;
        $sensor->data = $request->data;
        $sensor->room_id = $request->room_id;
        $sensor->date_time = \Carbon\Carbon::now()->toDateTimeString();
        $sensor->save();
        return response()->json(['msg' => 'Registrado correctamente', 'sensor' => $sensor], 200);
    }


    public function getSensorsByRoomId(Request $request, $id)
    {
        $usuario = $request->user();
        $id = (int)$id;

        $sensors = Sensor::where('room_id', $id)->get()->map(function($sensor) use ($usuario) {
            $room = Habitacion::find($sensor->room_id);
            if ($room->usuario_id == $usuario->id)
            {
                return [
                    'name' => $sensor->name,
                    'data' => $sensor->data,
                ];
            }
        });

        $sensors = $sensors->filter()->values();

        if ($sensors->isEmpty()) {
            return response()->json([]);
        }

        return response()->json($sensors);
    }
}
