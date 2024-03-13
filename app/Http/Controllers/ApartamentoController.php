<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartamento;
use App\Models\Edificio;

class ApartamentoController extends Controller
{
    public function index()
    {
        $apartamentos = Apartamento::all()->map(function ($apartamentos) {
            $edificio = Edificio::find($apartamentos->EdificioID);
            return [
                'id' => $apartamentos -> ApartamentoID,
                'Nombre' =>$apartamentos -> Nombre,
                'Edificio' =>$edificio -> Nombre,
                'Descripcion' =>$apartamentos -> Descripcion,
                'Estado' =>$apartamentos -> Estado
            ];
        });

        return response()->json($apartamentos);
    }

    public function show($id)
    {
        return Apartamento::find($id);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'Nombre' => 'required|string|max:50',
            'EdificioID' => 'required|integer',
            'Descripcion' => 'required|string|max:255',
            'Estado' => 'required|integer',
        ]);

        $apartamento = Apartamento::create($request->all());

        return response()->json($apartamento, 201);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'Nombre' => 'required|string|max:50',
            'EdificioID' => 'required|integer',
            'Descripcion' => 'required|string|max:255',
            'Estado' => 'required|integer',
        ]);

        $apartamento = Apartamento::findOrFail($id);
        $apartamento->update($request->all());

        return response()->json($apartamento, 200);
    }

    public function delete($id)
    {
        Apartamento::findOrFail($id)->delete();
        return response()->json('Deleted Successfully', 200);
    }
}
