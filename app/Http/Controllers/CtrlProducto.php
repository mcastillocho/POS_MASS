<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
use App\Models\Categoria;
use App\Models\InventarioMovimiento;
use App\Models\Producto;
use App\Models\Proveedor;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CtrlProducto extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['ok' => true, 'data' => [
            'productos' => Producto::with(['categoria', 'proveedor'])->get()->map(fn ($producto) => $this->productoPayload($producto))->values(),
            'categorias' => Categoria::orderBy('nombre_categoria')->get()->map(fn ($categoria) => [
                'id_categoria' => $categoria->id_categoria,
                'nombre' => $categoria->nombre_categoria,
                'nombre_categoria' => $categoria->nombre_categoria,
            ])->values(),
            'proveedores' => $this->proveedoresPayload(),
        ]]);
    }

    public function catalogos(): JsonResponse
    {
        return response()->json(['ok' => true, 'data' => [
            'categorias' => Categoria::orderBy('nombre_categoria')->get()->map(fn ($categoria) => [
                'id_categoria' => $categoria->id_categoria,
                'nombre' => $categoria->nombre_categoria,
                'nombre_categoria' => $categoria->nombre_categoria,
            ])->values(),
            'proveedores' => $this->proveedoresPayload(),
        ]]);
    }

    public function store(Request $request): JsonResponse
    {
        $id = $request->filled('id') ? (int) $request->input('id') : null;
        $validated = $request->validate([
            'codigo_barras' => ['required', 'string', 'max:60', Rule::unique('productos', 'codigo_barras')->ignore($id, 'id_producto')],
            'descripcion' => ['required', 'string', 'max:180'],
            'precio_costo' => ['nullable', 'numeric', 'min:0'],
            'precio_venta' => ['required', 'numeric', 'min:0'],
            'stock_actual' => ['nullable', 'integer', 'min:0'],
            'stock_minimo' => ['nullable', 'integer', 'min:0'],
            'id_categoria' => ['required', 'exists:categorias,id_categoria'],
            'id_proveedor' => ['nullable', 'exists:proveedores,id_proveedor'],
        ]);

        $payload = array_merge(['precio_costo' => 0, 'stock_actual' => 0, 'stock_minimo' => 0], $validated);
        $producto = $id ? Producto::findOrFail($id) : new Producto();
        $producto->fill($payload)->save();

        return response()->json(['ok' => true, 'message' => 'Producto guardado', 'data' => $this->productoPayload($producto->load(['categoria', 'proveedor']))]);
    }
    public function inventario(): JsonResponse
    {
        $productos = Producto::with('categoria')->get()->map(function ($producto) {
            $payload = $this->productoPayload($producto);
            $payload['estado'] = $producto->stock_actual <= $producto->stock_minimo ? 'CRITICO' : 'NORMAL';
            return $payload;
        })->values();

        return response()->json(['ok' => true, 'data' => [
            'productos' => $productos,
            'criticos' => $productos->where('estado', 'CRITICO')->count(),
        ]]);
    }

    public function movimiento(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id_producto' => ['required', 'exists:productos,id_producto'],
            'tipo_movimiento' => ['required', 'in:ENTRADA,SALIDA'],
            'cantidad' => ['required', 'integer', 'min:1'],
            'motivo' => ['nullable', 'string', 'max:180'],
        ]);

        DB::transaction(function () use ($validated) {
            InventarioMovimiento::create($validated + ['fecha_movimiento' => now()]);
            $producto = Producto::lockForUpdate()->findOrFail($validated['id_producto']);
            $delta = $validated['tipo_movimiento'] === 'ENTRADA' ? $validated['cantidad'] : -$validated['cantidad'];
            $producto->stock_actual = max(0, $producto->stock_actual + $delta);
            $producto->save();
        });

        return response()->json(['ok' => true, 'message' => 'Movimiento registrado']);
    }

    public function dashboard(): JsonResponse
    {
        $hoy = Carbon::today();
        $productos = Producto::query();
        $ventasHoy = DB::table('ventas')->whereDate('fecha_hora', $hoy)->count();
        $ingresosHoy = (float) DB::table('ventas')->whereDate('fecha_hora', $hoy)->sum('total_pagar');
        $stockCritico = Producto::whereColumn('stock_actual', '<=', 'stock_minimo')->count();

        $ventas7Dias = collect(range(6, 0))->map(function ($dias) {
            $fecha = Carbon::today()->subDays($dias);
            return ['dia' => $fecha->locale('es')->isoFormat('ddd'), 'total' => (float) DB::table('ventas')->whereDate('fecha_hora', $fecha)->sum('total_pagar')];
        });

        $alertas = Producto::whereColumn('stock_actual', '<=', 'stock_minimo')->limit(8)->get()->map(fn ($producto) => [
            'producto' => $producto->descripcion,
            'stock' => $producto->stock_actual,
            'min' => $producto->stock_minimo,
        ]);

        return response()->json(['ok' => true, 'data' => [
            'kpis' => ['ventas_hoy' => $ventasHoy, 'ingresos_hoy' => $ingresosHoy, 'stock_critico' => $stockCritico, 'productos_activos' => $productos->count()],
            'ventas_7_dias' => $ventas7Dias,
            'alertas' => $alertas,
        ]]);
    }

    public function clientes(Request $request): JsonResponse
    {
        $q = trim((string) $request->query('q', ''));
        $clientes = DB::table('clientes')
            ->when($q !== '', fn ($query) => $query->where(function ($inner) use ($q) {
                $inner->where('nombres', 'like', "%{$q}%")
                    ->orWhere('apellidos', 'like', "%{$q}%")
                    ->orWhere('dni', 'like', "%{$q}%");
            }))
            ->orderBy('nombres')
            ->get();

        return response()->json(['ok' => true, 'data' => ['clientes' => $clientes]]);
    }

    public function storeCliente(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nombres' => ['required', 'string', 'max:100'],
            'apellidos' => ['nullable', 'string', 'max:120'],
            'dni' => ['nullable', 'string', 'max:8'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'correo' => ['nullable', 'email', 'max:120'],
            'direccion' => ['nullable', 'string', 'max:180'],
        ]);

        $cliente = DB::table('clientes')->updateOrInsert(
            ['dni' => $data['dni'] ?? null],
            $data + ['updated_at' => now(), 'created_at' => now()]
        );

        return response()->json(['ok' => true, 'message' => 'Cliente registrado', 'data' => $cliente]);
    }

    public function proveedores(): JsonResponse
    {
        return response()->json(['ok' => true, 'data' => ['proveedores' => $this->proveedoresPayload()]]);
    }

    public function storeProveedor(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:120'],
            'ruc' => ['nullable', 'string', 'max:11'],
            'razon_social' => ['nullable', 'string', 'max:160'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'correo' => ['nullable', 'email', 'max:120'],
            'direccion' => ['nullable', 'string', 'max:180'],
        ]);

        $proveedor = Proveedor::updateOrCreate(['ruc' => $data['ruc'] ?? null], $data);
        return response()->json(['ok' => true, 'message' => 'Proveedor registrado', 'data' => $proveedor]);
    }

    public function empleados(): JsonResponse
    {
        $empleados = DB::table('empleados')
            ->leftJoin('tiendas', 'empleados.id_tienda', '=', 'tiendas.id_tienda')
            ->select('empleados.*', 'tiendas.nombre_tienda as tienda')
            ->orderBy('empleados.nombres')
            ->get();

        return response()->json(['ok' => true, 'data' => ['empleados' => $empleados]]);
    }

    public function storeEmpleado(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nombres' => ['required', 'string', 'max:100'],
            'apellidos' => ['nullable', 'string', 'max:120'],
            'dni' => ['required', 'string', 'max:8'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'cargo' => ['nullable', 'string', 'max:80'],
            'id_tienda' => ['nullable', 'exists:tiendas,id_tienda'],
            'fecha_ingreso' => ['nullable', 'date'],
        ]);

        DB::table('empleados')->updateOrInsert(
            ['dni' => $data['dni']],
            $data + ['updated_at' => now(), 'created_at' => now()]
        );

        return response()->json(['ok' => true, 'message' => 'Empleado registrado']);
    }

    public function auditoria(): JsonResponse
    {
        return response()->json(['ok' => true, 'data' => ['auditoria' => Auditoria::with('usuario')->latest('fecha_hora')->limit(100)->get()->map(fn ($registro) => [
            'id_auditoria' => $registro->id_auditoria,
            'fecha' => optional($registro->fecha_hora)->format('Y-m-d H:i'),
            'fecha_hora' => optional($registro->fecha_hora)->format('Y-m-d H:i'),
            'modulo_afectado' => $registro->modulo_afectado,
            'accion' => $registro->accion,
            'usuario_nombre' => $registro->usuario?->username,
            'ip_origen' => $registro->ip_origen,
            'descripcion' => $registro->descripcion_detalle,
            'descripcion_detalle' => $registro->descripcion_detalle,
        ])]]);
    }

    public function reportes(Request $request): JsonResponse
    {
        $tipo = $request->query('tipo', 'ventas');
        if ($tipo === 'inventario' || $tipo === 'stock') {
            return response()->json(['ok' => true, 'data' => [
                'columns' => ['Código', 'Producto', 'Categoría', 'Stock Actual', 'Stock Mín.', 'Estado'],
                'keys' => ['codigo', 'nombre', 'categoria', 'stock_actual', 'stock_minimo', 'estado'],
                'summary' => [],
                'rows' => $this->inventario()->getData(true)['data']['productos'],
            ]]);
        }

        return response()->json(['ok' => true, 'data' => [
            'columns' => ['Fecha', 'Ventas', 'Monto Total'],
            'keys' => ['dia', 'ventas', 'total'],
            'summary' => [],
            'rows' => DB::table('ventas')->selectRaw('DATE(fecha_hora) as dia, COUNT(*) as ventas, SUM(total_pagar) as total')->groupByRaw('DATE(fecha_hora)')->orderBy('dia')->get(),
        ]]);
    }

    private function productoPayload(Producto $producto): array
    {
        return [
            'id_producto' => $producto->id_producto,
            'codigo' => $producto->codigo_barras,
            'codigo_barras' => $producto->codigo_barras,
            'nombre' => $producto->descripcion,
            'descripcion' => $producto->descripcion,
            'categoria' => $producto->categoria?->nombre_categoria,
            'proveedor' => $producto->proveedor?->nombre,
            'precio' => (float) $producto->precio_venta,
            'precio_costo' => (float) $producto->precio_costo,
            'precio_venta' => (float) $producto->precio_venta,
            'stock_actual' => $producto->stock_actual,
            'stock_minimo' => $producto->stock_minimo,
            'id_categoria' => $producto->id_categoria,
            'id_proveedor' => $producto->id_proveedor,
        ];
    }

    private function proveedoresPayload()
    {
        return Proveedor::orderBy('nombre')->get()->map(fn ($proveedor) => [
            'id_proveedor' => $proveedor->id_proveedor,
            'nombre' => $proveedor->nombre,
            'ruc' => $proveedor->ruc,
            'razon_social' => $proveedor->razon_social,
            'telefono' => $proveedor->telefono,
            'correo' => $proveedor->correo,
            'direccion' => $proveedor->direccion,
        ])->values();
    }
}
