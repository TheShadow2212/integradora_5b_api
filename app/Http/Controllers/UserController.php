<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\emailVerify;
use Illuminate\Support\Facades\URL;

class UserController extends Controller
{
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:15|min:3',
            'email' => 'required|email|max:70|unique:users',
            'password' => 'required|min:8|max:12',
        ]);
    
        $user = new User;
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = bcrypt($validatedData['password']);
        $user->save();

        $url = URL::signedRoute('verification.email', ['id' => $user->id]);
        Mail::to($user->email)->send(new emailVerify($url));
    
        return response()->json($user, 201);
    }


}
