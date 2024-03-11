<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UsuarioMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  mixed  ...$roles
     */ 
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $role = intval($request->header('Role-Id'));

        $allowedRoles = array_map('intval', $roles);

        if (!in_array($role, $allowedRoles)) {
            return response()->json(['error' => 'El usuario no tiene permiso para acceder a esta ruta.'], 403);
        }

        return $next($request);
    }
}
