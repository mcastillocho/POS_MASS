<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\Tienda;
use App\Models\Usuario;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CtrlUsuario extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['ok' => true, 'data' => [
            'usuarios' => Usuario::with(['rol', 'tienda'])->get()->map(fn ($usuario) => [
                'id_usuario' => $usuario->id_usuario,
                'nombres' => $usuario->nombres,
                'apellidos' => $usuario->apellidos,
                'username' => $usuario->username,
                'estado' => $usuario->estado,
                'rol' => $usuario->rol?->nombre_rol,
                'rol_nombre' => $usuario->rol?->nombre_rol,
                'tienda' => $usuario->tienda?->nombre_tienda,
                'tienda_nombre' => $usuario->tienda?->nombre_tienda,
                'id_rol' => $usuario->id_rol,
                'id_tienda' => $usuario->id_tienda,
            ]),
            'roles' => Rol::orderBy('nombre_rol')->get()->map(fn ($rol) => ['id_rol' => $rol->id_rol, 'nombre' => $rol->nombre_rol, 'nombre_rol' => $rol->nombre_rol]),
            'tiendas' => Tienda::orderBy('nombre_tienda')->get()->map(fn ($tienda) => ['id_tienda' => $tienda->id_tienda, 'nombre' => $tienda->nombre_tienda, 'nombre_tienda' => $tienda->nombre_tienda]),
        ]]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nombres' => ['required', 'string', 'max:100'],
            'apellidos' => ['nullable', 'string', 'max:120'],
            'username' => ['required', 'string', 'max:80'],
            'password' => ['nullable', 'string', 'min:6'],
            'estado' => ['nullable', 'string', 'max:20'],
            'id_rol' => ['required', 'exists:roles,id_rol'],
            'id_tienda' => ['required', 'exists:tiendas,id_tienda'],
        ]);

        $data = collect($validated)->except('password')->toArray();
        $data['apellidos'] = $data['apellidos'] ?? '';
        $data['estado'] = $data['estado'] ?? 'activo';
        if (!empty($validated['password'])) $data['password_hash'] = Hash::make($validated['password']);

        $usuario = Usuario::updateOrCreate(['id_usuario' => $request->input('id')], $data);
        return response()->json(['ok' => true, 'message' => 'Usuario guardado', 'data' => $usuario]);
    }
}