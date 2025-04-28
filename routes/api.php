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

// Kullanıcı login/register
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Login sonrası işlemler
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::get('/profile', function (Request $request) {
        return response()->json(['user' => $request->user()]);
    });
});

// API kaynak route’ları (GET, SHOW, DELETE serbest)
Route::apiResource('ships', ShipController::class)->only(['index', 'show', 'destroy']);
Route::apiResource('transits', TransitController::class)->only(['index', 'show', 'destroy']);
Route::apiResource('needs', NeedController::class)->only(['index', 'show', 'destroy']);
Route::apiResource('personnels', PersonnelController::class)->only(['index', 'show', 'destroy']);

// POST ve PUT/PATCH işlemlerine güvenlik kontrolü
Route::middleware(['auth:sanctum', 'ip.ban', SecureRequestMiddleware::class])->group(function () {
    // Ships
    Route::post('/ships', [ShipController::class, 'store']);
    Route::put('/ships/{ship}', [ShipController::class, 'update']);
    Route::patch('/ships/{ship}', [ShipController::class, 'update']);
    
    // Transits
    Route::post('/transits', [TransitController::class, 'store']);
    Route::put('/transits/{transit}', [TransitController::class, 'update']);
    Route::patch('/transits/{transit}', [TransitController::class, 'update']);
    
    // Needs
    Route::post('/needs', [NeedController::class, 'store']);
    Route::put('/needs/{need}', [NeedController::class, 'update']);
    Route::patch('/needs/{need}', [NeedController::class, 'update']);
    
    // Personnels
    Route::post('/personnels', [PersonnelController::class, 'store']);
    Route::put('/personnels/{personnel}', [PersonnelController::class, 'update']);
    Route::patch('/personnels/{personnel}', [PersonnelController::class, 'update']);
    
    // Diğer özel işlem
    Route::post('/veriler', [SecurityProcess::class, 'store']);
});

// Test amaçlı özel endpoint
Route::post('/test-suspicious', function (Request $request) {
    return response()->json([
        'message' => 'İstek başarıyla alındı.',
        'data' => $request->all()
    ]);
})->middleware([SecureRequestMiddleware::class]);
