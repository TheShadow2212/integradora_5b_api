<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Habitacion;
use App\Models\User;

class HabitacionController extends Controller
{
    public function index(Request $request)
    {
        $usuario = $request->user();
    
        $habitaciones = Habitacion::where('usuario_id', $usuario->id)->get()->map(function ($habitaciones) {
            return [
                'id' => $habitaciones->id,
                'nombre' =>$habitaciones->nombre,
                'status' =>$habitaciones->status,
                'usuario' =>$habitaciones->usuario_id,
            ];
        });
    
        return response()->json($habitaciones, 200);
    }

    public function show($id)
    {
        $habitacion = Habitacion::find($id);
        if ($habitacion) {
            return response()->json([
                'id' => $habitacion->id,
                'nombre' => $habitacion->nombre,
                'status' => $habitacion->status,
                'usuario' => $habitacion->usuario_id,
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
            'usuario_id' => 'required|string|max:50'
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
        $habitacion = Habitacion::findOrFail($id);

        if($habitacion){
            $habitacion->delete();

            return response()->json('Deleted Successfully', 200);
        }
        else{
            return response()->json(['error' => 'Habitación no encontrada'], 404);
        }
    
    }
}
