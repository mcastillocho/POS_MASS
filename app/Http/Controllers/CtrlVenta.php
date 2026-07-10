<?php

namespace App\Http\Controllers;

use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\Usuario;
use App\Models\Venta;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CtrlVenta extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['ok' => true, 'data' => ['ventas' => Venta::with('cajero')->latest('fecha_hora')->get()->map(fn ($venta) => [
            'id_venta' => $venta->id_venta,
            'fecha' => optional($venta->fecha_hora)->format('Y-m-d H:i'),
            'cajero' => trim(($venta->cajero?->nombres ?? '') . ' ' . ($venta->cajero?->apellidos ?? '')),
            'cliente' => '-',
            'subtotal' => (float) $venta->total_neto,
            'impuesto' => (float) $venta->igv,
            'total' => (float) $venta->total_pagar,
            'metodo' => $venta->metodo_pago,
            'estado' => 'completada',
        ])]]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.id_producto' => ['required', 'exists:productos,id_producto'],
            'items.*.cantidad' => ['required', 'integer', 'min:1'],
            'metodo' => ['nullable', 'string', 'max:40'],
            'id_usuario' => ['nullable', 'exists:usuarios,id_usuario'],
        ]);

        $venta = DB::transaction(function () use ($validated, $request) {
            $items = collect($validated['items']);
            $productos = Producto::whereIn('id_producto', $items->pluck('id_producto'))->lockForUpdate()->get()->keyBy('id_producto');

            foreach ($items as $item) {
                $producto = $productos[(int) $item['id_producto']];
                if ($producto->stock_actual < (int) $item['cantidad']) {
                    abort(response()->json(['ok' => false, 'message' => "Stock insuficiente para {$producto->descripcion}"], 422));
                }
            }

            $subtotal = $items->sum(function (array $item) use ($productos) {
                return (float) $productos[(int) $item['id_producto']]->precio_venta * (int) $item['cantidad'];
            });
            $igv = round($subtotal * 0.18, 2);
            $usuarioId = $request->input('id_usuario') ?: Usuario::where('username', 'admin')->value('id_usuario') ?: Usuario::query()->value('id_usuario');

            $venta = Venta::create([
                'fecha_hora' => now(),
                'total_neto' => $subtotal,
                'igv' => $igv,
                'total_pagar' => $subtotal + $igv,
                'metodo_pago' => $request->input('metodo', 'efectivo'),
                'id_usuario' => $usuarioId,
            ]);

            foreach ($items as $item) {
                $producto = $productos[(int) $item['id_producto']];
                $cantidad = (int) $item['cantidad'];
                $precio = (float) $producto->precio_venta;

                DetalleVenta::create([
                    'id_venta' => $venta->id_venta,
                    'id_producto' => $producto->id_producto,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precio,
                    'subtotal' => $precio * $cantidad,
                ]);
                $producto->decrement('stock_actual', $cantidad);
            }

            return $venta;
        });

        return response()->json(['ok' => true, 'data' => ['total' => (float) $venta->total_pagar, 'total_pagar' => (float) $venta->total_pagar]]);
    }
}
