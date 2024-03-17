<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Distrito;
use App\Models\Ciudad;
use Illuminate\Http\Request;
use App\Models\Interaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DistritoController extends Controller
{
    public function index(Request $request)
    {
        DB::enableQueryLog();

        $distritos = Distrito::all()->map(function ($distritos) {
            $ciudad = Ciudad::find($distritos->CiudadID);
            return [
                'id' => $distritos -> DistritoID,
                'Nombre' =>$distritos -> Nombre,
                'Ciudad' =>$ciudad -> Nombre
            ];
        });

        $queries = DB::getQueryLog();
        $lastQuery = end($queries);

        Interaction::on('mongodb')->create([
            'route' => 'api/distritos',
            'interaction_type' => $request->method(),
            'interaction_query' => $lastQuery['query'],
            'interaction_date' => Carbon::now()->toDateString(),
            'interaction_time' => Carbon::now()->toTimeString(),
        ]);

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

        Interaction::on('mongodb')->create([
            'user_id' => auth()->user()->id, 
            'route' => $request->path(),
            'interaction_type' => $request->method(),
            'interaction_query' => $distrito->toArray(), 
            'interaction_date' => Carbon::now()->toDateString(),
            'interaction_time' => Carbon::now()->toTimeString(),
        ]);

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

        Interaction::on('mongodb')->create([
            'user_id' => auth()->user()->id, 
            'route' => $request->path(),
            'interaction_type' => $request->method(),
            'interaction_query' => $distrito->toArray(), 
            'interaction_date' => Carbon::now()->toDateString(),
            'interaction_time' => Carbon::now()->toTimeString(),
        ]);

        return response()->json($distrito, 200);
    }

    public function delete(Request $request,$id)
    {
        $distrito = Distrito::findOrFail($id);

        Interaction::on('mongodb')->create([
            'user_id' => auth()->user()->id, 
            'route' => $request->path(),
            'interaction_type' => $request->method(),
            'interaction_query' => $distrito->toArray(), 
            'interaction_date' => Carbon::now()->toDateString(),
            'interaction_time' => Carbon::now()->toTimeString(),
        ]);

        $distrito->delete();

        return response()->json('Deleted Successfully', 200);
    }    
}
