<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RefreshToken;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {

            return response(null, 404);
        }

        Auth::login($user);

        $accessToken = Auth::user()->createToken('access_token')
            ->plainTextToken;

        $refreshToken = Str::random(64);

        RefreshToken::create([
            'user_id' => $user->id,
            'token' => hash('sha256', $refreshToken),
            'expires_at' => Carbon::now()->addDays(config('refreshtoken.expiration_days')),
        ]);

        return response([
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        Auth::user()->currentAccessToken()->delete();

        return response(null, 200);
    }

    public function refreshToken(Request $request) {
        $request->validate([
            'refresh_token' => 'required',
        ]);
    
        $hashedToken = hash('sha256', $request->refresh_token);
    
        $token = RefreshToken::where('token', $hashedToken)->first();
    
        if (!$token || $token->expires_at->isPast()) {
            return response()->json(['message' => 'Invalid refresh token'], 401);
        }
    
        $user = $token->user;
        
        $accessToken = $user->createToken('access_token')->plainTextToken;

        return response()->json([
            'access_token' => $accessToken,
        ]);
    }
}
