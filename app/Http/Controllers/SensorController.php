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
        $sensor->room_id = intval($request->room_id);
        $sensor->date_time = \Carbon\Carbon::now()->toDateTimeString();
        $sensor->save();
        return response()->json(['msg' => 'Registrado correctamente', 'sensor' => $sensor], 200);
    }


    public function getSensorsByRoomId(Request $request, $id)
    {
        $id = (int)$id;
        $usuario = $request->user();
    
        $room = Habitacion::find($id);
        if ($room === null) {
            return response()->json(['error' => 'Habitación no encontrada'], 404);
        }
    
        if ($room->usuario_id != $usuario->id) {
            return response()->json(['error' => 'Habitación no accesible'], 403);
        }
        
        $sensors = Sensor::where('room_id', $id)
        ->orderBy('date_time', 'desc')
        ->get()
        ->groupBy('name')
        ->map(function($group) {
            return $group->first();
        })
        ->map(function($sensor) {
            return [
                'name' => $sensor->name,
                'data' => strval(is_numeric($sensor->data) ? round($sensor->data, 2) : $sensor->data),
            ];
        })
        ->values();
    
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

    public function estadoAlarma() {
        $habitaciones = Habitacion::where('alarma', true)->pluck('id');
    
        if ($habitaciones->isEmpty()) {
            return response()->json(['status' => false], 200);
        }
    
        return response()->json(['status' => true, 'habitaciones' => $habitaciones], 200);
    }
}
