<?php

namespace App\Http\Controllers;
use App\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::all()->map(function ($roles) {
            return [
                'id' => $roles -> id,
                'name' =>$roles -> name,
            ];
        });
        return response()->json($roles);
    }

}
