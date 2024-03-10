<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContratoAlquiler;

class ContratoAlquilerController extends Controller
{
    public function index()
    {
        return ContratoAlquiler::all();
    }

    public function show($id)
    {
        return ContratoAlquiler::find($id);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'FechaInicio' => 'required|date',
            'FechaFin' => 'required|date',
            'Monto' => 'required|numeric',
            'InquilinoID' => 'required|integer',
            'ApartamentoID' => 'required|integer',
        ]);

        $contratoAlquiler = ContratoAlquiler::create($request->all());

        return response()->json($contratoAlquiler, 201);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'FechaInicio' => 'required|date',
            'FechaFin' => 'required|date',
            'Monto' => 'required|numeric',
            'InquilinoID' => 'required|integer',
            'ApartamentoID' => 'required|integer',
        ]);

        $contratoAlquiler = ContratoAlquiler::findOrFail($id);
        $contratoAlquiler->update($request->all());

        return response()->json($contratoAlquiler, 200);
    }

    public function delete($id)
    {
        ContratoAlquiler::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
