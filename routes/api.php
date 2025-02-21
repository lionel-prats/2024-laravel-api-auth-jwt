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
            // auth()->logout();
            // return response()->json(['message' => 'Suuccessfully logged out']);

            $user = JWTAuth::parseToken()->authenticate();
            return response()->json([
                'message' => 'Acceso autorizado',
                'user' => $user,
            ]);


        } catch (JWTException $e) {
            return response()->json(['error' => 'Token not found!'], status: 401);
        }
    });
    Route::get("endpoint_protegido_de_prueba", function() {
        try {
            // Intentamos autenticar al usuario a partir del token JWT
            $user = JWTAuth::parseToken()->authenticate();
            
            // Si el token es válido, retornamos los datos del usuario
            return response()->json([
                'message' => 'Token válido',
                'user' => $user,
            ]);
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            // Si el token ha expirado
            return response()->json(['error' => 'El token ha expirado'], 401);
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            // Si el token no es válido
            return response()->json(['error' => 'Token inválido'], 401);
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            // Si no se ha proporcionado ningún token
            return response()->json(['error' => 'No se ha enviado ningún token'], 401);
        }
    });
});