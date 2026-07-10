<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CtrlAutenticacion extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $usuario = Usuario::with(['rol', 'tienda'])->where('username', $request->input('username'))->first();
        if (!$usuario || $usuario->estado !== 'activo' || !Hash::check((string) $request->input('password'), $usuario->password_hash)) {
            return response()->json(['ok' => false, 'message' => 'Usuario o contraseña incorrectos'], 401);
        }

        return response()->json(['ok' => true, 'user' => [
            'id_usuario' => $usuario->id_usuario,
            'nombres' => $usuario->nombres,
            'apellidos' => $usuario->apellidos,
            'username' => $usuario->username,
            'estado' => $usuario->estado,
            'rol_nombre' => $usuario->rol?->nombre_rol,
            'tienda_nombre' => $usuario->tienda?->nombre_tienda,
            'id_rol' => $usuario->id_rol,
            'id_tienda' => $usuario->id_tienda,
        ]]);
    }

    public function logout(): JsonResponse
    {
        return response()->json(['ok' => true, 'message' => 'Sesión cerrada']);
    }
}
