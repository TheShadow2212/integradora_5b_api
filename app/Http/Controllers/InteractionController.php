<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Interaction;
use App\Models\User;

class InteractionController extends Controller
{
    public function index()
    {
        $interactions = Interaction::all()->map(function ($interaction) {
            $user = User::find($interaction->user_id); 
            return [
                'Usuario' => $user->name . '(' . $user->email . ')',
                'route' => $interaction->route,
                'interaction_type' => $interaction->interaction_type,
                'interaction_query' => $interaction->interaction_query,
                'interaction_date' => $interaction->interaction_date,
                'interaction_time' => $interaction->interaction_time,
            ];
        });
    
        return response()->json($interactions);
    }
}
