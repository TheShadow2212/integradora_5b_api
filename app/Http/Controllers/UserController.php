<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Mail;
use App\Mail\emailVerify;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::all()->map(function ($usuarios) {
            $rol = Role::find($usuarios->role_id);
            return [
                'id' => $usuarios -> id,
                'Nombre' =>$usuarios -> name,
                'Email' =>$usuarios -> email,
                'Rol' =>$rol -> name,
            ];
        });

        return response()->json($usuarios);
    }
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
        $user->password = Hash::make($validatedData['password']);
        $user->role_id = 3;
        $user->save();

        $url = URL::signedRoute('verification.email', ['id' => $user->id]);
        Mail::to($user->email)->send(new emailVerify($url));
    
        return response()->json($user, 201);
    }

    public function show($id)
    {
        return User::find($id);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:70',
            'role_id' => 'required|integer',
        ]);

        $user = User::findOrFail($id);
        $user->update($request->all());

        return response()->json($user, 200);
    }

    public function delete($id)
    {
        User::findOrFail($id)->delete();
        return response()->json('Deleted Successfully', 200);
    }


}
