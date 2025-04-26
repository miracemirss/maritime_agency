<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ShipController;
use App\Http\Controllers\TransitController;   
use App\Http\Controllers\NeedController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\SecurityProcess;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\SecureRequestMiddleware;

// Basit test route
Route::get('/ping', function () {
    return response()->json(['message' => 'pong']);
});

Route::middleware('auth:sanctum')->get('/debug-user', function (Request $request) {
    return response()->json([
        'auth_user' => \Illuminate\Support\Facades\Auth::user(),
        'request_user' => $request->user(),
        'token' => $request->bearerToken(),
    ]);
});


// Giriş ve kayıt işlemleri (Sanctum)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Token doğrulaması gerektiren işlemler
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Giriş yapmış kullanıcı bilgisi örneği
    Route::get('/profile', function (Request $request) {
        return response()->json([
            'user' => $request->user()
        ]);
    });
});

// API kaynak route’ları
Route::apiResource('ships', ShipController::class);
Route::apiResource('transits', TransitController::class);
Route::apiResource('needs', NeedController::class);
Route::apiResource('personnels', PersonnelController::class);

// Secure middleware ile korunan create (POST) işlemleri
Route::middleware([SecureRequestMiddleware::class])->group(function () {
    Route::post('/veriler', [SecurityProcess::class, 'store']);
    
    Route::post('/ships', [ShipController::class, 'store']);
    Route::post('/transits', [TransitController::class, 'store']);
    Route::post('/needs', [NeedController::class, 'store']);
    Route::post('/personnels', [PersonnelController::class, 'store']);
});
