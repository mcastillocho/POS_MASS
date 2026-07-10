window.loadProductos = async () => {
  const { data } = await apiFetch('productos');
  AppState.productos = data.productos;
  $('prod-cat-filter').innerHTML = '<option value="">Todas las categorias</option>' + data.categorias.map(c => `<option>${c.nombre}</option>`).join('');
  renderProductosTable(AppState.productos);
  $('prod-search')?.addEventListener('input', filterProductos, { once: true });
  $('prod-cat-filter')?.addEventListener('change', filterProductos, { once: true });
};
function filterProductos() {
  const q = $('prod-search').value.toLowerCase(); const cat = $('prod-cat-filter').value;
  renderProductosTable(AppState.productos.filter(p => (p.nombre.toLowerCase().includes(q) || p.codigo.toLowerCase().includes(q)) && (!cat || p.categoria === cat)));
}
function renderProductosTable(prods) {
  $('prod-table').innerHTML = prods.map(p => `<tr><td><code style="font-size:11px;background:var(--bg3);padding:3px 7px;border-radius:4px">${p.codigo}</code></td><td style="font-weight:600">${p.nombre}</td><td>${badge(p.categoria,'blue')}</td><td style="font-weight:700">${fmt(p.precio)}</td><td>${p.stock_actual}</td><td>${p.stock_actual <= 5 ? badge('Critico','red') : p.stock_actual <= 10 ? badge('Bajo','yellow') : badge('Normal','green')}</td><td><div style="display:flex;gap:6px"><button class="btn btn-secondary btn-sm" onclick="editProducto(${p.id_producto})">Editar</button><button class="btn btn-danger btn-sm" onclick="toast('Producto desactivado')">x</button></div></td></tr>`).join('') || '<tr><td colspan="7" style="text-align:center;color:var(--muted);padding:20px">Sin resultados</td></tr>';
}
async function fillProductCombos() { const { data } = await apiFetch('catalogos'); $('prod-cat-sel').innerHTML = data.categorias.map(c => `<option value="${c.id_categoria}">${c.nombre}</option>`).join(''); $('prod-prov-sel').innerHTML = '<option value="">Sin asignar</option>' + data.proveedores.map(p => `<option value="${p.id_proveedor}">${p.nombre}</option>`).join(''); }
window.editProducto = async (id) => { const p = AppState.productos.find(x => x.id_producto === id); if (!p) return; await fillProductCombos(); $('modal-prod-title').textContent = 'Editar Producto'; $('prod-edit-id').value = id; $('prod-codigo').value = p.codigo; $('prod-nombre').value = p.nombre; $('prod-precio').value = p.precio; openModal('modal-producto'); };
window.loadInventario = async () => { const { data } = await apiFetch('inventario'); $('inv-alertas-wrap').innerHTML = `<div class="stock-alert">! <div><div class="stock-alert-name">${data.criticos} productos con stock critico detectados</div><div class="stock-alert-detail">Revisar y reponer urgente</div></div></div>`; $('inv-table').innerHTML = data.productos.map(p => `<tr><td><code style="font-size:11px;background:var(--bg3);padding:3px 7px;border-radius:4px">${p.codigo}</code></td><td style="font-weight:600">${p.nombre}</td><td>${badge(p.categoria,'blue')}</td><td style="font-weight:700;font-size:15px">${p.stock_actual}</td><td style="color:var(--muted)">${p.stock_minimo}</td><td>${stockBadge(p.estado)}</td></tr>`).join(''); };
document.addEventListener('DOMContentLoaded', () => {
  $('btn-nuevo-producto')?.addEventListener('click', async () => { $('modal-prod-title').textContent = 'Nuevo Producto'; $('prod-edit-id').value = ''; ['prod-codigo','prod-nombre','prod-precio','prod-desc'].forEach(id => $(id).value = ''); $('prod-stock-min').value = '5'; await fillProductCombos(); openModal('modal-producto'); });
  $('btn-guardar-producto')?.addEventListener('click', async () => { const body = { id:$('prod-edit-id').value, codigo:$('prod-codigo').value, nombre:$('prod-nombre').value, precio:$('prod-precio').value, stock_minimo:$('prod-stock-min').value, descripcion:$('prod-desc').value }; if (!body.codigo || !body.nombre) return toast('Codigo y nombre son requeridos','error'); await apiFetch('productos', { method:'POST', body }); toast(`Producto "${body.nombre}" guardado correctamente`); closeModal('modal-producto'); loadProductos(); });
  $('btn-mov-inventario')?.addEventListener('click', async () => { const { data } = await apiFetch('productos'); $('inv-producto-sel').innerHTML = data.productos.map(p => `<option value="${p.id_producto}">${p.codigo} - ${p.nombre}</option>`).join(''); openModal('modal-inventario'); });
  $('btn-guardar-movimiento')?.addEventListener('click', async () => { await apiFetch('inventario/movimientos', { method:'POST', body:{ producto:$('inv-producto-sel').value, tipo:$('inv-tipo').value, cantidad:$('inv-cantidad').value, motivo:$('inv-motivo').value } }); toast('Movimiento registrado'); closeModal('modal-inventario'); loadInventario(); });
});
