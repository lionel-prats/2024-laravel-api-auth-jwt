<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\LogoutController;
use Tymon\JWTAuth\Exceptions\JWTException;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::middleware('auth:api')->get('/user', function (Request $request) {
    try {
        auth()->logout();
        return response()->json(['message' => 'Suuccessfully logged out']);
    } catch (JWTException $e) {
        return response()->json(['error' => 'Token not found!'], status: 401);
    }
});

Route::group([
    "middleware" => "api",
    "prefix" => "auth"
], function() {
    Route::post(uri: "login", action: LoginController::class);
    // Route::post(uri: "logout", action: LogoutController::class);
    Route::post("logout", function() {
        try {
            auth()->logout();
            return response()->json(['message' => 'Suuccessfully logged out']);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token not found!'], status: 401);
        }
    });
});