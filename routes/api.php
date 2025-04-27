<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', RegisterController::class);
Route::post('/login', LoginController::class)->name('login');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    // Debug: Print semua headers
    Log::info('Request Headers:', $request->headers->all());

    // Debug: Print token
    Log::info('Auth Header:', ['Authorization' => $request->header('Authorization')]);
    // Debug: Print auth status
    Log::info('Auth Status:', ['is_authenticated' => auth()->check()]);

    if (!$request->user()) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized',
            'debug' => [
                'has_token' => $request->hasHeader('Authorization'),
                'token' => $request->header('Authorization')
            ]
        ], 401);
    }

    return response()->json([
        'success' => true,
        'user' => $request->user()
    ], 200);
});

Route::post('/logout', \App\Http\Controllers\Api\LogoutController::class)->name('logout');

Route::get('levels', [\App\Http\Controllers\Api\LevelController::class, 'index']);
Route::post('levels', [\App\Http\Controllers\Api\LevelController::class, 'store']);
Route::get('levels/{id}', [\App\Http\Controllers\Api\LevelController::class, 'show']);
Route::put('levels/{level}',  [\App\Http\Controllers\Api\LevelController::class, 'update']);
Route::delete('levels/{level}', [\App\Http\Controllers\Api\LevelController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
