<?php

namespace App\Http\Controllers;

use App\Models\Pais;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaisController extends Controller
{
    public function index()
    {
        return Pais::all();
    }

    public function show($id)
    {
        return Pais::find($id);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'Nombre' => 'required|string|max:50',
        ]);

        $pais = Pais::create($request->all());

        return response()->json($pais, 201);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'Nombre' => 'required|string|max:50',
        ]);

        $pais = Pais::findOrFail($id);
        $pais->update($request->all());

        return response()->json($pais, 200);
    }

    public function delete($id)
    {
        Pais::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
