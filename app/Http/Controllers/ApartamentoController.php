<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Interaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Apartamento;
use App\Models\Edificio;

class ApartamentoController extends Controller
{
    public function index(Request $request)
    {
        DB::enableQueryLog();

        $apartamentos = Apartamento::all()->map(function ($apartamentos) {
            $edificio = Edificio::find($apartamentos->EdificioID);
            $estado = $apartamentos->Estado == 1 ? 'Activo' : 'Inactivo';
            return [
                'id' => $apartamentos -> ApartamentoID,
                'Nombre' =>$apartamentos -> Nombre,
                'Edificio' =>$edificio -> Nombre,
                'Descripcion' =>$apartamentos -> Descripcion,
                'Estado' =>$estado
            ];
        });

        $queries = DB::getQueryLog();
        $lastQuery = end($queries);

        Interaction::on('mongodb')->create([
            'user_id' => auth()->user()->id, 
            'route' => $request->path(),
            'interaction_type' => $request->method(),
            'interaction_query' => $lastQuery['query'],
            'interaction_date' => Carbon::now()->toDateString(),
            'interaction_time' => Carbon::now()->toTimeString(),
        ]);

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

        Interaction::on('mongodb')->create([
            'user_id' => auth()->user()->id, 
            'route' => $request->path(),
            'interaction_type' => $request->method(),
            'interaction_date' => Carbon::now()->toDateString(),
            'interaction_time' => Carbon::now()->toTimeString(),
        ]);

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

        Interaction::on('mongodb')->create([
            'user_id' => auth()->user()->id, 
            'route' => $request->path(),
            'interaction_type' => $request->method(),
            'interaction_date' => Carbon::now()->toDateString(),
            'interaction_time' => Carbon::now()->toTimeString(),
        ]);

        return response()->json($apartamento, 200);
    }

    public function delete(Request $request, $id)
    {
        $apartamento = Apartamento::findOrFail($id);

        Interaction::on('mongodb')->create([
            'user_id' => auth()->user()->id, 
            'route' => $request->path(),
            'interaction_type' => $request->method(),
            'interaction_query' => $apartamento->toArray(),
            'interaction_date' => Carbon::now()->toDateString(),
            'interaction_time' => Carbon::now()->toTimeString(),
        ]);

        $apartamento->delete();

        return response()->json('Deleted Successfully', 200);
    }

    public function apartamentosDisponibles(Request $request)
    {
        $apartamentos = Apartamento::where('Estado', 1)->get()->map(function ($apartamentos) {
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
}
