<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Interaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Inquilino;

class InquilinoController extends Controller
{
    public function index(Request $request)
    {

        $inquilinos = Inquilino::all()->map(function ($inquilinos) {
            return [
                'id' => $inquilinos -> id,
                'Nombre' =>$inquilinos -> nombre,
                'Apellido' =>$inquilinos -> apellido,
                'Cedula' =>$inquilinos -> cedula,
                'Telefono' =>$inquilinos -> telefono,
                'Email' =>$inquilinos -> email
            ];
        });

        return response()->json($inquilinos);
    }

    public function show($id)
    {
        return Inquilino::find($id);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'Nombre' => 'required|string|max:50',
            'Apellido' => 'required|string|max:50',
            'Cedula' => 'required|string|max:13',
            'Telefono' => 'required|string|max:15',
            'Email' => 'required|string|max:50'
        ]);

        $inquilino = Inquilino::create($request->all());

        return response()->json($inquilino, 201);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'Nombre' => 'required|string|max:50',
            'Apellido' => 'required|string|max:50',
            'Cedula' => 'required|string|max:13',
            'Telefono' => 'required|string|max:15',
            'Email' => 'required|string|max:50'
        ]);

        $inquilino = Inquilino::findOrFail($id);
        $inquilino->update($request->all());

        return response()->json($inquilino, 200);
    }

    public function delete(Request $request, $id)
    {
        $inquilino = Inquilino::findOrFail($id);
    
        $inquilino->delete();
    
        return response()->json('Deleted Successfully', 200);
    }
}
