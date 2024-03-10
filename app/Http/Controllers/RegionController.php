<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function index()
    {
        return Region::all();
    }

    public function show($id)
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

        return response()->json($region, 200);
    }

    public function delete($id)
    {
        Region::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
