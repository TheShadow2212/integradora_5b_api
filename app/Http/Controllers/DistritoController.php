<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Distrito;
use App\Models\Ciudad;

class DistritoController extends Controller
{
    public function index()
    {
        $distritos = Distrito::all()->map(function ($distritos) {
            $ciudad = Ciudad::find($distritos->CiudadID);
            return [
                'id' => $distritos -> DistritoID,
                'Nombre' =>$distritos -> Nombre,
                'Ciudad' =>$ciudad -> Nombre
            ];
        });

        return response()->json($distritos);
    }

    public function show($id)
    {
        return Distrito::find($id);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'Nombre' => 'required|string|max:50',
            'CiudadID' => 'required|integer',
        ]);

        $distrito = Distrito::create($request->all());

        return response()->json($distrito, 201);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'Nombre' => 'required|string|max:50',
            'CiudadID' => 'required|integer',
        ]);

        $distrito = Distrito::findOrFail($id);
        $distrito->update($request->all());

        return response()->json($distrito, 200);
    }

    public function delete($id)
    {
        Distrito::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }    
}
