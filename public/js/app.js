(() => {
  'use strict';

  const $ = (id) => document.getElementById(id);
  const state = { currentUser: null, cart: [], productos: [], usuarios: [], roles: [], tiendas: [], reporteData: [] };
  const pageTitles = { dashboard:'Dashboard', pos:'Punto de Venta', productos:'Gestion de Productos', inventario:'Control de Inventario', ventas:'Consulta de Ventas', clientes:'Gestion de Clientes', proveedores:'Gestion de Proveedores', empleados:'Gestion de Empleados', reportes:'Reportes Operativos', auditoria:'Registro de Auditoria', usuarios:'Administracion de Usuarios' };

  window.$ = $;
  window.AppState = state;
  window.fmt = (n) => `S/ ${Number(n || 0).toFixed(2)}`;
  window.badge = (txt, color = 'gray') => `<span class="badge badge-${color}">${txt ?? '-'}</span>`;
  window.stockBadge = (estado) => {
    const map = { NORMAL:['green','Normal'], BAJO:['yellow','Stock Bajo'], CRITICO:['red','Critico'] };
    const [c, t] = map[estado] || ['gray', estado || '-'];
    return badge(t, c);
  };
  window.openModal = (id) => $(id)?.classList.add('open');
  window.closeModal = (id) => $(id)?.classList.remove('open');
  window.toast = (msg, type = 'success') => {
    const t = $('toast');
    if (!t) return;
    t.textContent = msg;
    t.className = `toast ${type} show`;
    setTimeout(() => t.classList.remove('show'), 3200);
  };

  window.apiFetch = async (path, options = {}) => {
    const url = path.startsWith('/api/') ? path : `/api/${path}`;
    const request = { method: options.method || 'GET', headers: { 'Content-Type':'application/json', 'Accept':'application/json' } };
    if (options.body !== undefined) request.body = JSON.stringify(options.body);
    const response = await fetch(url, request);
    const payload = (response.headers.get('content-type') || '').includes('application/json') ? await response.json() : { ok: response.ok };
    if (!response.ok || payload.ok === false) throw new Error(payload.message || 'Error de comunicacion con la API');
    return payload;
  };

  const normalizeProducto = (p) => ({
    id_producto: p.id_producto,
    codigo: p.codigo || p.codigo_barras || '',
    nombre: p.nombre || p.descripcion || '',
    categoria: p.categoria || p.nombre_categoria || p.categoria?.nombre_categoria || '',
    precio: Number(p.precio || p.precio_venta || 0),
    stock_actual: Number(p.stock_actual || 0),
    stock_minimo: Number(p.stock_minimo || 0),
    id_categoria: p.id_categoria,
  });

  function setDefaultDates() {
    const hoy = new Date().toISOString().split('T')[0];
    const mes = new Date(); mes.setDate(1);
    const inicio = mes.toISOString().split('T')[0];
    ['v-desde','v-hasta','rep-desde','rep-hasta','aud-desde','aud-hasta'].forEach((id) => { if ($(id)) $(id).value = id.includes('hasta') ? hoy : inicio; });
  }
  window.setDefaultDates = setDefaultDates;

  async function login() {
    const username = $('login-user')?.value.trim();
    const password = $('login-pass')?.value;
    if (!username || !password) return showLoginError('Completa todos los campos');
    try {
      const { user } = await apiFetch('/api/login', { method:'POST', body:{ username, password } });
      state.currentUser = user;
      initApp();
    } catch (error) { showLoginError(error.message); }
  }

  function showLoginError(msg) {
    const el = $('login-error');
    if (!el) return;
    el.textContent = msg;
    el.style.display = 'block';
  }

  function initApp() {
    const user = state.currentUser || {};
    $('login-screen')?.classList.add('hidden');
    $('app')?.classList.add('visible');
    if ($('app')) $('app').style.display = 'flex';
    if ($('chip-name')) $('chip-name').textContent = `${user.nombres || ''} ${user.apellidos || ''}`.trim() || '-';
    if ($('chip-role')) $('chip-role').textContent = user.rol_nombre || user.rol || '-';
    if ($('chip-store')) $('chip-store').textContent = user.tienda_nombre || user.tienda || '-';
    loadDashboard();
  }
  window.initApp = initApp;

  window.loadDashboard = async () => {
    const { data } = await apiFetch('/api/dashboard');
    $('kpi-ventas-hoy').textContent = data.kpis?.ventas_hoy ?? 0;
    $('kpi-ingresos-hoy').textContent = fmt(data.kpis?.ingresos_hoy);
    $('kpi-critico').textContent = data.kpis?.stock_critico ?? 0;
    $('kpi-productos').textContent = data.kpis?.productos_activos ?? 0;
    const ventas = data.ventas_7_dias || [];
    const max = Math.max(...ventas.map((d) => Number(d.total || 0)), 1);
    $('chart-ventas').innerHTML = ventas.map((d) => `<div class="chart-bar-row"><div class="chart-bar-label">${d.dia}</div><div class="chart-bar-track"><div class="chart-bar-fill" style="width:${((Number(d.total || 0) / max) * 100).toFixed(0)}%"></div></div><div class="chart-bar-val">${fmt(d.total)}</div></div>`).join('');
    $('alertas-stock').innerHTML = (data.alertas || []).map((a) => `<div class="stock-alert"><div class="stock-alert-icon">!</div><div class="stock-alert-info"><div class="stock-alert-name">${a.producto}</div><div class="stock-alert-detail">Stock: <strong style="color:var(--red)">${a.stock}</strong> / Minimo: ${a.min}</div></div></div>`).join('');
  };

  window.loadProductos = async () => {
    const { data } = await apiFetch('/api/productos');
    state.productos = (data.productos || []).map(normalizeProducto);
    if ($('prod-cat-filter')) $('prod-cat-filter').innerHTML = '<option value="">Todas las categorias</option>' + (data.categorias || []).map((c) => `<option>${c.nombre || c.nombre_categoria}</option>`).join('');
    renderProductos(state.productos);
  };

  function renderProductos(productos) {
    $('prod-table').innerHTML = productos.map((p) => `<tr><td><code style="font-size:11px;background:var(--bg3);padding:3px 7px;border-radius:4px">${p.codigo}</code></td><td style="font-weight:600">${p.nombre}</td><td>${badge(p.categoria,'blue')}</td><td style="font-weight:700">${fmt(p.precio)}</td><td>${p.stock_actual}</td><td>${p.stock_actual <= p.stock_minimo ? badge('Critico','red') : badge('Normal','green')}</td><td><button class="btn btn-secondary btn-sm" data-edit-producto="${p.id_producto}">Editar</button></td></tr>`).join('') || '<tr><td colspan="7" style="text-align:center;color:var(--muted);padding:20px">Sin resultados</td></tr>';
    document.querySelectorAll('[data-edit-producto]').forEach((btn) => btn.addEventListener('click', () => editProducto(Number(btn.dataset.editProducto))));
  }

  function filterProductos() {
    const q = ($('prod-search')?.value || '').toLowerCase();
    const cat = $('prod-cat-filter')?.value || '';
    renderProductos(state.productos.filter((p) => (p.nombre.toLowerCase().includes(q) || p.codigo.toLowerCase().includes(q)) && (!cat || p.categoria === cat)));
  }

  async function fillProductCombos() {
    const { data } = await apiFetch('/api/catalogos');
    if ($('prod-cat-sel')) $('prod-cat-sel').innerHTML = (data.categorias || []).map((c) => `<option value="${c.id_categoria}">${c.nombre || c.nombre_categoria}</option>`).join('');
    if ($('prod-prov-sel')) $('prod-prov-sel').innerHTML = '<option value="">Sin asignar</option>' + (data.proveedores || []).map((p) => `<option value="${p.id_proveedor}">${p.nombre}</option>`).join('');
  }

  async function editProducto(id) {
    const p = state.productos.find((item) => item.id_producto === id);
    if (!p) return;
    await fillProductCombos();
    $('modal-prod-title').textContent = 'Editar Producto';
    $('prod-edit-id').value = p.id_producto;
    $('prod-codigo').value = p.codigo;
    $('prod-nombre').value = p.nombre;
    $('prod-precio').value = p.precio;
    $('prod-stock-min').value = p.stock_minimo;
    openModal('modal-producto');
  }
  window.editProducto = editProducto;

  window.loadInventario = async () => {
    const { data } = await apiFetch('/api/inventario');
    const productos = (data.productos || []).map(normalizeProducto).map((p) => ({ ...p, estado: p.stock_actual <= p.stock_minimo ? 'CRITICO' : 'NORMAL' }));
    $('inv-alertas-wrap').innerHTML = `<div class="stock-alert"><div class="stock-alert-icon">!</div><div><div class="stock-alert-name">${data.criticos || 0} productos con stock critico detectados</div><div class="stock-alert-detail">Revisar y reponer urgente</div></div></div>`;
    $('inv-table').innerHTML = productos.map((p) => `<tr><td><code style="font-size:11px;background:var(--bg3);padding:3px 7px;border-radius:4px">${p.codigo}</code></td><td style="font-weight:600">${p.nombre}</td><td>${badge(p.categoria,'blue')}</td><td style="font-weight:700;font-size:15px">${p.stock_actual}</td><td style="color:var(--muted)">${p.stock_minimo}</td><td>${stockBadge(p.estado)}</td></tr>`).join('');
  };

  window.loadPOS = async () => {
    const { data } = await apiFetch('/api/productos');
    state.productos = (data.productos || []).map(normalizeProducto);
    renderPOSTable(state.productos);
  };

  function renderPOSTable(productos) {
    $('pos-table').innerHTML = productos.map((p) => `<tr><td><code style="font-size:11px;background:var(--bg3);padding:3px 7px;border-radius:4px">${p.codigo}</code></td><td style="font-weight:600">${p.nombre}</td><td>${badge(p.categoria,'blue')}</td><td style="color:var(--green);font-weight:700">${fmt(p.precio)}</td><td>${p.stock_actual < 10 ? badge(p.stock_actual,'red') : badge(p.stock_actual,'green')}</td><td><button class="btn btn-primary btn-sm" data-add-cart="${p.id_producto}">+ Agregar</button></td></tr>`).join('') || '<tr><td colspan="6" style="text-align:center;color:var(--muted);padding:20px">Sin resultados</td></tr>';
    document.querySelectorAll('[data-add-cart]').forEach((btn) => btn.addEventListener('click', () => addToCart(Number(btn.dataset.addCart))));
  }

  function addToCart(id) {
    const p = state.productos.find((item) => item.id_producto === id);
    if (!p) return;
    const item = state.cart.find((row) => row.id_producto === id);
    item ? item.cantidad++ : state.cart.push({ ...p, cantidad: 1 });
    renderCart();
    toast(`${p.nombre} agregado`);
  }

  function renderCart() {
    if (!state.cart.length) {
      $('cart-items').innerHTML = '<div class="empty-state" style="padding:30px 0"><div style="font-size:12px;color:var(--muted)">Agrega productos al carrito</div></div>';
      $('cart-sub').textContent = fmt(0); $('cart-igv').textContent = fmt(0); $('cart-total').textContent = fmt(0);
      return;
    }
    $('cart-items').innerHTML = state.cart.map((item) => `<div class="cart-item"><div class="cart-item-info"><div class="cart-item-name">${item.nombre}</div><div class="cart-item-price">${fmt(item.precio)} c/u</div></div><div class="cart-qty"><button class="qty-btn" data-qty-minus="${item.id_producto}">-</button><span style="font-weight:700;min-width:20px;text-align:center">${item.cantidad}</span><button class="qty-btn" data-qty-plus="${item.id_producto}">+</button></div><div class="cart-item-subtotal">${fmt(item.precio * item.cantidad)}</div><button class="btn btn-danger btn-icon btn-sm" data-remove-cart="${item.id_producto}">x</button></div>`).join('');
    document.querySelectorAll('[data-qty-minus]').forEach((btn) => btn.addEventListener('click', () => changeQty(Number(btn.dataset.qtyMinus), -1)));
    document.querySelectorAll('[data-qty-plus]').forEach((btn) => btn.addEventListener('click', () => changeQty(Number(btn.dataset.qtyPlus), 1)));
    document.querySelectorAll('[data-remove-cart]').forEach((btn) => btn.addEventListener('click', () => { state.cart = state.cart.filter((row) => row.id_producto !== Number(btn.dataset.removeCart)); renderCart(); }));
    const sub = state.cart.reduce((sum, item) => sum + item.precio * item.cantidad, 0);
    $('cart-sub').textContent = fmt(sub); $('cart-igv').textContent = fmt(sub * 0.18); $('cart-total').textContent = fmt(sub * 1.18);
  }

  function changeQty(id, delta) {
    const item = state.cart.find((row) => row.id_producto === id);
    if (!item) return;
    item.cantidad = Math.max(1, item.cantidad + delta);
    renderCart();
  }

  window.loadVentas = async () => {
    setDefaultDates();
    const { data } = await apiFetch('/api/ventas');
    $('ventas-table').innerHTML = (data.ventas || []).map((v) => `<tr><td style="font-weight:700;color:var(--blue)">#${v.id_venta}</td><td style="white-space:nowrap;font-size:12px">${v.fecha || v.fecha_hora || ''}</td><td>${v.cliente || '-'}</td><td>${v.cajero || '-'}</td><td>${fmt(v.subtotal || v.total_neto)}</td><td style="color:var(--muted)">${fmt(v.impuesto || v.igv)}</td><td style="font-weight:700;color:var(--green)">${fmt(v.total || v.total_pagar)}</td><td>${badge(v.metodo || v.metodo_pago,'blue')}</td><td>${badge(v.estado || 'Completada','green')}</td></tr>`).join('');
  };

  window.loadClientes = async (q = '') => {
    const { data } = await apiFetch(`/api/clientes?q=${encodeURIComponent(q)}`);
    $('cli-table').innerHTML = (data.clientes || []).map((c) => `<tr><td style="font-weight:600">${c.nombres}</td><td>${c.apellidos || ''}</td><td><code style="font-size:11px">${c.dni || c.documento || ''}</code></td><td>${c.telefono || ''}</td><td style="color:var(--muted)">${c.correo || ''}</td></tr>`).join('') || '<tr><td colspan="5" style="text-align:center;color:var(--muted);padding:20px">No se encontraron clientes</td></tr>';
  };

  window.loadProveedores = async () => {
    const { data } = await apiFetch('/api/proveedores');
    $('prov-table').innerHTML = (data.proveedores || []).map((p) => `<tr><td style="font-weight:600">${p.nombre}</td><td><code style="font-size:11px">${p.ruc || ''}</code></td><td>${p.razon_social || ''}</td><td>${p.telefono || ''}</td><td style="color:var(--muted)">${p.correo || ''}</td></tr>`).join('');
  };

  window.loadEmpleados = async () => {
    const { data } = await apiFetch('/api/empleados');
    $('emp-table').innerHTML = (data.empleados || []).map((e) => `<tr><td style="font-weight:600">${e.nombres}</td><td>${e.apellidos || ''}</td><td><code style="font-size:11px">${e.dni || ''}</code></td><td>${badge(e.cargo || '-', e.cargo === 'Gerente de Tienda' ? 'red' : e.cargo === 'Cajero' ? 'blue' : 'green')}</td><td style="color:var(--muted)">${e.tienda || ''}</td><td style="font-size:12px;color:var(--muted)">${e.fecha_ingreso || ''}</td></tr>`).join('');
  };

  window.loadAuditoria = async () => {
    const { data } = await apiFetch('/api/auditoria');
    $('aud-table').innerHTML = (data.auditoria || []).map((r) => `<tr><td style="white-space:nowrap;font-size:12px">${r.fecha || r.fecha_hora || ''}</td><td>${badge(r.modulo_afectado || '-','blue')}</td><td>${badge(r.accion,'gray')}</td><td style="font-weight:600">${r.usuario_nombre || r.usuario?.username || '-'}</td><td><code style="font-size:11px">${r.ip_origen || '-'}</code></td><td style="font-size:12px;color:var(--muted)">${r.descripcion || r.descripcion_detalle || '-'}</td></tr>`).join('');
  };

  window.loadReporte = async () => {
    const tipo = $('rep-tipo')?.value || 'ventas';
    const { data } = await apiFetch(`/api/reportes?tipo=${encodeURIComponent(tipo)}`);
    state.reporteData = data.rows || [];
    $('reporte-summary').innerHTML = (data.summary || []).map((s) => `<div class="report-card"><div class="report-card-val" style="color:${s.color}">${s.value}</div><div class="report-card-label">${s.label}</div></div>`).join('');
    $('rep-thead').innerHTML = `<tr>${(data.columns || []).map((c) => `<th>${c}</th>`).join('')}</tr>`;
    $('rep-tbody').innerHTML = (data.rows || []).map((r) => `<tr>${(data.keys || []).map((k) => `<td>${r[k] ?? ''}</td>`).join('')}</tr>`).join('');
    toast('Reporte generado correctamente');
  };

  window.exportCSV = () => {
    if (!state.reporteData.length) return toast('Genera un reporte primero','error');
    const keys = Object.keys(state.reporteData[0]);
    const csv = [keys.join(','), ...state.reporteData.map((r) => keys.map((k) => `"${r[k] ?? ''}"`).join(','))].join('\n');
    const blob = new Blob([csv], { type:'text/csv' });
    const a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = `reporte_mass_${Date.now()}.csv`;
    a.click();
    toast('CSV exportado correctamente');
  };
  window.exportarVentas = () => toast('Exportando ventas desde API');

  window.loadUsuarios = async () => {
    const { data } = await apiFetch('/api/usuarios');
    state.usuarios = data.usuarios || []; state.roles = data.roles || []; state.tiendas = data.tiendas || [];
    $('usr-table').innerHTML = state.usuarios.map((u) => `<tr><td style="font-weight:600">${u.nombres} ${u.apellidos}</td><td><code style="font-size:11px">${u.username}</code></td><td>${badge(u.rol || u.rol_nombre, 'blue')}</td><td style="font-size:12px;color:var(--muted)">${u.tienda || u.tienda_nombre || ''}</td><td>${u.estado === 'activo' ? badge('Activo','green') : badge('Inactivo','red')}</td><td><button class="btn btn-secondary btn-sm" data-edit-usuario="${u.id_usuario}">Editar</button></td></tr>`).join('');
    document.querySelectorAll('[data-edit-usuario]').forEach((btn) => btn.addEventListener('click', () => editUsuario(Number(btn.dataset.editUsuario))));
  };

  function fillUserCombos(u = null) {
    if ($('usr-rol-sel')) $('usr-rol-sel').innerHTML = state.roles.map((r) => `<option value="${r.id_rol}" ${u && (r.nombre === u.rol || r.nombre_rol === u.rol) ? 'selected' : ''}>${r.nombre || r.nombre_rol}</option>`).join('');
    if ($('usr-tienda-sel')) $('usr-tienda-sel').innerHTML = state.tiendas.map((t) => `<option value="${t.id_tienda}" ${u && (t.nombre === u.tienda || t.nombre_tienda === u.tienda) ? 'selected' : ''}>${t.nombre || t.nombre_tienda}</option>`).join('');
  }

  async function editUsuario(id) {
    if (!state.usuarios.length) await loadUsuarios();
    const u = state.usuarios.find((item) => item.id_usuario === id);
    if (!u) return;
    $('modal-usr-title').textContent = 'Editar Usuario'; $('usr-edit-id').value = u.id_usuario; $('usr-nombres').value = u.nombres; $('usr-apellidos').value = u.apellidos; $('usr-username').value = u.username; $('usr-password').value = '';
    fillUserCombos(u); openModal('modal-usuario');
  }
  window.editUsuario = editUsuario;

  function loadPage(page) {
    const loaders = { dashboard:loadDashboard, pos:loadPOS, productos:loadProductos, inventario:loadInventario, ventas:loadVentas, clientes:() => loadClientes(''), proveedores:loadProveedores, empleados:loadEmpleados, reportes:setDefaultDates, auditoria:loadAuditoria, usuarios:loadUsuarios };
    loaders[page]?.();
  }

  function bindEvents() {
    $('btn-login-submit')?.addEventListener('click', login);
    $('login-pass')?.addEventListener('keydown', (e) => { if (e.key === 'Enter') login(); });
    $('btn-logout')?.addEventListener('click', async () => { await apiFetch('/api/logout', { method:'POST' }).catch(() => null); state.currentUser = null; state.cart = []; $('login-screen')?.classList.remove('hidden'); $('app')?.classList.remove('visible'); if ($('app')) $('app').style.display = 'none'; });
    document.querySelectorAll('.nav-item').forEach((item) => item.addEventListener('click', () => { const page = item.dataset.page; document.querySelectorAll('.nav-item').forEach((i) => i.classList.remove('active')); document.querySelectorAll('.page').forEach((p) => p.classList.remove('active')); item.classList.add('active'); $(`page-${page}`)?.classList.add('active'); if ($('page-title')) $('page-title').textContent = pageTitles[page] || page; loadPage(page); }));
    document.querySelectorAll('.modal-overlay').forEach((overlay) => overlay.addEventListener('click', (e) => { if (e.target === overlay) overlay.classList.remove('open'); }));
    document.querySelectorAll('.modal-close').forEach((btn) => btn.addEventListener('click', () => btn.closest('.modal-overlay')?.classList.remove('open')));
    $('prod-search')?.addEventListener('input', filterProductos); $('prod-cat-filter')?.addEventListener('change', filterProductos);
    $('pos-search')?.addEventListener('input', (e) => { const q = e.target.value.toLowerCase(); renderPOSTable(state.productos.filter((p) => p.nombre.toLowerCase().includes(q) || p.codigo.toLowerCase().includes(q))); });
    $('cli-search')?.addEventListener('input', (e) => loadClientes(e.target.value));
    $('btn-nuevo-producto')?.addEventListener('click', async () => { $('modal-prod-title').textContent = 'Nuevo Producto'; $('prod-edit-id').value = ''; ['prod-codigo','prod-nombre','prod-precio','prod-desc'].forEach((id) => { if ($(id)) $(id).value = ''; }); if ($('prod-stock-min')) $('prod-stock-min').value = '5'; await fillProductCombos(); openModal('modal-producto'); });
    $('btn-guardar-producto')?.addEventListener('click', async () => { const body = { id:$('prod-edit-id')?.value, codigo_barras:$('prod-codigo')?.value, descripcion:$('prod-nombre')?.value, precio_venta:$('prod-precio')?.value, stock_minimo:$('prod-stock-min')?.value, id_categoria:$('prod-cat-sel')?.value }; if (!body.codigo_barras || !body.descripcion) return toast('Codigo y nombre son requeridos','error'); await apiFetch('/api/productos', { method:'POST', body }); toast('Producto guardado correctamente'); closeModal('modal-producto'); loadProductos(); });
    $('btn-mov-inventario')?.addEventListener('click', async () => { if (!state.productos.length) await loadProductos(); $('inv-producto-sel').innerHTML = state.productos.map((p) => `<option value="${p.id_producto}">${p.codigo} - ${p.nombre}</option>`).join(''); openModal('modal-inventario'); });
    $('btn-guardar-movimiento')?.addEventListener('click', async () => { await apiFetch('/api/inventario/movimientos', { method:'POST', body:{ id_producto:$('inv-producto-sel')?.value, tipo_movimiento:$('inv-tipo')?.value?.toUpperCase(), cantidad:$('inv-cantidad')?.value, motivo:$('inv-motivo')?.value } }); toast('Movimiento registrado'); closeModal('modal-inventario'); loadInventario(); });
    $('btn-procesar-venta')?.addEventListener('click', async () => { if (!state.cart.length) return toast('El carrito esta vacio','error'); const { data } = await apiFetch('/api/ventas', { method:'POST', body:{ items:state.cart, metodo:$('pos-metodo')?.value, cliente:$('pos-cliente-search')?.value } }); toast(`Venta procesada - Total: ${fmt(data.total || data.total_pagar)}`); state.cart = []; renderCart(); });
    $('btn-clear-cart')?.addEventListener('click', () => { state.cart = []; renderCart(); });
    $('btn-nuevo-cliente')?.addEventListener('click', () => openModal('modal-cliente'));
    $('btn-guardar-cliente')?.addEventListener('click', async () => { await apiFetch('/api/clientes', { method:'POST', body:{ nombres:$('cli-nombres')?.value, apellidos:$('cli-apellidos')?.value, dni:$('cli-dni')?.value, telefono:$('cli-tel')?.value, correo:$('cli-email')?.value, direccion:$('cli-dir')?.value } }); toast('Cliente registrado'); closeModal('modal-cliente'); loadClientes(''); });
    $('btn-nuevo-proveedor')?.addEventListener('click', () => openModal('modal-proveedor'));
    $('btn-guardar-proveedor')?.addEventListener('click', async () => { await apiFetch('/api/proveedores', { method:'POST', body:{ nombre:$('prov-nombre')?.value, ruc:$('prov-ruc')?.value, razon_social:$('prov-razon')?.value, telefono:$('prov-tel')?.value, correo:$('prov-email')?.value, direccion:$('prov-dir')?.value } }); toast('Proveedor registrado'); closeModal('modal-proveedor'); loadProveedores(); });
    $('btn-nuevo-empleado')?.addEventListener('click', async () => { if (!state.tiendas.length) await loadUsuarios(); $('emp-tienda-sel').innerHTML = state.tiendas.map((t) => `<option value="${t.id_tienda}">${t.nombre || t.nombre_tienda}</option>`).join(''); openModal('modal-empleado'); });
    $('btn-guardar-empleado')?.addEventListener('click', async () => { await apiFetch('/api/empleados', { method:'POST', body:{ nombres:$('emp-nombres')?.value, apellidos:$('emp-apellidos')?.value, dni:$('emp-dni')?.value, telefono:$('emp-tel')?.value, cargo:$('emp-cargo')?.value, id_tienda:$('emp-tienda-sel')?.value, fecha_ingreso:$('emp-fecha')?.value } }); toast('Empleado registrado'); closeModal('modal-empleado'); loadEmpleados(); });
    $('btn-nuevo-usuario')?.addEventListener('click', async () => { if (!state.roles.length) await loadUsuarios(); $('modal-usr-title').textContent = 'Nuevo Usuario'; $('usr-edit-id').value = ''; ['usr-nombres','usr-apellidos','usr-username','usr-password'].forEach((id) => { if ($(id)) $(id).value = ''; }); fillUserCombos(); openModal('modal-usuario'); });
    $('btn-guardar-usuario')?.addEventListener('click', async () => { const body = { id:$('usr-edit-id')?.value, nombres:$('usr-nombres')?.value, apellidos:$('usr-apellidos')?.value, username:$('usr-username')?.value, password:$('usr-password')?.value, id_rol:$('usr-rol-sel')?.value, id_tienda:$('usr-tienda-sel')?.value, estado:$('usr-estado')?.value }; if (!body.nombres || !body.username || (!body.id && !body.password)) return toast('Completa los campos requeridos','error'); await apiFetch('/api/usuarios', { method:'POST', body }); toast('Usuario guardado'); closeModal('modal-usuario'); loadUsuarios(); });
  }

  document.addEventListener('DOMContentLoaded', () => { setDefaultDates(); bindEvents(); });
})();