<?php

namespace App\Http\Controllers;

use App\Models\Ciudad;
use App\Models\Region;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Interaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CiudadController extends Controller
{
    public function index(Request $request)
    {
        DB::enableQueryLog();

        $ciudades = Ciudad::all()->map(function ($ciudades) {
            $region = Region::find($ciudades->RegionID);
            return [
                'id' => $ciudades -> CiudadID,
                'Nombre' =>$ciudades -> Nombre,
                'Region' =>$region -> Nombre,
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

        return response()->json($ciudades);
    }

    public function show($id)
    {
        return Ciudad::find($id);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'Nombre' => 'required|string|max:50',
            'RegionID' => 'required|integer',
        ]);

        $ciudad = Ciudad::create($request->all());

        Interaction::on('mongodb')->create([
            'user_id' => auth()->user()->id, 
            'route' => $request->path(),
            'interaction_type' => $request->method(),
            'interaction_query' => $ciudad->toArray(), 
            'interaction_date' => Carbon::now()->toDateString(),
            'interaction_time' => Carbon::now()->toTimeString(),
        ]);

        return response()->json($ciudad, 201);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'Nombre' => 'required|string|max:50',
            'RegionID' => 'required|integer',
        ]);

        $ciudad = Ciudad::findOrFail($id);
        $ciudad->update($request->all());

        Interaction::on('mongodb')->create([
            'user_id' => auth()->user()->id, 
            'route' => $request->path(),
            'interaction_type' => $request->method(),
            'interaction_query' => $ciudad->toArray(), 
            'interaction_date' => Carbon::now()->toDateString(),
            'interaction_time' => Carbon::now()->toTimeString(),
        ]);

        return response()->json($ciudad, 200);
    }

    public function delete(Request $request,$id)
    {
        $ciudad = Ciudad::findOrFail($id);

        Interaction::on('mongodb')->create([
            'user_id' => auth()->user()->id, 
            'route' => $request->path(),
            'interaction_type' => $request->method(),
            'interaction_query' => $ciudad->toArray(), 
            'interaction_date' => Carbon::now()->toDateString(),
            'interaction_time' => Carbon::now()->toTimeString(),
        ]);

        $ciudad->delete();

        return response()->json('Deleted Successfully', 200);
    }
}
