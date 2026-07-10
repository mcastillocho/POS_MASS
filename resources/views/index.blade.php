<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MASS Control Operativo</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/css/styles.css">
</head>
<body>


<div id="login-screen">
  <div class="login-card">
    <div class="login-logo">MASS</div>
    <div class="login-sub">Sistema de Control Operativo - Plataforma Integral</div>
    <div class="field-group">
      <label>Usuario</label>
      <input type="text" id="login-user" placeholder="Ingresa tu usuario" autocomplete="username">
    </div>
    <div class="field-group">
      <label>Contraseña</label>
      <input type="password" id="login-pass" placeholder="********" autocomplete="current-password">
    </div>
    <button class="btn-login" id="btn-login-submit">Ingresar al sistema</button>
    <div class="login-error" id="login-error"></div>
    <div class="login-hint">
    Demo: <strong>admin_mass / password</strong> - Administrador total del sistema
    </div>
  </div>
</div>


<div id="app">

  
  <aside class="sidebar">
    <div class="sidebar-header">
      <div class="logo-text">MASS</div>
      <div class="logo-badge">Control Operativo</div>
    </div>
    <div class="user-chip">
      <div class="user-chip-name" id="chip-name"></div>
      <div class="user-chip-role" id="chip-role"></div>
      <div class="user-chip-store" id="chip-store"></div>
    </div>
    <nav>
      <div class="nav-section">Principal</div>
      <div class="nav-item active" data-page="dashboard">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
        Dashboard
      </div>
      <div class="nav-item" data-page="pos">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
        Punto de Venta
      </div>
      <div class="nav-section">Gestión</div>
      <div class="nav-item" data-page="productos">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
        Productos
      </div>
      <div class="nav-item" data-page="inventario">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg>
        Inventario
      </div>
      <div class="nav-item" data-page="ventas">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
        Ventas
      </div>
      <div class="nav-section">Datos Maestros</div>
      <div class="nav-item" data-page="clientes">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
        Clientes
      </div>
      <div class="nav-item" data-page="proveedores">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
        Proveedores
      </div>
      <div class="nav-item" data-page="empleados">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        Empleados
      </div>
      <div class="nav-section">Análisis</div>
      <div class="nav-item" data-page="reportes">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
        Reportes
      </div>
      <div class="nav-item" data-page="auditoria">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
        Auditoría
      </div>
      <div class="nav-section">Sistema</div>
      <div class="nav-item" data-page="usuarios">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M6 20v-2a6 6 0 0112 0v2"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
        Usuarios
      </div>
    </nav>
    <div class="sidebar-footer">
      <button class="btn-logout" id="btn-logout"> Cerrar sesión</button>
    </div>
  </aside>

  
  <div class="main">
    <div class="topbar">
      <div class="topbar-title" id="page-title">Dashboard</div>
      <div class="topbar-actions">
        <div class="search-bar">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <input type="text" placeholder="Buscar..." id="global-search">
        </div>
      </div>
    </div>

    <div class="content">

      
      <div class="page active" id="page-dashboard">
        <div class="kpi-grid" id="kpi-grid">
          <div class="kpi-card red">
            <div class="kpi-label">Ventas Hoy</div>
            <div class="kpi-value red" id="kpi-ventas-hoy"></div>
            <div class="kpi-sub">transacciones</div>
          </div>
          <div class="kpi-card green">
            <div class="kpi-label">Ingresos Hoy</div>
            <div class="kpi-value green" id="kpi-ingresos-hoy"></div>
            <div class="kpi-sub">soles</div>
          </div>
          <div class="kpi-card yellow">
            <div class="kpi-label">Stock Crítico</div>
            <div class="kpi-value yellow" id="kpi-critico"></div>
            <div class="kpi-sub">productos</div>
          </div>
          <div class="kpi-card blue">
            <div class="kpi-label">Productos Activos</div>
            <div class="kpi-value blue" id="kpi-productos"></div>
            <div class="kpi-sub">en catálogo</div>
          </div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">
          <div class="card">
            <div class="card-title">Ventas últimos 7 días</div>
            <div id="chart-ventas" class="chart-bar-wrap"></div>
          </div>
          <div class="card">
            <div class="card-title">Alertas de Stock</div>
            <div id="alertas-stock"></div>
          </div>
        </div>
      </div>

      
      <div class="page" id="page-pos">
        <div class="pos-layout">
          <div class="pos-products">
            <div class="section-header">
              <div class="section-title">Punto de Venta</div>
              <div class="search-bar" style="width:240px">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" placeholder="Código o nombre..." id="pos-search">
              </div>
            </div>
            <div class="table-wrap">
              <table>
                <thead><tr><th>Código</th><th>Producto</th><th>Categoría</th><th>Precio</th><th>Stock</th><th></th></tr></thead>
                <tbody id="pos-table"></tbody>
              </table>
            </div>
          </div>
          <div class="pos-cart">
            <div class="pos-cart-header">Carrito de compra</div>
            <div class="pos-cart-items" id="cart-items">
              <div class="empty-state" style="padding:30px 0">
                <div style="font-size:32px;margin-bottom:8px"></div>
                <div style="font-size:12px;color:var(--muted)">Agrega productos al carrito</div>
              </div>
            </div>
            <div class="pos-cart-footer">
              <div class="pos-total-row"><span>Subtotal</span><span id="cart-sub">S/ 0.00</span></div>
              <div class="pos-total-row"><span>IGV (18%)</span><span id="cart-igv">S/ 0.00</span></div>
              <div class="pos-total-row main"><span>TOTAL</span><span id="cart-total">S/ 0.00</span></div>
              <div class="form-field" style="margin:12px 0 8px">
                <label>Método de pago</label>
                <select id="pos-metodo">
                  <option value="efectivo">Efectivo</option>
                  <option value="tarjeta">Tarjeta</option>
                  <option value="yape">Yape</option>
                  <option value="plin">Plin</option>
                </select>
              </div>
              <div class="form-field" style="margin-bottom:12px">
                <label>Cliente (opcional)</label>
                <input type="text" id="pos-cliente-search" placeholder="Buscar DNI o nombre...">
              </div>
              <button class="btn btn-primary" style="width:100%;justify-content:center;padding:14px" id="btn-procesar-venta">
                Procesar Venta
              </button>
              <button class="btn btn-secondary" style="width:100%;justify-content:center;margin-top:8px" id="btn-clear-cart">
                Limpiar carrito
              </button>
            </div>
          </div>
        </div>
      </div>

      
      <div class="page" id="page-productos">
        <div class="section-header">
          <div class="section-title">Gestión de Productos</div>
          <button class="btn btn-primary" id="btn-nuevo-producto">+ Nuevo Producto</button>
        </div>
        <div class="filters-bar">
          <div class="search-bar" style="width:240px">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" placeholder="Buscar producto..." id="prod-search">
          </div>
          <select id="prod-cat-filter" style="background:var(--bg3);border:1px solid var(--border);color:var(--text);padding:9px 12px;border-radius:8px;font-size:13px">
            <option value="">Todas las categorías</option>
          </select>
        </div>
        <div class="table-wrap">
          <table>
            <thead><tr><th>Código</th><th>Producto</th><th>Categoría</th><th>Precio</th><th>Stock</th><th>Estado</th><th>Acciones</th></tr></thead>
            <tbody id="prod-table"></tbody>
          </table>
        </div>
      </div>

      
      <div class="page" id="page-inventario">
        <div class="section-header">
          <div class="section-title">Control de Inventario</div>
          <button class="btn btn-primary" id="btn-mov-inventario">+ Registrar Movimiento</button>
        </div>
        <div id="inv-alertas-wrap" style="margin-bottom:16px"></div>
        <div class="table-wrap">
          <table>
            <thead><tr><th>Código</th><th>Producto</th><th>Categoría</th><th>Stock Actual</th><th>Stock Mín.</th><th>Estado</th></tr></thead>
            <tbody id="inv-table"></tbody>
          </table>
        </div>
      </div>

      
      <div class="page" id="page-ventas">
        <div class="section-header">
          <div class="section-title">Consulta de Ventas</div>
        </div>
        <div class="filters-bar">
          <div class="form-field" style="margin:0">
            <label style="font-size:10px">Desde</label>
            <input type="date" id="v-desde" style="padding:8px 12px">
          </div>
          <div class="form-field" style="margin:0">
            <label style="font-size:10px">Hasta</label>
            <input type="date" id="v-hasta" style="padding:8px 12px">
          </div>
          <button class="btn btn-secondary">Filtrar</button>
          <button class="btn btn-success btn-sm">Exportar</button>
        </div>
        <div class="table-wrap">
          <table>
            <thead><tr><th>ID</th><th>Fecha</th><th>Cliente</th><th>Cajero</th><th>Subtotal</th><th>IGV</th><th>Total</th><th>Pago</th><th>Estado</th></tr></thead>
            <tbody id="ventas-table"></tbody>
          </table>
        </div>
      </div>

      
      <div class="page" id="page-clientes">
        <div class="section-header">
          <div class="section-title">Gestión de Clientes</div>
          <button class="btn btn-primary" id="btn-nuevo-cliente">+ Nuevo Cliente</button>
        </div>
        <div class="filters-bar">
          <div class="search-bar" style="width:280px">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" placeholder="DNI, nombre o apellido..." id="cli-search">
          </div>
        </div>
        <div class="table-wrap">
          <table>
            <thead><tr><th>Nombres</th><th>Apellidos</th><th>DNI/RUC</th><th>Teléfono</th><th>Correo</th></tr></thead>
            <tbody id="cli-table"></tbody>
          </table>
        </div>
      </div>

      
      <div class="page" id="page-proveedores">
        <div class="section-header">
          <div class="section-title">Gestión de Proveedores</div>
          <button class="btn btn-primary" id="btn-nuevo-proveedor">+ Nuevo Proveedor</button>
        </div>
        <div class="table-wrap">
          <table>
            <thead><tr><th>Nombre</th><th>RUC</th><th>Razón Social</th><th>Teléfono</th><th>Correo</th></tr></thead>
            <tbody id="prov-table"></tbody>
          </table>
        </div>
      </div>

      
      <div class="page" id="page-empleados">
        <div class="section-header">
          <div class="section-title">Gestión de Empleados</div>
          <button class="btn btn-primary" id="btn-nuevo-empleado">+ Nuevo Empleado</button>
        </div>
        <div class="table-wrap">
          <table>
            <thead><tr><th>Nombres</th><th>Apellidos</th><th>DNI</th><th>Cargo</th><th>Tienda</th><th>Ingreso</th></tr></thead>
            <tbody id="emp-table"></tbody>
          </table>
        </div>
      </div>

      
      <div class="page" id="page-reportes">
        <div class="section-header">
          <div class="section-title">Reportes Operativos</div>
        </div>
        <div class="filters-bar">
          <select id="rep-tipo" style="background:var(--bg3);border:1px solid var(--border);color:var(--text);padding:9px 12px;border-radius:8px;font-size:13px">
            <option value="ventas">Reporte de Ventas</option>
            <option value="productos">Productos más Vendidos</option>
            <option value="stock">Reporte de Stock</option>
          </select>
          <input type="date" id="rep-desde" style="background:var(--bg3);border:1px solid var(--border);color:var(--text);padding:9px 12px;border-radius:8px;font-size:13px">
          <input type="date" id="rep-hasta" style="background:var(--bg3);border:1px solid var(--border);color:var(--text);padding:9px 12px;border-radius:8px;font-size:13px">
          <button class="btn btn-primary">Generar</button>
          <button class="btn btn-success btn-sm">Exportar CSV</button>
        </div>
        <div id="reporte-summary" class="report-summary"></div>
        <div class="table-wrap">
          <table>
            <thead id="rep-thead"></thead>
            <tbody id="rep-tbody"></tbody>
          </table>
        </div>
      </div>

      
      <div class="page" id="page-auditoria">
        <div class="section-header">
          <div class="section-title">Registro de Auditoría</div>
        </div>
        <div class="filters-bar">
          <input type="date" id="aud-desde" style="background:var(--bg3);border:1px solid var(--border);color:var(--text);padding:9px 12px;border-radius:8px;font-size:13px">
          <input type="date" id="aud-hasta" style="background:var(--bg3);border:1px solid var(--border);color:var(--text);padding:9px 12px;border-radius:8px;font-size:13px">
          <select id="aud-modulo" style="background:var(--bg3);border:1px solid var(--border);color:var(--text);padding:9px 12px;border-radius:8px;font-size:13px">
            <option value="">Todos los módulos</option>
            <option value="Autenticación">Autenticación</option>
            <option value="Productos">Productos</option>
            <option value="Inventario">Inventario</option>
            <option value="Ventas">Ventas</option>
            <option value="Usuarios">Usuarios</option>
            <option value="Clientes">Clientes</option>
          </select>
          <button class="btn btn-secondary">Filtrar</button>
        </div>
        <div class="table-wrap">
          <table>
            <thead><tr><th>Fecha / Hora</th><th>Módulo</th><th>Acción</th><th>Usuario</th><th>IP</th><th>Descripción</th></tr></thead>
            <tbody id="aud-table"></tbody>
          </table>
        </div>
      </div>

      
      <div class="page" id="page-usuarios">
        <div class="section-header">
          <div class="section-title">Administración de Usuarios</div>
          <button class="btn btn-primary" id="btn-nuevo-usuario">+ Nuevo Usuario</button>
        </div>
        <div class="table-wrap">
          <table>
            <thead><tr><th>Nombre</th><th>Usuario</th><th>Rol</th><th>Tienda</th><th>Estado</th><th>Acciones</th></tr></thead>
            <tbody id="usr-table"></tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</div>




<div class="modal-overlay" id="modal-producto">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title" id="modal-prod-title">Nuevo Producto</div>
      <button class="modal-close"></button>
    </div>
    <div class="form-grid">
      <div class="form-field"><label>Código *</label><input type="text" id="prod-codigo" placeholder="BEB001"></div>
      <div class="form-field"><label>Nombre *</label><input type="text" id="prod-nombre" placeholder="Nombre del producto"></div>
      <div class="form-field"><label>Precio (S/) *</label><input type="number" id="prod-precio" step="0.01" placeholder="0.00"></div>
      <div class="form-field"><label>Stock Mínimo</label><input type="number" id="prod-stock-min" value="5"></div>
      <div class="form-field"><label>Categoría *</label><select id="prod-cat-sel"></select></div>
      <div class="form-field"><label>Proveedor</label><select id="prod-prov-sel"><option value="">Sin asignar</option></select></div>
    </div>
    <div class="form-field" style="margin-bottom:20px"><label>Descripción</label><textarea id="prod-desc" rows="2" placeholder="Descripción opcional" style="resize:vertical"></textarea></div>
    <input type="hidden" id="prod-edit-id">
    <div style="display:flex;gap:10px;justify-content:flex-end">
      <button class="btn btn-secondary">Cancelar</button>
      <button class="btn btn-primary" id="btn-guardar-producto">Guardar Producto</button>
    </div>
  </div>
</div>


<div class="modal-overlay" id="modal-inventario">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Registrar Movimiento de Inventario</div>
      <button class="modal-close"></button>
    </div>
    <div class="form-grid">
      <div class="form-field">
        <label>Tipo de Movimiento *</label>
        <select id="inv-tipo">
          <option value="entrada"> Entrada</option>
          <option value="salida"> Salida</option>
          <option value="ajuste"> Ajuste</option>
        </select>
      </div>
      <div class="form-field"><label>Producto *</label><select id="inv-producto-sel"></select></div>
      <div class="form-field"><label>Cantidad *</label><input type="number" id="inv-cantidad" min="1" value="1"></div>
      <div class="form-field"><label>Motivo</label><input type="text" id="inv-motivo" placeholder="Razón del movimiento"></div>
    </div>
    <div style="display:flex;gap:10px;justify-content:flex-end">
      <button class="btn btn-secondary">Cancelar</button>
      <button class="btn btn-primary" id="btn-guardar-movimiento">Registrar</button>
    </div>
  </div>
</div>


<div class="modal-overlay" id="modal-usuario">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title" id="modal-usr-title">Nuevo Usuario</div>
      <button class="modal-close"></button>
    </div>
    <div class="form-grid">
      <div class="form-field"><label>Nombres *</label><input type="text" id="usr-nombres"></div>
      <div class="form-field"><label>Apellidos *</label><input type="text" id="usr-apellidos"></div>
      <div class="form-field"><label>Username *</label><input type="text" id="usr-username"></div>
      <div class="form-field"><label>Contraseña *</label><input type="password" id="usr-password" placeholder="Mín. 6 caracteres"></div>
      <div class="form-field"><label>Rol *</label><select id="usr-rol-sel"></select></div>
      <div class="form-field"><label>Tienda *</label><select id="usr-tienda-sel"></select></div>
      <div class="form-field"><label>Estado</label><select id="usr-estado"><option value="activo">Activo</option><option value="inactivo">Inactivo</option></select></div>
    </div>
    <input type="hidden" id="usr-edit-id">
    <div style="display:flex;gap:10px;justify-content:flex-end">
      <button class="btn btn-secondary">Cancelar</button>
      <button class="btn btn-primary" id="btn-guardar-usuario">Guardar</button>
    </div>
  </div>
</div>


<div class="modal-overlay" id="modal-cliente">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Nuevo Cliente</div>
      <button class="modal-close"></button>
    </div>
    <div class="form-grid">
      <div class="form-field"><label>Nombres *</label><input type="text" id="cli-nombres"></div>
      <div class="form-field"><label>Apellidos *</label><input type="text" id="cli-apellidos"></div>
      <div class="form-field"><label>DNI</label><input type="text" id="cli-dni" maxlength="8"></div>
      <div class="form-field"><label>Teléfono</label><input type="text" id="cli-tel"></div>
      <div class="form-field"><label>Correo</label><input type="email" id="cli-email"></div>
      <div class="form-field"><label>Dirección</label><input type="text" id="cli-dir"></div>
    </div>
    <div style="display:flex;gap:10px;justify-content:flex-end">
      <button class="btn btn-secondary">Cancelar</button>
      <button class="btn btn-primary" id="btn-guardar-cliente">Guardar</button>
    </div>
  </div>
</div>


<div class="modal-overlay" id="modal-proveedor">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Nuevo Proveedor</div>
      <button class="modal-close"></button>
    </div>
    <div class="form-grid">
      <div class="form-field"><label>Nombre *</label><input type="text" id="prov-nombre"></div>
      <div class="form-field"><label>RUC *</label><input type="text" id="prov-ruc" maxlength="11"></div>
      <div class="form-field"><label>Razón Social</label><input type="text" id="prov-razon"></div>
      <div class="form-field"><label>Teléfono</label><input type="text" id="prov-tel"></div>
      <div class="form-field"><label>Correo</label><input type="email" id="prov-email"></div>
      <div class="form-field"><label>Dirección</label><input type="text" id="prov-dir"></div>
    </div>
    <div style="display:flex;gap:10px;justify-content:flex-end">
      <button class="btn btn-secondary">Cancelar</button>
      <button class="btn btn-primary" id="btn-guardar-proveedor">Guardar</button>
    </div>
  </div>
</div>


<div class="modal-overlay" id="modal-empleado">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title">Nuevo Empleado</div>
      <button class="modal-close"></button>
    </div>
    <div class="form-grid">
      <div class="form-field"><label>Nombres *</label><input type="text" id="emp-nombres"></div>
      <div class="form-field"><label>Apellidos *</label><input type="text" id="emp-apellidos"></div>
      <div class="form-field"><label>DNI *</label><input type="text" id="emp-dni" maxlength="8"></div>
      <div class="form-field"><label>Teléfono</label><input type="text" id="emp-tel"></div>
      <div class="form-field"><label>Cargo</label><input type="text" id="emp-cargo" placeholder="Cajero, Almacenero..."></div>
      <div class="form-field"><label>Tienda *</label><select id="emp-tienda-sel"></select></div>
      <div class="form-field"><label>Fecha Ingreso</label><input type="date" id="emp-fecha"></div>
    </div>
    <div style="display:flex;gap:10px;justify-content:flex-end">
      <button class="btn btn-secondary">Cancelar</button>
      <button class="btn btn-primary" id="btn-guardar-empleado">Guardar</button>
    </div>
  </div>
</div>


<div class="toast" id="toast"></div>


<script src="/js/app.js"></script>
</body>
</html>

