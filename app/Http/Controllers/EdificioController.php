<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Edificio;

class EdificioController extends Controller
{
    public function index()
    {
        $edificios = Edificio::all()->map(function ($edificios) {
            return [
                'id' => $edificios -> EdificioID,
                'Nombre' =>$edificios -> Nombre,
                'CalleID' =>$edificios -> CalleID
            ];
        });

        return response()->json($edificios);
    }

    public function show($id)
    {
        return Edificio::find($id);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'Nombre' => 'required|string|max:50',
            'CalleID' => 'required|integer',
        ]);

        $edificio = Edificio::create($request->all());

        return response()->json($edificio, 201);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'Nombre' => 'required|string|max:50',
            'CalleID' => 'required|integer',
        ]);

        $edificio = Edificio::findOrFail($id);
        $edificio->update($request->all());

        return response()->json($edificio, 200);
    }

    public function delete($id)
    {
        Edificio::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
