<?php

namespace App\Http\Controllers;

use App\Models\Pais;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Interaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PaisController extends Controller
{
    public function index(Request $request )
    {
        DB::enableQueryLog();

        $paises = Pais::all()->map(function ($paises) {
            return [
                'id' => $paises -> PaisID,
                'Nombre' =>$paises -> Nombre
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
        
        return response()->json($paises);
    }

    public function show(Request $request, $id)
    {
        DB::enableQueryLog();

        $pais = Pais::find($id);

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

        return $pais;
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'Nombre' => 'required|string|max:50',
        ]);

        $pais = Pais::create($request->all());
    
        Interaction::on('mongodb')->create([
            'user_id' => auth()->user()->id, 
            'route' => $request->path(),
            'interaction_type' => $request->method(),
            'interaction_query' => $pais->toArray(), 
            'interaction_date' => Carbon::now()->toDateString(),
            'interaction_time' => Carbon::now()->toTimeString(),
        ]);

        return response()->json($pais, 201);
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'Nombre' => 'required|string|max:50',
        ]);

        $pais = Pais::findOrFail($id);
        $pais->update($request->all());

        Interaction::on('mongodb')->create([
            'user_id' => auth()->user()->id, 
            'route' => $request->path(),
            'interaction_type' => $request->method(),
            'interaction_query' => $pais->toArray(), 
            'interaction_date' => Carbon::now()->toDateString(),
            'interaction_time' => Carbon::now()->toTimeString(),
        ]);

        return response()->json($pais, 200);
    }

    public function delete(Request $request, $id)
    {
        $pais = Pais::findOrFail($id);
    
        Interaction::on('mongodb')->create([
            'user_id' => auth()->user()->id, 
            'route' => $request->path(),
            'interaction_type' => $request->method(),
            'interaction_query' => $pais->toArray(), 
            'interaction_date' => Carbon::now()->toDateString(),
            'interaction_time' => Carbon::now()->toTimeString(),
        ]);

        $pais->delete();

        return response()->json('Deleted Successfully', 200);
    }
}
