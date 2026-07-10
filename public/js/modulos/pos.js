window.loadPOS = async () => {
  const { data } = await apiFetch('productos');
  AppState.productos = data.productos;
  renderPOSTable(AppState.productos);
  $('pos-search')?.addEventListener('input', e => {
    const q = e.target.value.toLowerCase();
    renderPOSTable(AppState.productos.filter(p => p.nombre.toLowerCase().includes(q) || p.codigo.toLowerCase().includes(q)));
  }, { once: true });
};
function renderPOSTable(prods) {
  $('pos-table').innerHTML = prods.map(p => `<tr><td><code style="font-size:11px;background:var(--bg3);padding:3px 7px;border-radius:4px">${p.codigo}</code></td><td style="font-weight:600">${p.nombre}</td><td>${badge(p.categoria,'blue')}</td><td style="color:var(--green);font-weight:700">${fmt(p.precio)}</td><td>${p.stock_actual < 10 ? badge(p.stock_actual,'red') : badge(p.stock_actual,'green')}</td><td><button class="btn btn-primary btn-sm" data-add-cart="${p.id_producto}">+ Agregar</button></td></tr>`).join('') || '<tr><td colspan="6" style="text-align:center;color:var(--muted);padding:20px">Sin resultados</td></tr>';
  document.querySelectorAll('[data-add-cart]').forEach(btn => btn.addEventListener('click', () => addToCart(Number(btn.dataset.addCart))));
}
window.addToCart = (id) => {
  const prod = AppState.productos.find(p => p.id_producto === id);
  const existing = AppState.cart.find(c => c.id_producto === id);
  existing ? existing.cantidad++ : AppState.cart.push({ ...prod, cantidad: 1 });
  renderCart(); toast(`${prod.nombre} agregado`);
};
window.removeFromCart = (id) => { AppState.cart = AppState.cart.filter(c => c.id_producto !== id); renderCart(); };
window.changeQty = (id, delta) => { const item = AppState.cart.find(c => c.id_producto === id); if (item) { item.cantidad = Math.max(1, item.cantidad + delta); renderCart(); } };
function renderCart() {
  if (!AppState.cart.length) { $('cart-items').innerHTML = '<div class="empty-state" style="padding:30px 0"><div style="font-size:12px;color:var(--muted)">Agrega productos al carrito</div></div>'; $('cart-sub').textContent = fmt(0); $('cart-igv').textContent = fmt(0); $('cart-total').textContent = fmt(0); return; }
  $('cart-items').innerHTML = AppState.cart.map(c => `<div class="cart-item"><div class="cart-item-info"><div class="cart-item-name">${c.nombre}</div><div class="cart-item-price">${fmt(c.precio)} c/u</div></div><div class="cart-qty"><button class="qty-btn" onclick="changeQty(${c.id_producto},-1)">-</button><span style="font-weight:700;min-width:20px;text-align:center">${c.cantidad}</span><button class="qty-btn" onclick="changeQty(${c.id_producto},1)">+</button></div><div class="cart-item-subtotal">${fmt(c.precio * c.cantidad)}</div><button class="btn btn-danger btn-icon btn-sm" onclick="removeFromCart(${c.id_producto})">x</button></div>`).join('');
  const sub = AppState.cart.reduce((s, c) => s + c.precio * c.cantidad, 0), igv = sub * 0.18;
  $('cart-sub').textContent = fmt(sub); $('cart-igv').textContent = fmt(igv); $('cart-total').textContent = fmt(sub + igv);
}
document.addEventListener('DOMContentLoaded', () => {
  $('btn-procesar-venta')?.addEventListener('click', async () => {
    if (!AppState.cart.length) return toast('El carrito esta vacio', 'error');
    const { data } = await apiFetch('ventas', { method: 'POST', body: { items: AppState.cart, metodo: $('payment-method').value, cliente: $('cliente-doc').value } });
    toast(`Venta procesada - Total: ${fmt(data.total)}`); AppState.cart = []; renderCart();
  });
  $('btn-clear-cart')?.addEventListener('click', () => { AppState.cart = []; renderCart(); });
});
