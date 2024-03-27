<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Habitacion;
use App\Models\User;

class HabitacionController extends Controller
{
    public function index(Request $request)
    {
        $habitaciones = Habitacion::all()->map(function ($habitaciones) {
            $usuario = User::find($habitaciones->usuarioID);
            return [
                'id' => $habitaciones->HabitacionID,
                'nombre' =>$habitaciones->nombre,
                'status' =>$habitaciones->status,
                'usuario' =>$usuario->nombre . ' (' . $usuario->email . ')',
            ];
        });
    
        return response()->json($habitaciones, 200);
    }

    public function show($id)
    {
        $habitacion = Habitacion::find($id);
        if ($habitacion) {
            $usuario = User::find($habitacion->usuarioID);
            return response()->json([
                'id' => $habitacion->HabitacionID,
                'nombre' => $habitacion->nombre,
                'status' => $habitacion->status,
                'usuario' => $usuario->nombre . ' (' . $usuario->email . ')',
            ], 200); 
        } else {
            return response()->json(['error' => 'Habitación no encontrada'], 404); 
        }
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required|string|max:50',
            'status' => 'required|string|max:50',
            'usuarioID' => 'required|string|max:50'
        ]);
    
        $habitacion = Habitacion::create($request->all());
    
        if ($habitacion) {
            return response()->json($habitacion, 201); 
        } else {
            return response()->json(['error' => 'Error al crear la habitación'], 500); 
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nombre' => 'required|string|max:50',
            'status' => 'required|string|max:50',
            'usuarioID' => 'required|string|max:50'
        ]);
    
        $habitacion = Habitacion::find($id);
        if ($habitacion) {
            $habitacion->update($request->all());
            return response()->json($habitacion, 200); 
        } else {
            return response()->json(['error' => 'Habitación no encontrada'], 404); 
        }
    }
    
    public function delete($id)
    {
        $habitacion = Habitacion::find($id);
    
        if ($habitacion) {
            $habitacion->delete();
            return response()->json(null, 204); 
        } else {
            return response()->json(['error' => 'Habitación no encontrada'], 404); 
        }
    }
}
