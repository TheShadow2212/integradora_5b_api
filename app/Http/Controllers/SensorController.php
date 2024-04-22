<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sensor;
use App\Models\Habitacion;
use App\Models\User;
use App\Events\alarma;

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
        
        $sensors = Sensor::where('room_id', $id)
            ->orderBy('date_time', 'desc')
            ->get()
            ->groupBy('name')
            ->map(function($group) {
                return $group->first();
            })
            ->map(function($sensor) use ($usuario) {
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

    public function alarmaActiva($id) {
        $habitacion = Habitacion::findOrFail($id);
        $habitacion->alarma = true;
        $habitacion->save();
        event(new alarma($id));
        return response()->json(['msg' => 'Alarma activada'], 200);
    }

    public function apagarAlarma($id) {
        $habitacion = Habitacion::findOrFail($id);
        $habitacion->alarma = false;
        $habitacion->save();
    }

    public function estadoAlarma($id) {
        $habitacion = Habitacion::findOrFail($id);
        return response()->json($habitacion->alarma, 200);
    }
}
