<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Interaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Barrio;
use App\Models\Distrito;

class BarrioController extends Controller
{
    public function index(Request $request)
    {
        DB::enableQueryLog();
        
        $barrios = Barrio::all()->map(function ($barrios) {
            $distrito = Distrito::find($barrios->DistritoID);
            return [
                'id' => $barrios -> BarrioID,
                'Nombre' =>$barrios -> Nombre,
                'Distrito' =>$distrito -> Nombre
            ];
        });

        $queries = DB::getQueryLog();
        $lastQuery = end($queries);

        Interaction::on('mongodb')->create([
            'user_id' => auth()->user()->id, 
            'route' => 'api/barrios',
            'interaction_type' => $request->method(),
            'interaction_query' => $lastQuery['query'],
            'interaction_date' => Carbon::now()->toDateString(),
            'interaction_time' => Carbon::now()->toTimeString(),
        ]);

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

        Interaction::on('mongodb')->create([
            'user_id' => auth()->user()->id, 
            'route' => $request->path(),
            'interaction_type' => $request->method(),
            'interaction_query' => $barrio->toArray(), 
            'interaction_date' => Carbon::now()->toDateString(),
            'interaction_time' => Carbon::now()->toTimeString(),
        ]);

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

        Interaction::on('mongodb')->create([
            'user_id' => auth()->user()->id, 
            'route' => $request->path(),
            'interaction_type' => $request->method(),
            'interaction_query' => $barrio->toArray(), 
            'interaction_date' => Carbon::now()->toDateString(),
            'interaction_time' => Carbon::now()->toTimeString(),
        ]);

        return response()->json($barrio, 200);
    }

    public function delete(Request $request, $id)
    {
        $barrio = Barrio::findOrFail($id);

        Interaction::on('mongodb')->create([
            'user_id' => auth()->user()->id, 
            'route' => $request->path(),
            'interaction_type' => $request->method(),
            'interaction_query' => $barrio->toArray(), 
            'interaction_date' => Carbon::now()->toDateString(),
            'interaction_time' => Carbon::now()->toTimeString(),
        ]);

        $barrio->delete();

        return response()->json('Deleted Successfully', 200);
    }    
}
