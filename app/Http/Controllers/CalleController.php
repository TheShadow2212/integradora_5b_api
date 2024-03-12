<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Calle;
use App\Models\Barrio;


class CalleController extends Controller
{
    public function index()
    {
        $calles = Calle::all()->map(function ($calles) {
            $barrio = Barrio::find($calles->BarrioID);
            return [
                'id' => $calles -> CalleID,
                'Nombre' =>$calles -> Nombre,
                'Barrio' =>$barrio -> Nombre
            ];
        });

        return response()->json($calles);
    }

    public function show($id)
    {
        return Calle::find($id);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'Nombre' => 'required|string|max:50',
            'BarrioID' => 'required|integer',
        ]);

        $calle = Calle::create($request->all());

        return response()->json($calle, 201);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'Nombre' => 'required|string|max:50',
            'BarrioID' => 'required|integer',
        ]);

        $calle = Calle::findOrFail($id);
        $calle->update($request->all());

        return response()->json($calle, 200);
    }

    public function delete($id)
    {
        Calle::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
