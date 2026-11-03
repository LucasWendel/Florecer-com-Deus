(function () {
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const revealItems = document.querySelectorAll('.reveal');

  if (!reduceMotion && revealItems.length) {
    const observer = new IntersectionObserver(
      (entries, obs) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            obs.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.14, rootMargin: '0px 0px -30px 0px' }
    );

    revealItems.forEach((item) => observer.observe(item));
  } else {
    revealItems.forEach((item) => item.classList.add('is-visible'));
  }

  const statusRoot = document.querySelector('[data-order-status]');

  if (!statusRoot) {
    return;
  }

  const statusUrl = statusRoot.dataset.statusUrl;
  const sessionId = statusRoot.dataset.sessionId;
  const token = statusRoot.dataset.token;
  const maxAttempts = 20;
  let attempts = 0;

  const waitingEl = document.querySelector('[data-waiting]');
  const successEl = document.querySelector('[data-success]');
  const errorEl = document.querySelector('[data-error]');

  const showError = (msg) => {
    if (waitingEl) waitingEl.hidden = true;
    if (successEl) successEl.hidden = true;
    if (errorEl) {
      errorEl.hidden = false;
      errorEl.textContent = msg;
    }
  };

  const showSuccess = () => {
    if (waitingEl) waitingEl.hidden = true;
    if (errorEl) errorEl.hidden = true;
    if (successEl) successEl.hidden = false;
    document.querySelectorAll('[data-waiting-title], [data-waiting-note]').forEach((el) => { el.hidden = true; });
  };

  const poll = async () => {
    attempts += 1;

    try {
      const query = new URLSearchParams({ token }).toString();
      const response = await fetch(`${statusUrl}?${query}`, {
        headers: {
          Accept: 'application/json',
        },
      });

      const data = await response.json();

      if (!response.ok) {
        throw new Error(data.message || 'Pedido não encontrado.');
      }

      if (data.paid) {
        showSuccess();
        return;
      }

      if (attempts >= maxAttempts) {
        showError('Ainda não recebemos a confirmação do pagamento. Atualize esta página em alguns instantes.');
        return;
      }

      window.setTimeout(poll, 3000);
    } catch (error) {
      if (attempts >= maxAttempts) {
        showError(error.message || 'Não foi possível verificar o status agora.');
        return;
      }
      window.setTimeout(poll, 3000);
    }
  };

  if (!token || !statusUrl) {
    showError('Parâmetros de confirmação inválidos. Confira o link recebido após o checkout.');
    return;
  }

  poll();
})();

/* ── FAQ accordion ─────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.faq-trigger').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var item = btn.closest('.faq-item');
      var isOpen = item.classList.contains('open');
      // fecha todos
      document.querySelectorAll('.faq-item.open').forEach(function (el) {
        el.classList.remove('open');
        el.querySelector('.faq-trigger').setAttribute('aria-expanded', 'false');
      });
      // abre o clicado se estava fechado
      if (!isOpen) {
        item.classList.add('open');
        btn.setAttribute('aria-expanded', 'true');
      }
    });
  });
});

/* Menu da home: abre/fecha no celular */
(function () {
  var nav = document.querySelector('[data-site-nav]');
  if (!nav) return;
  var btn = nav.querySelector('[data-nav-toggle]');
  var menu = nav.querySelector('[data-nav-menu]');
  function close() { nav.classList.remove('is-open'); btn.setAttribute('aria-expanded', 'false'); }
  btn.addEventListener('click', function () {
    var open = nav.classList.toggle('is-open');
    btn.setAttribute('aria-expanded', open ? 'true' : 'false');
  });
  menu.querySelectorAll('a').forEach(function (a) { a.addEventListener('click', close); });
  document.addEventListener('click', function (e) { if (!nav.contains(e.target)) close(); });
  document.addEventListener('keydown', function (e) { if (e.key === 'Escape') close(); });
  window.addEventListener('resize', function () { if (window.innerWidth > 960) close(); });
})();

/* Submenu Login (clique no celular e no PC) */
(function () {
  document.querySelectorAll('[data-dropdown]').forEach(function (dd) {
    var btn = dd.querySelector('[data-dropdown-toggle]');
    btn.addEventListener('click', function (e) {
      e.stopPropagation();
      var open = dd.classList.toggle('is-open');
      btn.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
    document.addEventListener('click', function (e) {
      if (!dd.contains(e.target)) { dd.classList.remove('is-open'); btn.setAttribute('aria-expanded', 'false'); }
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') { dd.classList.remove('is-open'); btn.setAttribute('aria-expanded', 'false'); }
    });
  });
})();
