<?php

namespace App\Http\Controllers;
use App\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Interaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class RolesController extends Controller
{
    public function index(Request $request)
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
