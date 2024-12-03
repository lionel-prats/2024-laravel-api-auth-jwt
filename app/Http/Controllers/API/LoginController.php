<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)/* : JsonResponse */
    {

        // Validar los campos de entrada
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Obtener los datos del usuario
        $user = User::where('email', $request->email)->first();

        // Verificar que el usuario exista
        if (!$user) {
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }

        // Verificar si la contraseña proporcionada coincide con el hash MD5 de la base de datos
        if (md5($request->password) !== $user->password) {
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }

        // Intentar crear un token JWT para el usuario
        try {
            //return $user;
            // Si las credenciales son correctas, se crea un JWT
            $token = JWTAuth::fromUser($user);
        // } catch (JWTException $e) {
        //     return response()->json(['error' => 'No se pudo crear el token'], 500);
        // }
        } catch (JWTException $e) {
            // Imprime el error completo para ayudar a depurar
            return response()->json(['error' => 'No se pudo crear el token', 'message' => $e->getMessage()], 500);
        }

        // Devolver el token de acceso
        return response()->json(['token' => $token]);






















        // $credentials = request(["email", "password"]);
        // if(!$token = auth(guard: "api")->attempt($credentials)) {
        //     return response()->json(["error" => "Unauthorized"], status: 401);
        // }
        // return response()->json(["token" => $token]);
    }
}
