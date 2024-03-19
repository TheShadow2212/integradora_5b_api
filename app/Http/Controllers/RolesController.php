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
        DB::enableQueryLog();

        $roles = Role::all()->map(function ($roles) {
            return [
                'id' => $roles -> id,
                'name' =>$roles -> name,
            ];
        });
        
        $queries = DB::getQueryLog();
        $lastQuery = $queries[0];

        Interaction::on('mongodb')->create([
            'user_id' => auth()->user()->id, 
            'route' => $request->path(),
            'interaction_type' => $request->method(),
            'interaction_query' => $lastQuery['query'],
            'interaction_date' => Carbon::now()->toDateString(),
            'interaction_time' => Carbon::now()->toTimeString(),
        ]);
        
        return response()->json($roles);
    }

}
