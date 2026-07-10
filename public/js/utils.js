window.$ = (id) => document.getElementById(id);
window.fmt = (n) => 'S/ ' + parseFloat(n || 0).toFixed(2);
window.apiFetch = async (path, options = {}) => {
  const fetchOptions = { method: options.method || 'GET', headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' } };
  if (options.body) fetchOptions.body = JSON.stringify(options.body);
  const response = await fetch(`/api/${path}`, fetchOptions);
  const data = await response.json();
  if (!response.ok || data.ok === false) throw new Error(data.message || 'Error de comunicacion con la API');
  return data;
};
window.toast = (msg, type = 'success') => {
  const t = $('toast');
  if (!t) return;
  t.textContent = (type === 'success' ? 'OK ' : 'ERROR ') + msg;
  t.className = `toast ${type} show`;
  setTimeout(() => t.classList.remove('show'), 3500);
};
window.openModal = (id) => $(id)?.classList.add('open');
window.closeModal = (id) => $(id)?.classList.remove('open');
window.badge = (txt, color) => `<span class="badge badge-${color}">${txt}</span>`;
window.stockBadge = (estado) => {
  const map = { NORMAL: ['green','Normal'], BAJO: ['yellow','Stock Bajo'], CRITICO: ['red','Critico'] };
  const [c, l] = map[estado] || ['gray', estado];
  return badge(l, c);
};
