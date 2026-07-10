<?php

namespace Database\Seeders;

use App\Models\Auditoria;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Rol;
use App\Models\Tienda;
use App\Models\Usuario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        foreach ([
            ['id_rol' => 1, 'nombre_rol' => 'Administrador', 'descripcion' => 'Control técnico integral del sistema web y configuraciones globales.'],
            ['id_rol' => 2, 'nombre_rol' => 'Gerente', 'descripcion' => 'Gestión analítica de la tienda, revisión de mermas y reportes financieros.'],
            ['id_rol' => 3, 'nombre_rol' => 'Cajero', 'descripcion' => 'Operación del Punto de Venta POS y emisión de comprobantes.'],
            ['id_rol' => 4, 'nombre_rol' => 'Almacenero', 'descripcion' => 'Control de inventario, registro de entradas de camión y mermas.'],
        ] as $rol) {
            Rol::updateOrCreate(['id_rol' => $rol['id_rol']], $rol);
        }

        foreach ([
            ['id_tienda' => 1, 'nombre_tienda' => 'MASS Túpac Amaru', 'direccion' => 'Av. Túpac Amaru Km 11.5, Comas', 'ubigeo' => '150110', 'estado' => 'activo'],
            ['id_tienda' => 2, 'nombre_tienda' => 'MASS Carlos Izaguirre', 'direccion' => 'Av. Carlos Izaguirre 450, Los Olivos', 'ubigeo' => '150119', 'estado' => 'activo'],
            ['id_tienda' => 3, 'nombre_tienda' => 'MASS Universitaria', 'direccion' => 'Av. Universitaria 2210, San Miguel', 'ubigeo' => '150136', 'estado' => 'activo'],
        ] as $tienda) {
            Tienda::updateOrCreate(['id_tienda' => $tienda['id_tienda']], $tienda);
        }

        $password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
        foreach ([
            ['id_usuario' => 1, 'nombres' => 'Carlos Alberto', 'apellidos' => 'Mendoza Ramos', 'username' => 'admin_mass', 'password_hash' => $password, 'estado' => 'activo', 'id_rol' => 1, 'id_tienda' => 1],
            ['id_usuario' => 2, 'nombres' => 'Ana Sofia', 'apellidos' => 'Palacios Vega', 'username' => 'gerente_comas', 'password_hash' => $password, 'estado' => 'activo', 'id_rol' => 2, 'id_tienda' => 1],
            ['id_usuario' => 3, 'nombres' => 'Luis Enrique', 'apellidos' => 'Flores Quispe', 'username' => 'cajero_luis', 'password_hash' => $password, 'estado' => 'activo', 'id_rol' => 3, 'id_tienda' => 1],
            ['id_usuario' => 4, 'nombres' => 'Jorge Tapia', 'apellidos' => 'Sanchez Diaz', 'username' => 'almacen_jorge', 'password_hash' => $password, 'estado' => 'activo', 'id_rol' => 4, 'id_tienda' => 1],
        ] as $usuario) {
            Usuario::updateOrCreate(['id_usuario' => $usuario['id_usuario']], $usuario);
        }

        foreach ([
            ['id_categoria' => 1, 'nombre_categoria' => 'Abarrotes y Despensa', 'descripcion' => 'Arroz, azúcar, fideos, aceites, conservas y salsas.'],
            ['id_categoria' => 2, 'nombre_categoria' => 'Bebidas y Licores', 'descripcion' => 'Gaseosas, aguas, jugos, licores y rehidratantes.'],
            ['id_categoria' => 3, 'nombre_categoria' => 'Lácteos y Embutidos', 'descripcion' => 'Leches, yogures, quesos, embutidos y mantequillas.'],
            ['id_categoria' => 4, 'nombre_categoria' => 'Snacks y Confitería', 'descripcion' => 'Galletas, papitas, chocolates y dulces.'],
            ['id_categoria' => 5, 'nombre_categoria' => 'Limpieza del Hogar', 'descripcion' => 'Detergentes, lavavajillas, limpiadores y desinfectantes.'],
            ['id_categoria' => 6, 'nombre_categoria' => 'Cuidado Personal', 'descripcion' => 'Champús, jabones, desodorantes y pastas dentales.'],
        ] as $categoria) {
            Categoria::updateOrCreate(['id_categoria' => $categoria['id_categoria']], $categoria);
        }

        foreach ([
            [1, '7750111001234', 'Arroz Superior Costeño 1kg', 3.40, 4.20, 120, 15, 1],
            [2, '7750222005678', 'Azúcar Rubia Cartavio 1kg', 3.10, 3.80, 85, 15, 1],
            [3, '7501005112345', 'Aceite Vegetal Primor Premium 1L', 7.50, 9.40, 45, 10, 1],
            [4, '7750333001111', 'Fideo Don Vittorio Espagueti 450g', 2.10, 2.70, 200, 20, 1],
            [5, '7750444002222', 'Trozos de Atún Real en Aceite 170g', 4.20, 5.50, 60, 12, 1],
            [6, '7750111003841', 'Arroz Integral Costeño 1kg', 4.10, 5.30, 35, 10, 1],
            [7, '7750333004921', 'Fideo Don Vittorio Codito 450g', 2.10, 2.70, 140, 15, 1],
            [8, '7891000341256', 'Salsa de Tomate Pomarola Compal 340g', 1.80, 2.40, 95, 12, 1],
            [9, '7750221001024', 'Sal Mesa Bells Refinada 1kg', 1.10, 1.60, 180, 20, 1],
            [10, '7750522001142', 'Vinagre Blanco Bells Botella 1L', 2.20, 3.10, 40, 8, 1],
            [11, '7750014000315', 'Gaseosa Inca Kola Botella 2L', 4.80, 6.00, 90, 15, 2],
            [12, '7750014000100', 'Gaseosa Coca-Cola Sin Azúcar 1.5L', 4.20, 5.30, 75, 15, 2],
            [13, '7750888003333', 'Agua Mineral Cielo Sin Gas 625ml', 0.80, 1.50, 150, 25, 2],
            [14, '7751234009999', 'Cerveza Cristal Lata 355ml', 3.50, 4.50, 8, 24, 2],
            [15, '7750014002251', 'Gaseosa Fanta Naranja Botella 2L', 4.50, 5.80, 65, 12, 2],
            [16, '7750888001142', 'Agua San Luis Con Gas 500ml', 0.90, 1.60, 110, 20, 2],
            [17, '7752100003412', 'Jugo Frugos del Valle Durazno 1L', 3.20, 4.20, 55, 10, 2],
            [18, '7750043001021', 'Bebida Energizante Volt Azul 500ml', 1.80, 2.50, 130, 15, 2],
            [19, '7750006002549', 'Leche Evaporada Gloria Azul Lata 400g', 3.20, 4.10, 300, 30, 3],
            [20, '7750006001108', 'Yogurt Gloria Fresa Botella 1kg', 4.90, 6.20, 35, 8, 3],
            [21, '7750555003333', 'Mantequilla Laive con Sal Pote 200g', 4.50, 5.80, 3, 10, 3],
            [22, '7750006004112', 'Leche UHT Gloria Entera Caja 1L', 3.60, 4.50, 80, 15, 3],
            [23, '7750241002214', 'Queso Edam Laive Rebanado 200g', 6.90, 8.90, 24, 6, 3],
            [24, '7750102003314', 'Jamonada Especial San Fernando 250g', 4.10, 5.50, 40, 8, 3],
            [25, '7750102004415', 'Salchicha Huacho San Fernando 200g', 3.80, 4.90, 18, 5, 3],
            [26, '7750666004444', 'Galletas Soda Field Paquete Familiar', 3.10, 4.00, 110, 15, 4],
            [27, '7501011132023', 'Papas Lays Clásicas Familiares 160g', 5.20, 6.80, 42, 10, 4],
            [28, '7750777008888', 'Chocolate Sublime Clásico 30g', 1.20, 1.80, 250, 35, 4],
            [29, '7750666001124', 'Galletas Casino Menta Paquete x6', 2.80, 3.60, 85, 12, 4],
            [30, '7501011140021', 'Doritos Mega Queso Familiar 150g', 5.30, 6.90, 38, 10, 4],
            [31, '7750999001111', 'Detergente Opal Fuerza Ultra 800g', 6.80, 8.50, 50, 10, 5],
            [32, '7750999002222', 'Lavavajillas Líquido Ayudín Limón 500ml', 4.10, 5.40, 38, 8, 5],
            [33, '7751111004444', 'Limpiador Líquido Poett Bebé 900ml', 4.60, 5.90, 30, 6, 5],
            [34, '7750124001152', 'Cloro Tradicional Clorox Botella 930ml', 2.80, 3.70, 70, 12, 5],
            [35, '7750999004412', 'Detergente Líquido Ariel Concentrado 800ml', 9.50, 12.40, 28, 5, 5],
            [36, '7501001156789', 'Crema Dental Colgate Triple Acción 75ml', 3.80, 4.90, 65, 12, 6],
            [37, '7751222003333', 'Jabón de Tocador Bolívar Glicerina 120g', 2.10, 2.90, 4, 15, 6],
            [38, '7501001160021', 'Champú Sedal Ceramidas Botella 340ml', 8.50, 11.20, 32, 6, 6],
            [39, '7702003011421', 'Desodorante Rexona Clinical Aerosol 150ml', 11.80, 15.50, 25, 5, 6],
            [40, '7501001170241', 'Enjuague Bucal Colgate Plax Menta 250ml', 7.20, 9.80, 22, 4, 6],
        ] as [$id, $codigo, $descripcion, $costo, $venta, $stock, $minimo, $categoria]) {
            Producto::updateOrCreate(['id_producto' => $id], [
                'codigo_barras' => $codigo,
                'descripcion' => $descripcion,
                'precio_costo' => $costo,
                'precio_venta' => $venta,
                'stock_actual' => $stock,
                'stock_minimo' => $minimo,
                'id_categoria' => $categoria,
            ]);
        $auditorias = [
            [1, 1, 'SISTEMA', 'INSERCIÓN', 'Inicialización e inyección del esquema DDL del núcleo transaccional.', '192.168.1.50', now()->subDays(10)],
            [2, 1, 'SEGURIDAD', 'INSERCIÓN', 'Alta del catálogo inicial de roles del sistema RBAC basados en RUP.', '192.168.1.50', now()->subDays(10)],
            [3, 1, 'CONFIGURACIÓN', 'MODIFICACIÓN', 'Establecimiento del parámetro IGV nacional al 18.00% por defecto.', '192.168.1.50', now()->subDays(10)],
            [4, 1, 'TIENDAS', 'INSERCIÓN', 'Registro inicial de los 3 locales autorizados de tiendas MASS Perú.', '192.168.1.50', now()->subDays(10)],
            [5, 1, 'USUARIOS', 'INSERCIÓN', 'Creación de credenciales para el usuario administrador corporativo: admin_mass.', '192.168.1.50', now()->subDays(9)],
            [6, 1, 'USUARIOS', 'INSERCIÓN', 'Creación de cuenta operativa para el rol Gerente: gerente_comas.', '192.168.1.50', now()->subDays(9)],
            [7, 1, 'USUARIOS', 'INSERCIÓN', 'Creación de cuenta operativa para el rol Cajero POS: cajero_luis.', '192.168.1.50', now()->subDays(9)],
            [8, 1, 'USUARIOS', 'INSERCIÓN', 'Creación de cuenta operativa para el rol Almacenero: almacen_jorge.', '192.168.1.50', now()->subDays(9)],
            [9, 1, 'CATÁLOGO', 'INSERCIÓN', 'Configuración de las 6 categorías maestras de distribución comercial.', '192.168.1.52', now()->subDays(8)],
            [10, 1, 'CATÁLOGO', 'INSERCIÓN', 'Carga masiva mediante script de los 40 artículos del inventario de consumo masivo.', '192.168.1.52', now()->subDays(8)],
            [11, null, 'AUTENTICACIÓN', 'ACCESO_FALLIDO', 'Intento de inicio de sesión denegado. Usuario no registrado: usr_test_01.', '192.168.1.104', now()->subDays(7)],
            [12, 2, 'AUTENTICACIÓN', 'ACCESO', 'Inicio de sesión exitoso en terminal gerencial. Usuario: gerente_comas.', '192.168.1.100', now()->subDays(7)],
            [13, 2, 'CATÁLOGO', 'ACCESO', 'Consulta general analítica del catálogo maestro de productos de la tienda.', '192.168.1.100', now()->subDays(7)],
            [14, 2, 'AUTENTICACIÓN', 'CIERRE', 'Cierre de sesión seguro en terminal gerencial por inactividad prolongada.', '192.168.1.100', now()->subDays(7)],
            [15, 4, 'AUTENTICACIÓN', 'ACCESO', 'Inicio de sesión exitoso en terminal de almacén. Usuario: almacen_jorge.', '192.168.1.105', now()->subDays(6)],
            [16, 4, 'INVENTARIO', 'INSERCIÓN', 'Entrada física: lote de 150 und. de Arroz Costeño por camión de distribución.', '192.168.1.105', now()->subDays(6)],
            [17, 4, 'INVENTARIO', 'INSERCIÓN', 'Entrada física: lote de 300 und. de Leche Gloria Lata desde almacén central.', '192.168.1.105', now()->subDays(6)],
            [18, 4, 'INVENTARIO', 'MODIFICACIÓN', 'Registro de merma: 6 latas de atún descartadas por abolladura crítica.', '192.168.1.105', now()->subDays(5)],
            [19, 4, 'AUTENTICACIÓN', 'CIERRE', 'Cierre de sesión manual ejecutado desde el entorno de almacén.', '192.168.1.105', now()->subDays(5)],
            [20, 3, 'AUTENTICACIÓN', 'ACCESO', 'Inicio de sesión exitoso en terminal POS-01 de caja. Usuario: cajero_luis.', '192.168.1.200', now()->subDays(4)],
            [21, 3, 'CAJA', 'MODIFICACIÓN', 'Apertura de caja chica POS activa con saldo base inicial de S/ 150.00.', '192.168.1.200', now()->subDays(4)],
            [22, 3, 'VENTAS', 'INSERCIÓN', 'Procesamiento de venta POS exitoso. Boleta N.° B001-00000001.', '192.168.1.200', now()->subDays(4)],
            [23, 3, 'VENTAS', 'INSERCIÓN', 'Procesamiento de venta POS exitoso. Boleta N.° B001-00000002.', '192.168.1.200', now()->subDays(4)],
            [24, null, 'AUTENTICACIÓN', 'ACCESO_FALLIDO', 'Intento de inicio de sesión denegado. Contraseña errónea para: admin_mass.', '192.168.1.55', now()->subDays(3)],
            [25, 1, 'AUTENTICACIÓN', 'ACCESO', 'Inicio de sesión exitoso de superusuario desde IP de soporte técnico.', '192.168.1.55', now()->subDays(3)],
            [26, 1, 'USUARIOS', 'MODIFICACIÓN', 'Actualización de estado civil y correo electrónico del usuario cajero_luis.', '192.168.1.55', now()->subDays(3)],
            [27, 1, 'REPORTES', 'ACCESO', 'Extracción y exportación del historial completo de registros técnicos a PDF.', '192.168.1.55', now()->subDays(3)],
            [28, 3, 'VENTAS', 'INSERCIÓN', 'Procesamiento de venta POS exitoso. Factura N.° F001-00000001 para cliente con RUC.', '192.168.1.200', now()->subDays(2)],
            [29, 3, 'VENTAS', 'INSERCIÓN', 'Procesamiento de venta POS exitoso. Boleta N.° B001-00000003.', '192.168.1.200', now()->subDays(2)],
            [30, 3, 'VENTAS', 'INSERCIÓN', 'Procesamiento de venta POS exitoso. Boleta N.° B001-00000004.', '192.168.1.200', now()->subDays(2)],
            [31, 3, 'CAJA', 'MODIFICACIÓN', 'Cierre y arqueo de caja POS-01 efectuado. Consolidado sin mermas.', '192.168.1.200', now()->subDays(2)],
            [32, 2, 'AUTENTICACIÓN', 'ACCESO', 'Inicio de sesión exitoso en entorno gerencial. Usuario: gerente_comas.', '192.168.1.100', now()->subDay()],
            [33, 2, 'REPORTES', 'ACCESO', 'Generación de reporte analítico mensual consolidado de ventas del local.', '192.168.1.100', now()->subDay()],
            [34, 4, 'INVENTARIO', 'MODIFICACIÓN', 'Registro de desmedro: 2 potes de Mantequilla Laive por pérdida de cadena de frío.', '192.168.1.105', now()->subHours(12)],
            [35, 2, 'INVENTARIO', 'ACCESO', 'Auditoría interna visual de alertas críticas por quiebre de stock mínimo.', '192.168.1.100', now()->subHours(6)],
            [36, 3, 'AUTENTICACIÓN', 'ACCESO', 'Inicio de sesión matutino en caja POS-01. Usuario: cajero_luis.', '192.168.1.200', now()->subHours(2)],
            [37, 3, 'CAJA', 'MODIFICACIÓN', 'Apertura de caja diaria POS-01 registrada con S/ 150.00 en efectivo base.', '192.168.1.200', now()->subHours(2)],
            [38, 3, 'VENTAS', 'INSERCIÓN', 'Procesamiento de venta POS exitoso. Boleta N.° B001-00000005.', '192.168.1.200', now()->subMinutes(45)],
            [39, 3, 'VENTAS', 'INSERCIÓN', 'Procesamiento de venta POS exitoso. Boleta N.° B001-00000006.', '192.168.1.200', now()->subMinutes(15)],
            [40, 1, 'SEGURIDAD', 'ACCESO', 'Ingreso de control al panel general para supervisión en vivo del sistema.', '192.168.1.55', now()],
        ];

        foreach ($auditorias as [$id, $usuario, $modulo, $accion, $descripcion, $ip, $fecha]) {
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
