<?php

namespace App\Http\Controllers;

use App\Models\Ciudad;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CiudadController extends Controller
{
    public function index()
    {
        return Ciudad::all();
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

        return response()->json($ciudad, 200);
    }

    public function delete($id)
    {
        Ciudad::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
