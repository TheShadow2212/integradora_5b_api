<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Interaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\ContratoAlquiler;
use App\Models\Apartamento;
use App\Models\Inquilino;
use Exception;


class ContratoAlquilerController extends Controller
{
    public function index(Request $request)
    {
        DB::enableQueryLog();

        $contratoAlquiler = ContratoAlquiler::all()->map(function ($contratoAlquiler) {
            $apartamento = Apartamento::find($contratoAlquiler->ApartamentoID);
            $inquilino = Inquilino::find($contratoAlquiler->InquilinoID);

            return [
                'id' => $contratoAlquiler -> ContratoID,
                'Fecha_Inicio' =>$contratoAlquiler -> Fecha_Inicio,
                'Fecha_Final' =>$contratoAlquiler -> Fecha_Final,
                'Monto' =>$contratoAlquiler -> Monto,
                'Inquilino' =>$inquilino -> Nombre,
                'Apartamento' =>$apartamento -> Nombre
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

        return response()->json($contratoAlquiler);
    }

    public function show($id)
    {
        return ContratoAlquiler::find($id);
    }

    public function create(Request $request)
    {
        try {
        $this->validate($request, [
            'Fecha_Inicio' => 'required|date',
            'Fecha_Final' => 'required|date',
            'Monto' => 'required|numeric',
            'InquilinoID' => 'required|integer',
            'ApartamentoID' => 'required|integer',
        ]);

        $contratoAlquiler = ContratoAlquiler::create($request->all());

        Interaction::on('mongodb')->create([
            'user_id' => auth()->user()->id, 
            'route' => $request->path(),
            'interaction_type' => $request->method(),
            'interaction_query' => $contratoAlquiler->toArray(),
            'interaction_date' => Carbon::now()->toDateString(),
            'interaction_time' => Carbon::now()->toTimeString(),
        ]);

        return response()->json($contratoAlquiler, 201);
        }
        catch(Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
       try {
        $this->validate($request, [
            'Fecha_Inicio' => 'required|date',
            'Fecha_Final' => 'required|date',
            'Monto' => 'required|numeric',
            'InquilinoID' => 'required|integer',
            'ApartamentoID' => 'required|integer',
        ]);

        $contratoAlquiler = ContratoAlquiler::findOrFail($id);
        $contratoAlquiler->update($request->all());

        Interaction::on('mongodb')->create([
            'user_id' => auth()->user()->id, 
            'route' => $request->path(),
            'interaction_type' => $request->method(),
            'interaction_query' => $contratoAlquiler->toArray(),
            'interaction_date' => Carbon::now()->toDateString(),
            'interaction_time' => Carbon::now()->toTimeString(),
        ]);

        return response()->json($contratoAlquiler, 200);
       }
       catch(Exception $e){
        return response()->json(['error' => $e->getMessage()], 500);
       }
    }

    public function delete(Request $request, $id)
    {
        $contratoAlquiler = ContratoAlquiler::findOrFail($id);

        Interaction::on('mongodb')->create([
            'user_id' => auth()->user()->id, 
            'route' => $request->path(),
            'interaction_type' =>$request->method(),
            'interaction_query' => $contratoAlquiler->toArray(), 
            'interaction_date' => Carbon::now()->toDateString(),
            'interaction_time' => Carbon::now()->toTimeString(),
        ]);

        $contratoAlquiler->delete();

        return response()->json('Deleted Successfully', 200);
    }
}
