-- ══════════════════════════════════════════════════════════
-- SISTEMA MASS - POS (Punto de Venta)
-- Base de Datos Completa con datos de prueba
-- Generado: 2026-07-10
-- ══════════════════════════════════════════════════════════

CREATE DATABASE IF NOT EXISTS `mass`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `mass`;

SET FOREIGN_KEY_CHECKS = 0;

-- ══════════════════════════════════════════════════════════
-- TABLA: roles
-- ══════════════════════════════════════════════════════════
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id_rol` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre_rol` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_rol`),
  UNIQUE KEY `roles_nombre_rol_unique` (`nombre_rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `roles` (`id_rol`, `nombre_rol`, `descripcion`) VALUES
(1, 'Administrador', 'Control integral del sistema y configuracion general.'),
(2, 'Gerente', 'Gestion de tienda, reportes, ventas e inventario.'),
(3, 'Cajero', 'Operacion del punto de venta y emision de comprobantes.'),
(4, 'Almacenero', 'Control de stock, entradas, salidas y alertas de inventario.');

-- ══════════════════════════════════════════════════════════
-- TABLA: tiendas
-- ══════════════════════════════════════════════════════════
DROP TABLE IF EXISTS `tiendas`;
CREATE TABLE `tiendas` (
  `id_tienda` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre_tienda` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ubigeo` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_tienda`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tiendas` (`id_tienda`, `nombre_tienda`, `direccion`, `ubigeo`, `estado`) VALUES
(1, 'MASS Tupac Amaru', 'Av. Tupac Amaru Km 11.5, Comas', '150110', 'activo'),
(2, 'MASS Carlos Izaguirre', 'Av. Carlos Izaguirre 450, Los Olivos', '150117', 'activo'),
(3, 'MASS Universitaria', 'Av. Universitaria 2210, San Miguel', '150136', 'activo');

-- ══════════════════════════════════════════════════════════
-- TABLA: usuarios
-- ══════════════════════════════════════════════════════════
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id_usuario` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombres` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'activo',
  `id_rol` bigint unsigned NOT NULL,
  `id_tienda` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `usuarios_username_unique` (`username`),
  KEY `usuarios_id_rol_foreign` (`id_rol`),
  KEY `usuarios_id_tienda_foreign` (`id_tienda`),
  CONSTRAINT `usuarios_id_rol_foreign` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `usuarios_id_tienda_foreign` FOREIGN KEY (`id_tienda`) REFERENCES `tiendas` (`id_tienda`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Contraseña por defecto (hash de 'johnabadpoma117')
INSERT INTO `usuarios` (`id_usuario`, `nombres`, `apellidos`, `username`, `password_hash`, `estado`, `id_rol`, `id_tienda`) VALUES
(1, 'Carlos Alberto', 'Mendoza Ramos',   'admin_mass',       '$2y$12$placeholderHashAdminXXXXXXXXXXXXXXXXXXXXXXXXX', 'activo', 1, 1),
(2, 'Ana Sofia',     'Palacios Vega',    'gerente_comas',    '$2y$12$placeholderHashGerenteXXXXXXXXXXXXXXXXXXXXXXX', 'activo', 2, 1),
(3, 'Luis Enrique',  'Flores Quispe',    'cajero_luis',      '$2y$12$placeholderHashCajeroXXXXXXXXXXXXXXXXXXXXXXXX', 'activo', 3, 1),
(4, 'Jorge Luis',    'Tapia Sanchez',    'almacen_jorge',    '$2y$12$placeholderHashAlmacenXXXXXXXXXXXXXXXXXXXXXXX', 'activo', 4, 1),
(5, 'Mariela',       'Condori Huaman',   'cajera_maria',     '$2y$12$placeholderHashCajera2XXXXXXXXXXXXXXXXXXXXXXXXX', 'activo', 3, 2),
(6, 'Rosa Elvira',   'Vargas Salazar',   'supervision_mass', '$2y$12$placeholderHashSuperviXXXXXXXXXXXXXXXXXXXXXXX', 'activo', 2, 3);

-- ══════════════════════════════════════════════════════════
-- TABLA: categorias
-- ══════════════════════════════════════════════════════════
DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias` (
  `id_categoria` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre_categoria` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_categoria`),
  UNIQUE KEY `categorias_nombre_categoria_unique` (`nombre_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `categorias` (`id_categoria`, `nombre_categoria`, `descripcion`) VALUES
(1, 'Abarrotes y Despensa',  'Arroz, azucar, fideos, aceites, conservas y salsas.'),
(2, 'Bebidas y Licores',     'Gaseosas, aguas, jugos, cervezas y rehidratantes.'),
(3, 'Lacteos y Embutidos',   'Leches, yogures, quesos, mantequillas y embutidos.'),
(4, 'Snacks y Confiteria',   'Galletas, papitas, chocolates y dulces.'),
(5, 'Limpieza del Hogar',    'Detergentes, lavavajillas, limpiadores y desinfectantes.'),
(6, 'Cuidado Personal',      'Champu, jabones, desodorantes y pasta dental.');

-- ══════════════════════════════════════════════════════════
-- TABLA: proveedores
-- ══════════════════════════════════════════════════════════
DROP TABLE IF EXISTS `proveedores`;
CREATE TABLE `proveedores` (
  `id_proveedor` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ruc` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `razon_social` varchar(160) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_proveedor`),
  UNIQUE KEY `proveedores_ruc_unique` (`ruc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `proveedores` (`id_proveedor`, `nombre`, `ruc`, `razon_social`, `telefono`, `correo`, `direccion`) VALUES
(1, 'Distribuidora Lima Norte', '20548796521', 'Distribuidora Lima Norte S.A.C.', '987654321', 'ventas@limanorte.pe',     'Av. Alfredo Mendiola 6200, Los Olivos'),
(2, 'Abarrotes del Peru',       '20601478563', 'Abarrotes del Peru E.I.R.L.',    '976542118', 'pedidos@abarrotesperu.pe', 'Jr. Huallaga 420, Lima'),
(3, 'Bebidas Andinas',          '20478563219', 'Bebidas Andinas S.A.C.',          '965874123', 'comercial@bebidasandinas.pe', 'Av. Argentina 3090, Callao'),
(4, 'Lacteos del Sur',          '20563214789', 'Lacteos del Sur S.R.L.',          '954321778', 'ventas@lacteosdelsur.pe',  'Av. Industrial 155, Ate'),
(5, 'Limpieza Hogar Peru',      '20657891432', 'Limpieza Hogar Peru S.A.C.',      '943218765', 'contacto@limpiezahogar.pe','Av. Nicolas Ayllon 1980, Santa Anita'),
(6, 'Consumo Masivo Sol',       '20591478326', 'Consumo Masivo Sol E.I.R.L.',     '932145678', 'ventas@cmsol.pe',          'Av. Universitaria 1890, San Miguel');

-- ══════════════════════════════════════════════════════════
-- TABLA: productos (incluye id_proveedor)
-- ══════════════════════════════════════════════════════════
DROP TABLE IF EXISTS `productos`;
CREATE TABLE `productos` (
  `id_producto` bigint unsigned NOT NULL AUTO_INCREMENT,
  `codigo_barras` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio_costo` decimal(10,2) NOT NULL DEFAULT '0.00',
  `precio_venta` decimal(10,2) NOT NULL,
  `stock_actual` int NOT NULL DEFAULT '0',
  `stock_minimo` int NOT NULL DEFAULT '0',
  `id_categoria` bigint unsigned NOT NULL,
  `id_proveedor` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_producto`),
  UNIQUE KEY `productos_codigo_barras_unique` (`codigo_barras`),
  KEY `productos_id_categoria_foreign` (`id_categoria`),
  KEY `productos_id_proveedor_foreign` (`id_proveedor`),
  CONSTRAINT `productos_id_categoria_foreign` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `productos_id_proveedor_foreign` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `productos` (`id_producto`, `codigo_barras`, `descripcion`, `precio_costo`, `precio_venta`, `stock_actual`, `stock_minimo`, `id_categoria`, `id_proveedor`) VALUES
(1,  '7750111001234', 'Arroz Superior Costeno 1kg',              3.40,  4.20, 120, 15, 1, 2),
(2,  '7750222005678', 'Azucar Rubia Cartavio 1kg',               3.10,  3.80,  85, 15, 1, 2),
(3,  '7501005112345', 'Aceite Vegetal Primor 1L',                7.50,  9.40,  45, 10, 1, 1),
(4,  '7750333001111', 'Fideo Don Vittorio Espagueti 450g',       2.10,  2.70, 200, 20, 1, 1),
(5,  '7750444002222', 'Trozos de Atun Real 170g',                4.20,  5.50,  60, 12, 1, 6),
(6,  '7750014000315', 'Gaseosa Inca Kola 2L',                    4.80,  6.00,  90, 15, 2, 3),
(7,  '7750014000100', 'Gaseosa Coca-Cola Sin Azucar 1.5L',       4.20,  5.30,  75, 15, 2, 3),
(8,  '7750888003333', 'Agua Mineral Cielo 625ml',                0.80,  1.50, 150, 25, 2, 3),
(9,  '7751234009999', 'Cerveza Cristal Lata 355ml',              3.50,  4.50,   8, 24, 2, 3),
(10, '7750006002549', 'Leche Evaporada Gloria 400g',             3.20,  4.10, 300, 30, 3, 4),
(11, '7750006001108', 'Yogurt Gloria Fresa 1kg',                 4.90,  6.20,  35,  8, 3, 4),
(12, '7750555003333', 'Mantequilla Laive con Sal 200g',          4.50,  5.80,   3, 10, 3, 4),
(13, '7750666004444', 'Galletas Soda Field Familiar',            3.10,  4.00, 110, 15, 4, 6),
(14, '7501011132023', 'Papas Lays Clasicas 160g',                5.20,  6.80,  42, 10, 4, 6),
(15, '7750777008888', 'Chocolate Sublime Clasico 30g',           1.20,  1.80, 250, 35, 4, 6),
(16, '7750999001111', 'Detergente Opal Ultra 800g',              6.80,  8.50,  50, 10, 5, 5),
(17, '7750999002222', 'Lavavajillas Ayudin Limon 500ml',         4.10,  5.40,  38,  8, 5, 5),
(18, '7751111004444', 'Limpiador Poett Bebe 900ml',              4.60,  5.90,  30,  6, 5, 5),
(19, '7501001156789', 'Crema Dental Colgate Triple Accion 75ml', 3.80,  4.90,  65, 12, 6, 6),
(20, '7751222003333', 'Jabon Bolivar Glicerina 120g',            2.10,  2.90,   4, 15, 6, 6);

-- ══════════════════════════════════════════════════════════
-- TABLA: clientes
-- ══════════════════════════════════════════════════════════
DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes` (
  `id_cliente` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombres` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dni` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_cliente`),
  UNIQUE KEY `clientes_dni_unique` (`dni`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `clientes` (`nombres`, `apellidos`, `dni`, `telefono`, `correo`, `direccion`) VALUES
('Lucia',       'Rojas Campos',    '72845163', '987321456', 'lucia.rojas@mail.com',      'Jr. Los Fresnos 145, Comas'),
('Miguel Angel','Castillo Vega',   '46123985', '956874120', 'miguel.castillo@mail.com',  'Av. Las Palmeras 330, Los Olivos'),
('Fiorella',    'Salazar Huerta',  '70321458', '965214789', 'fiorella.salazar@mail.com', 'Calle Los Cedros 280, Independencia'),
('Pedro Luis',  'Quispe Arias',    '45879632', '943785612', 'pedro.quispe@mail.com',     'Av. Peru 1880, San Martin de Porres'),
('Valeria',     'Paredes Nunez',   '76985412', '932147865', 'valeria.paredes@mail.com',  'Jr. Manco Capac 557, Lima');

-- ══════════════════════════════════════════════════════════
-- TABLA: empleados
-- ══════════════════════════════════════════════════════════
DROP TABLE IF EXISTS `empleados`;
CREATE TABLE `empleados` (
  `id_empleado` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombres` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dni` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cargo` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_tienda` bigint unsigned DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_empleado`),
  UNIQUE KEY `empleados_dni_unique` (`dni`),
  KEY `empleados_id_tienda_foreign` (`id_tienda`),
  CONSTRAINT `empleados_id_tienda_foreign` FOREIGN KEY (`id_tienda`) REFERENCES `tiendas` (`id_tienda`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `empleados` (`nombres`, `apellidos`, `dni`, `telefono`, `cargo`, `id_tienda`, `fecha_ingreso`) VALUES
('Carlos Alberto', 'Mendoza Ramos',   '72984516', '987654321', 'Administrador',    1, '2024-03-01'),
('Ana Sofia',      'Palacios Vega',   '70451238', '976541230', 'Gerente de Tienda',1, '2024-05-15'),
('Luis Enrique',   'Flores Quispe',   '71896543', '965874120', 'Cajero',           1, '2025-01-10'),
('Jorge Luis',     'Tapia Sanchez',   '70589632', '954321789', 'Almacenero',       1, '2025-02-20'),
('Mariela',        'Condori Huaman',  '76231458', '943217865', 'Cajero',           2, '2025-04-12');

-- ══════════════════════════════════════════════════════════
-- TABLA: inventarios_movimientos
-- ══════════════════════════════════════════════════════════
DROP TABLE IF EXISTS `inventarios_movimientos`;
CREATE TABLE `inventarios_movimientos` (
  `id_movimiento` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_producto` bigint unsigned NOT NULL,
  `tipo_movimiento` enum('ENTRADA','SALIDA') COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad` int NOT NULL,
  `motivo` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_movimiento` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_movimiento`),
  KEY `inventarios_movimientos_id_producto_foreign` (`id_producto`),
  CONSTRAINT `inventarios_movimientos_id_producto_foreign` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `inventarios_movimientos` (`id_movimiento`, `id_producto`, `tipo_movimiento`, `cantidad`, `motivo`, `fecha_movimiento`) VALUES
(1,  1,  'ENTRADA', 80, 'Ingreso por compra a proveedor',        DATE_SUB(NOW(), INTERVAL 6 DAY)),
(2,  6,  'ENTRADA', 60, 'Reposicion de bebidas',                 DATE_SUB(NOW(), INTERVAL 5 DAY)),
(3,  9,  'SALIDA',  16, 'Venta y merma por vencimiento cercano', DATE_SUB(NOW(), INTERVAL 4 DAY)),
(4,  12, 'SALIDA',   5, 'Ajuste por cadena de frio',             DATE_SUB(NOW(), INTERVAL 3 DAY)),
(5,  16, 'ENTRADA', 30, 'Ingreso de limpieza',                   DATE_SUB(NOW(), INTERVAL 2 DAY)),
(6,  20, 'SALIDA',   8, 'Salida por venta directa',              DATE_SUB(NOW(), INTERVAL 1 DAY));

-- ══════════════════════════════════════════════════════════
-- TABLA: ventas
-- ══════════════════════════════════════════════════════════
DROP TABLE IF EXISTS `ventas`;
CREATE TABLE `ventas` (
  `id_venta` bigint unsigned NOT NULL AUTO_INCREMENT,
  `fecha_hora` datetime NOT NULL,
  `total_neto` decimal(10,2) NOT NULL,
  `igv` decimal(10,2) NOT NULL,
  `total_pagar` decimal(10,2) NOT NULL,
  `metodo_pago` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_usuario` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_venta`),
  KEY `ventas_id_usuario_foreign` (`id_usuario`),
  CONSTRAINT `ventas_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ══════════════════════════════════════════════════════════
-- TABLA: detalles_ventas
-- ══════════════════════════════════════════════════════════
DROP TABLE IF EXISTS `detalles_ventas`;
CREATE TABLE `detalles_ventas` (
  `id_detalle` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_venta` bigint unsigned NOT NULL,
  `id_producto` bigint unsigned NOT NULL,
  `cantidad` int NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_detalle`),
  KEY `detalles_ventas_id_venta_foreign` (`id_venta`),
  KEY `detalles_ventas_id_producto_foreign` (`id_producto`),
  CONSTRAINT `detalles_ventas_id_producto_foreign` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `detalles_ventas_id_venta_foreign` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id_venta`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ══════════════════════════════════════════════════════════
-- TABLA: comprobantes
-- ══════════════════════════════════════════════════════════
DROP TABLE IF EXISTS `comprobantes`;
CREATE TABLE `comprobantes` (
  `id_comprobante` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_venta` bigint unsigned NOT NULL,
  `tipo_comprobante` enum('BOLETA','FACTURA') COLLATE utf8mb4_unicode_ci NOT NULL,
  `serie` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correlativo` int unsigned NOT NULL,
  `documento_cliente` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_comprobante`),
  UNIQUE KEY `comprobantes_tipo_comprobante_serie_correlativo_unique` (`tipo_comprobante`,`serie`,`correlativo`),
  UNIQUE KEY `comprobantes_id_venta_unique` (`id_venta`),
  CONSTRAINT `comprobantes_id_venta_foreign` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id_venta`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ══════════════════════════════════════════════════════════
-- TABLA: auditorias
-- ══════════════════════════════════════════════════════════
DROP TABLE IF EXISTS `auditorias`;
CREATE TABLE `auditorias` (
  `id_auditoria` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint unsigned DEFAULT NULL,
  `modulo_afectado` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accion` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion_detalle` text COLLATE utf8mb4_unicode_ci,
  `ip_origen` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_hora` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_auditoria`),
  KEY `auditorias_id_usuario_foreign` (`id_usuario`),
  CONSTRAINT `auditorias_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ══════════════════════════════════════════════════════════
-- TABLAS LARAVEL INTERNAS
-- ══════════════════════════════════════════════════════════
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;

-- ══════════════════════════════════════════════════════════
-- Fin del script MASS.sql
-- Para restaurar: mysql -u root mass < MASS.sql
-- Luego ejecutar: php artisan db:seed (para datos de prueba con hashes reales)
-- ══════════════════════════════════════════════════════════
