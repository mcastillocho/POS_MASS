<?php

use App\Http\Controllers\CtrlAutenticacion;
use App\Http\Controllers\CtrlProducto;
use App\Http\Controllers\CtrlUsuario;
use App\Http\Controllers\CtrlVenta;
use Illuminate\Support\Facades\Route;

Route::post('/login', [CtrlAutenticacion::class, 'login']);
Route::post('/logout', [CtrlAutenticacion::class, 'logout']);
Route::get('/dashboard', [CtrlProducto::class, 'dashboard']);
Route::get('/catalogos', [CtrlProducto::class, 'catalogos']);
Route::get('/productos', [CtrlProducto::class, 'index']);
Route::post('/productos', [CtrlProducto::class, 'store']);
Route::get('/inventario', [CtrlProducto::class, 'inventario']);
Route::post('/inventario/movimientos', [CtrlProducto::class, 'movimiento']);
Route::get('/clientes', [CtrlProducto::class, 'clientes']);
Route::post('/clientes', [CtrlProducto::class, 'storeCliente']);
Route::get('/proveedores', [CtrlProducto::class, 'proveedores']);
Route::post('/proveedores', [CtrlProducto::class, 'storeProveedor']);
Route::get('/empleados', [CtrlProducto::class, 'empleados']);
Route::post('/empleados', [CtrlProducto::class, 'storeEmpleado']);
Route::get('/auditoria', [CtrlProducto::class, 'auditoria']);
Route::get('/reportes', [CtrlProducto::class, 'reportes']);
Route::get('/usuarios', [CtrlUsuario::class, 'index']);
Route::post('/usuarios', [CtrlUsuario::class, 'store']);
Route::get('/ventas', [CtrlVenta::class, 'index']);
Route::post('/ventas', [CtrlVenta::class, 'store']);
