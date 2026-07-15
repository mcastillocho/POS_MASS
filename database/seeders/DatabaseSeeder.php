<?php

namespace Database\Seeders;

use App\Models\Auditoria;
use App\Models\Categoria;
use App\Models\Comprobante;
use App\Models\DetalleVenta;
use App\Models\InventarioMovimiento;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Rol;
use App\Models\Tienda;
use App\Models\Usuario;
use App\Models\Venta;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        foreach ([
            ['id_rol' => 1, 'nombre_rol' => 'Administrador', 'descripcion' => 'Control integral del sistema y configuracion general.'],
            ['id_rol' => 2, 'nombre_rol' => 'Gerente', 'descripcion' => 'Gestion de tienda, reportes, ventas e inventario.'],
            ['id_rol' => 3, 'nombre_rol' => 'Cajero', 'descripcion' => 'Operacion del punto de venta y emision de comprobantes.'],
            ['id_rol' => 4, 'nombre_rol' => 'Almacenero', 'descripcion' => 'Control de stock, entradas, salidas y alertas de inventario.'],
        ] as $rol) {
            Rol::updateOrCreate(['id_rol' => $rol['id_rol']], $rol);
        }

        foreach ([
            ['id_tienda' => 1, 'nombre_tienda' => 'MASS Tupac Amaru', 'direccion' => 'Av. Tupac Amaru Km 11.5, Comas', 'ubigeo' => '150110', 'estado' => 'activo'],
            ['id_tienda' => 2, 'nombre_tienda' => 'MASS Carlos Izaguirre', 'direccion' => 'Av. Carlos Izaguirre 450, Los Olivos', 'ubigeo' => '150117', 'estado' => 'activo'],
            ['id_tienda' => 3, 'nombre_tienda' => 'MASS Universitaria', 'direccion' => 'Av. Universitaria 2210, San Miguel', 'ubigeo' => '150136', 'estado' => 'activo'],
        ] as $tienda) {
            Tienda::updateOrCreate(['id_tienda' => $tienda['id_tienda']], $tienda);
        }

        $password = Hash::make('johnabadpoma117');
        foreach ([
            [1, 'Carlos Alberto', 'Mendoza Ramos', 'admin_mass', 1, 1],
            [2, 'Ana Sofia', 'Palacios Vega', 'gerente_comas', 2, 1],
            [3, 'Luis Enrique', 'Flores Quispe', 'cajero_luis', 3, 1],
            [4, 'Jorge Luis', 'Tapia Sanchez', 'almacen_jorge', 4, 1],
            [5, 'Mariela', 'Condori Huaman', 'cajera_maria', 3, 2],
            [6, 'Rosa Elvira', 'Vargas Salazar', 'supervision_mass', 2, 3],
        ] as [$id, $nombres, $apellidos, $username, $rol, $tienda]) {
            Usuario::updateOrCreate(['id_usuario' => $id], [
                'nombres' => $nombres,
                'apellidos' => $apellidos,
                'username' => $username,
                'password_hash' => $password,
                'estado' => 'activo',
                'id_rol' => $rol,
                'id_tienda' => $tienda,
            ]);
        }

        foreach ([
            [1, 'Abarrotes y Despensa', 'Arroz, azucar, fideos, aceites, conservas y salsas.'],
            [2, 'Bebidas y Licores', 'Gaseosas, aguas, jugos, cervezas y rehidratantes.'],
            [3, 'Lacteos y Embutidos', 'Leches, yogures, quesos, mantequillas y embutidos.'],
            [4, 'Snacks y Confiteria', 'Galletas, papitas, chocolates y dulces.'],
            [5, 'Limpieza del Hogar', 'Detergentes, lavavajillas, limpiadores y desinfectantes.'],
            [6, 'Cuidado Personal', 'Champu, jabones, desodorantes y pasta dental.'],
        ] as [$id, $nombre, $descripcion]) {
            Categoria::updateOrCreate(['id_categoria' => $id], [
                'nombre_categoria' => $nombre,
                'descripcion' => $descripcion,
            ]);
        }

        foreach ([
            [1, 'Distribuidora Lima Norte', '20548796521', 'Distribuidora Lima Norte S.A.C.', '987654321', 'ventas@limanorte.pe', 'Av. Alfredo Mendiola 6200, Los Olivos'],
            [2, 'Abarrotes del Peru', '20601478563', 'Abarrotes del Peru E.I.R.L.', '976542118', 'pedidos@abarrotesperu.pe', 'Jr. Huallaga 420, Lima'],
            [3, 'Bebidas Andinas', '20478563219', 'Bebidas Andinas S.A.C.', '965874123', 'comercial@bebidasandinas.pe', 'Av. Argentina 3090, Callao'],
            [4, 'Lacteos del Sur', '20563214789', 'Lacteos del Sur S.R.L.', '954321778', 'ventas@lacteosdelsur.pe', 'Av. Industrial 155, Ate'],
            [5, 'Limpieza Hogar Peru', '20657891432', 'Limpieza Hogar Peru S.A.C.', '943218765', 'contacto@limpiezahogar.pe', 'Av. Nicolas Ayllon 1980, Santa Anita'],
            [6, 'Consumo Masivo Sol', '20591478326', 'Consumo Masivo Sol E.I.R.L.', '932145678', 'ventas@cmsol.pe', 'Av. Universitaria 1890, San Miguel'],
        ] as [$id, $nombre, $ruc, $razon, $telefono, $correo, $direccion]) {
            Proveedor::updateOrCreate(['id_proveedor' => $id], [
                'nombre' => $nombre,
                'ruc' => $ruc,
                'razon_social' => $razon,
                'telefono' => $telefono,
                'correo' => $correo,
                'direccion' => $direccion,
            ]);
        }

        $productos = [
            [1, '7750111001234', 'Arroz Superior Costeno 1kg', 3.40, 4.20, 120, 15, 1, 2],
            [2, '7750222005678', 'Azucar Rubia Cartavio 1kg', 3.10, 3.80, 85, 15, 1, 2],
            [3, '7501005112345', 'Aceite Vegetal Primor 1L', 7.50, 9.40, 45, 10, 1, 1],
            [4, '7750333001111', 'Fideo Don Vittorio Espagueti 450g', 2.10, 2.70, 200, 20, 1, 1],
            [5, '7750444002222', 'Trozos de Atun Real 170g', 4.20, 5.50, 60, 12, 1, 6],
            [6, '7750014000315', 'Gaseosa Inca Kola 2L', 4.80, 6.00, 90, 15, 2, 3],
            [7, '7750014000100', 'Gaseosa Coca-Cola Sin Azucar 1.5L', 4.20, 5.30, 75, 15, 2, 3],
            [8, '7750888003333', 'Agua Mineral Cielo 625ml', 0.80, 1.50, 150, 25, 2, 3],
            [9, '7751234009999', 'Cerveza Cristal Lata 355ml', 3.50, 4.50, 8, 24, 2, 3],
            [10, '7750006002549', 'Leche Evaporada Gloria 400g', 3.20, 4.10, 300, 30, 3, 4],
            [11, '7750006001108', 'Yogurt Gloria Fresa 1kg', 4.90, 6.20, 35, 8, 3, 4],
            [12, '7750555003333', 'Mantequilla Laive con Sal 200g', 4.50, 5.80, 3, 10, 3, 4],
            [13, '7750666004444', 'Galletas Soda Field Familiar', 3.10, 4.00, 110, 15, 4, 6],
            [14, '7501011132023', 'Papas Lays Clasicas 160g', 5.20, 6.80, 42, 10, 4, 6],
            [15, '7750777008888', 'Chocolate Sublime Clasico 30g', 1.20, 1.80, 250, 35, 4, 6],
            [16, '7750999001111', 'Detergente Opal Ultra 800g', 6.80, 8.50, 50, 10, 5, 5],
            [17, '7750999002222', 'Lavavajillas Ayudin Limon 500ml', 4.10, 5.40, 38, 8, 5, 5],
            [18, '7751111004444', 'Limpiador Poett Bebe 900ml', 4.60, 5.90, 30, 6, 5, 5],
            [19, '7501001156789', 'Crema Dental Colgate Triple Accion 75ml', 3.80, 4.90, 65, 12, 6, 6],
            [20, '7751222003333', 'Jabon Bolivar Glicerina 120g', 2.10, 2.90, 4, 15, 6, 6],
        ];

        foreach ($productos as [$id, $codigo, $descripcion, $costo, $venta, $stock, $minimo, $categoria, $proveedor]) {
            Producto::updateOrCreate(['id_producto' => $id], [
                'codigo_barras' => $codigo,
                'descripcion' => $descripcion,
                'precio_costo' => $costo,
                'precio_venta' => $venta,
                'stock_actual' => $stock,
                'stock_minimo' => $minimo,
                'id_categoria' => $categoria,
                'id_proveedor' => $proveedor,
            ]);
        }

        foreach ([
            [1, 1, 'ENTRADA', 80, 'Ingreso por compra a proveedor', $now->copy()->subDays(6)],
            [2, 6, 'ENTRADA', 60, 'Reposicion de bebidas', $now->copy()->subDays(5)],
            [3, 9, 'SALIDA', 16, 'Venta y merma por vencimiento cercano', $now->copy()->subDays(4)],
            [4, 12, 'SALIDA', 5, 'Ajuste por cadena de frio', $now->copy()->subDays(3)],
            [5, 16, 'ENTRADA', 30, 'Ingreso de limpieza', $now->copy()->subDays(2)],
            [6, 20, 'SALIDA', 8, 'Salida por venta directa', $now->copy()->subDay()],
        ] as [$id, $producto, $tipo, $cantidad, $motivo, $fecha]) {
            InventarioMovimiento::updateOrCreate(['id_movimiento' => $id], [
                'id_producto' => $producto,
                'tipo_movimiento' => $tipo,
                'cantidad' => $cantidad,
                'motivo' => $motivo,
                'fecha_movimiento' => $fecha,
            ]);
        }

        $ventas = [
            [1, $now->copy()->subDays(6)->setTime(10, 15), 'efectivo', 3, [[1, 2], [6, 1], [13, 3]], 'BOLETA', 'B001', 1, null],
            [2, $now->copy()->subDays(5)->setTime(12, 40), 'yape', 3, [[10, 4], [15, 5]], 'BOLETA', 'B001', 2, null],
            [3, $now->copy()->subDays(4)->setTime(18, 5), 'tarjeta', 5, [[3, 1], [4, 3], [7, 2]], 'FACTURA', 'F001', 1, '20548796521'],
            [4, $now->copy()->subDays(3)->setTime(9, 25), 'efectivo', 3, [[2, 3], [8, 6], [19, 2]], 'BOLETA', 'B001', 3, null],
            [5, $now->copy()->subDays(2)->setTime(20, 10), 'plin', 5, [[14, 2], [17, 1], [18, 1]], 'BOLETA', 'B001', 4, null],
            [6, $now->copy()->subDay()->setTime(16, 50), 'efectivo', 3, [[5, 2], [11, 1], [16, 1]], 'BOLETA', 'B001', 5, null],
            [7, $now->copy()->setTime(8, 45), 'yape', 3, [[1, 1], [10, 2], [15, 4]], 'BOLETA', 'B001', 6, null],
            [8, $now->copy()->setTime(13, 20), 'tarjeta', 5, [[6, 2], [7, 1], [20, 2]], 'FACTURA', 'F001', 2, '20601478563'],
        ];

        foreach ($ventas as [$id, $fecha, $metodo, $usuario, $items, $tipo, $serie, $correlativo, $documento]) {
            $neto = collect($items)->sum(fn ($item) => (float) Producto::find($item[0])->precio_venta * $item[1]);
            $igv = round($neto * 0.18, 2);
            Venta::updateOrCreate(['id_venta' => $id], [
                'fecha_hora' => $fecha,
                'total_neto' => $neto,
                'igv' => $igv,
                'total_pagar' => $neto + $igv,
                'metodo_pago' => $metodo,
                'id_usuario' => $usuario,
            ]);

            foreach ($items as $index => [$productoId, $cantidad]) {
                $producto = Producto::find($productoId);
                DetalleVenta::updateOrCreate(['id_detalle' => ($id * 10) + $index], [
                    'id_venta' => $id,
                    'id_producto' => $productoId,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $producto->precio_venta,
                    'subtotal' => (float) $producto->precio_venta * $cantidad,
                ]);
            }

            Comprobante::updateOrCreate(['id_comprobante' => $id], [
                'id_venta' => $id,
                'tipo_comprobante' => $tipo,
                'serie' => $serie,
                'correlativo' => $correlativo,
                'documento_cliente' => $documento,
            ]);
        }

        foreach ([
            ['72845163', 'Lucia', 'Rojas Campos', '987321456', 'lucia.rojas@mail.com', 'Jr. Los Fresnos 145, Comas'],
            ['46123985', 'Miguel Angel', 'Castillo Vega', '956874120', 'miguel.castillo@mail.com', 'Av. Las Palmeras 330, Los Olivos'],
            ['70321458', 'Fiorella', 'Salazar Huerta', '965214789', 'fiorella.salazar@mail.com', 'Calle Los Cedros 280, Independencia'],
            ['45879632', 'Pedro Luis', 'Quispe Arias', '943785612', 'pedro.quispe@mail.com', 'Av. Peru 1880, San Martin de Porres'],
            ['76985412', 'Valeria', 'Paredes Nunez', '932147865', 'valeria.paredes@mail.com', 'Jr. Manco Capac 557, Lima'],
        ] as [$dni, $nombres, $apellidos, $telefono, $correo, $direccion]) {
            DB::table('clientes')->updateOrInsert(['dni' => $dni], [
                'nombres' => $nombres,
                'apellidos' => $apellidos,
                'telefono' => $telefono,
                'correo' => $correo,
                'direccion' => $direccion,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        foreach ([
            ['72984516', 'Carlos Alberto', 'Mendoza Ramos', '987654321', 'Administrador', 1, '2024-03-01'],
            ['70451238', 'Ana Sofia', 'Palacios Vega', '976541230', 'Gerente de Tienda', 1, '2024-05-15'],
            ['71896543', 'Luis Enrique', 'Flores Quispe', '965874120', 'Cajero', 1, '2025-01-10'],
            ['70589632', 'Jorge Luis', 'Tapia Sanchez', '954321789', 'Almacenero', 1, '2025-02-20'],
            ['76231458', 'Mariela', 'Condori Huaman', '943217865', 'Cajero', 2, '2025-04-12'],
        ] as [$dni, $nombres, $apellidos, $telefono, $cargo, $tienda, $ingreso]) {
            DB::table('empleados')->updateOrInsert(['dni' => $dni], [
                'nombres' => $nombres,
                'apellidos' => $apellidos,
                'telefono' => $telefono,
                'cargo' => $cargo,
                'id_tienda' => $tienda,
                'fecha_ingreso' => $ingreso,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        foreach ([
            [1, 1, 'SISTEMA', 'CONFIGURACION', 'Carga inicial de datos operativos para demostracion del POS.', '127.0.0.1', $now->copy()->subDays(6)],
            [2, 1, 'USUARIOS', 'INSERCION', 'Creacion de usuarios demo para roles del sistema.', '127.0.0.1', $now->copy()->subDays(6)],
            [3, 4, 'INVENTARIO', 'ENTRADA', 'Registro de ingreso de productos desde proveedores peruanos.', '127.0.0.1', $now->copy()->subDays(5)],
            [4, 3, 'VENTAS', 'INSERCION', 'Venta POS de prueba con boleta electronica.', '127.0.0.1', $now->copy()->subDays(3)],
            [5, 2, 'REPORTES', 'ACCESO', 'Consulta de dashboard con ventas e inventario valorizado.', '127.0.0.1', $now],
        ] as [$id, $usuario, $modulo, $accion, $descripcion, $ip, $fecha]) {
            Auditoria::updateOrCreate(['id_auditoria' => $id], [
                'id_usuario' => $usuario,
                'modulo_afectado' => $modulo,
                'accion' => $accion,
                'descripcion_detalle' => $descripcion,
                'ip_origen' => $ip,
                'fecha_hora' => $fecha,
            ]);
        }
    }
}
