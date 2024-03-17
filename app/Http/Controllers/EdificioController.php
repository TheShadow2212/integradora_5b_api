<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Interaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Edificio;
use App\Models\Calle;

class EdificioController extends Controller
{
    public function index(Request $request)
    {
        DB::enableQueryLog();

        $edificios = Edificio::all()->map(function ($edificios) {
            $calle = Calle::find($edificios->CalleID);
            return [
                'id' => $edificios -> EdificioID,
                'Nombre' =>$edificios -> Nombre,
                'Calle' =>$calle -> Nombre
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

        Interaction::on('mongodb')->create([
            'user_id' => auth()->user()->id, 
            'route' => $request->path(),
            'interaction_type' => $request->method(),
            'interaction_query' => $edificio->toArray(), 
            'interaction_date' => Carbon::now()->toDateString(),
            'interaction_time' => Carbon::now()->toTimeString(),
        ]);

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

        Interaction::on('mongodb')->create([
            'user_id' => auth()->user()->id, 
            'route' => $request->path(),
            'interaction_type' => $request->method(),
            'interaction_query' => $edificio->toArray(), 
            'interaction_date' => Carbon::now()->toDateString(),
            'interaction_time' => Carbon::now()->toTimeString(),
        ]);

        return response()->json($edificio, 200);
    }

    public function delete($id)
    {
        $edificio = Edificio::findOrFail($id);

        Interaction::on('mongodb')->create([
            'user_id' => auth()->user()->id, 
            'route' => $request->path(),
            'interaction_type' =>$request->method(),
            'interaction_query' => $edificio->toArray(), 
            'interaction_date' => Carbon::now()->toDateString(),
            'interaction_time' => Carbon::now()->toTimeString(),
        ]);

        $edificio->delete();

        return response()->json('Deleted Successfully', 200);
    }
}
