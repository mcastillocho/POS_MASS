document.addEventListener('DOMContentLoaded', () => {
  $('btn-login-submit')?.addEventListener('click', login);
  $('login-pass')?.addEventListener('keydown', e => { if (e.key === 'Enter') login(); });
});
async function login() {
  const username = $('login-user').value.trim();
  const password = $('login-pass').value;
  if (!username || !password) return showLoginError('Completa todos los campos');
  try {
    const { user } = await apiFetch('login', { method: 'POST', body: { username, password } });
    AppState.currentUser = user;
    initApp();
  } catch (error) { showLoginError(error.message); }
}
function showLoginError(msg) {
  const el = $('login-error');
  el.textContent = msg;
  el.style.display = 'block';
}
