<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            auth()->logout();
            return response()->json(['message' => 'Suuccessfully logged out']);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token not found!'], status: 401);
        }
    }
}
