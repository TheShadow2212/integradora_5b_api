<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'invalid token'], 401);
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'expired token'], 401);
        } catch (JWTException $e) {
            return response()->json(['status' => 'token not found or could not be parsed'], 401);
        } catch (Exception $e) {
            return response()->json(['status' => 'unknown error'], 500);
        }
        return $next($request);
    }
}