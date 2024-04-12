<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\Authenticate;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'authenticate', 'verifyEmail']]);
    }

    public function verifyEmail(Request $request, $id) 
    {
        if (! $request->hasValidSignature()) {
            abort(401);
        }
    
        $user = User::findOrFail($id);
        $user->email_verified_at = now();
        $user->save();
    
        return view('emailVerified');
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        $user = User::where('email', $credentials['email'])->first();

        if ($user && ! $user->hasVerifiedEmail()) {
            return response()->json(['error' => 'Email not verified'], 401);
        }

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    public function authenticate(Request $request)
    {
        $code = Str::random(6);
        $email = $request->input('email');
    
        try {
            Mail::to($email)->send(new Authenticate($code));
            return response()->json(['message' => 'Mail sent successfully', 'code' => $code]);
        } catch (\Exception $e) {
            return response()->json(['email' => $email, 'message' => 'Failed to send mail', 'error' => $e->getMessage()], 500);
        }
    }

    public function verificar()
    {
        return response()->json(['message' => 'Verificado']);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $user = auth()->user();
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'role_id' => $user->role_id,
        ]);
    }
}
