<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barrio;
use App\Models\Distrito;

class BarrioController extends Controller
{
    public function index()
    {
        $barrios = Barrio::all()->map(function ($barrios) {
            $distrito = Distrito::find($barrios->DistritoID);
            return [
                'id' => $barrios -> BarrioID,
                'Nombre' =>$barrios -> Nombre,
                'Distrito' =>$distrito -> Nombre
            ];
        });

        return response()->json($barrios);
    }

    public function show($id)
    {
        return Barrio::find($id);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'Nombre' => 'required|string|max:50',
            'DistritoID' => 'required|integer',
        ]);

        $barrio = Barrio::create($request->all());

        return response()->json($barrio, 201);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'Nombre' => 'required|string|max:50',
            'DistritoID' => 'required|integer',
        ]);

        $barrio = Barrio::findOrFail($id);
        $barrio->update($request->all());

        return response()->json($barrio, 200);
    }

    public function delete($id)
    {
        Barrio::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }    
}
