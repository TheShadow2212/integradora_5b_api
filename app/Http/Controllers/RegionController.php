<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\Pais;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Interaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RegionController extends Controller
{
    public function index(Request $request )
    {
        DB::enableQueryLog();

        $regiones = Region::all()->map(function ($regiones) {
            $pais = Pais::find($regiones->PaisID);
            return [
                'id' => $regiones -> RegionID,
                'Nombre' =>$regiones -> Nombre,
                'Pais' =>$pais->Nombre,
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

        return response()->json($regiones);
    }

    public function show(Request $request,$id)
    {
        return Region::find($id);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'Nombre' => 'required|string|max:50',
            'PaisID' => 'required|integer',
        ]);

        $region = Region::create($request->all());

        Interaction::on('mongodb')->create([
            'user_id' => auth()->user()->id, 
            'route' => $request->path(),
            'interaction_type' => $request->method(),
            'interaction_query' => $region->toArray(), 
            'interaction_date' => Carbon::now()->toDateString(),
            'interaction_time' => Carbon::now()->toTimeString(),
        ]);

        return response()->json($region, 201);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'Nombre' => 'required|string|max:50',
            'PaisID' => 'required|integer',
        ]);

        $region = Region::findOrFail($id);
        $region->update($request->all());

        Interaction::on('mongodb')->create([
            'user_id' => auth()->user()->id, 
            'route' => $request->path(),
            'interaction_type' => $request->method(),
            'interaction_query' => $region->toArray(), 
            'interaction_date' => Carbon::now()->toDateString(),
            'interaction_time' => Carbon::now()->toTimeString(),
        ]);

        return response()->json($region, 200);
    }

    public function delete(Request $request,$id)
    {

        $region = Region::findOrFail($id);

        Interaction::on('mongodb')->create([
            'user_id' => auth()->user()->id, 
            'route' => $request->path(),
            'interaction_type' => $request->method(),
            'interaction_query' => $region->toArray(), 
            'interaction_date' => Carbon::now()->toDateString(),
            'interaction_time' => Carbon::now()->toTimeString(),
        ]);

        $region->delete();

        return response()->json('Deleted Successfully', 200);
    }
}
