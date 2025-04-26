<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    /**
     * Kullanıcı kayıt işlemi
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password,
        ]);
    
        $token = $user->createToken('api_token')->plainTextToken;
    
        return response()->json([
            'user'  => $user,
            'token' => $token
        ]);
     
    }

    /**
     * Giriş işlemi
     */
    public function login(LoginRequest $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Geçersiz giriş bilgileri'], 401);
        }

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'message' => 'Giriş başarılı',
            'user'    => $user,
            'token'   => $token
        ]);
    }

    /**
     * Çıkış işlemi (token iptali)
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Çıkış yapıldı'
        ]);
    }
}
