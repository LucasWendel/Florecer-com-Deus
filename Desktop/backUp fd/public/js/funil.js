/* Florescer com Deus — controle do funil de 3 etapas (sem reload, JS puro). */
(function () {
  'use strict';

  var root = document.querySelector('[data-funnel]');
  if (!root) return;

  var steps = root.querySelectorAll('[data-step]');
  var progressItems = root.querySelectorAll('[data-progress-step]');
  var fill = root.querySelector('[data-progress-fill]');
  var checkbox = root.querySelector('[data-terms-checkbox]');
  var nextFromTerms = root.querySelector('[data-terms-next]');
  var total = steps.length;
  var current = parseInt(root.getAttribute('data-start-step'), 10) || 1;

  function termsAccepted() {
    return !checkbox || checkbox.checked;
  }

  function show(step, initial) {
    // Não deixa avançar além da etapa 1 sem aceitar os termos.
    if (step > 1 && !termsAccepted()) step = 1;
    current = step;

    steps.forEach(function (el) {
      el.hidden = parseInt(el.getAttribute('data-step'), 10) !== step;
    });

    progressItems.forEach(function (li) {
      var n = parseInt(li.getAttribute('data-progress-step'), 10);
      li.classList.toggle('is-active', n === step);
      li.classList.toggle('is-done', n < step);
    });

    if (fill) fill.style.width = ((step - 1) / (total - 1)) * 100 + '%';

    if (initial) return;

    var top = root.getBoundingClientRect().top + window.pageYOffset - 10;
    window.scrollTo({ top: top < 0 ? 0 : top, behavior: 'smooth' });

    if (step === 3) {
      var firstInput = root.querySelector('[data-step="3"] .form-input--error, [data-step="3"] input[type="text"]');
      if (firstInput) window.setTimeout(function () { firstInput.focus({ preventScroll: true }); }, 350);
    }
  }

  if (checkbox && nextFromTerms) {
    var sync = function () { nextFromTerms.disabled = !checkbox.checked; };
    checkbox.addEventListener('change', sync);
    sync();
  }

  root.addEventListener('click', function (event) {
    var btn = event.target.closest('[data-go]');
    if (!btn || btn.disabled) return;
    show(parseInt(btn.getAttribute('data-go'), 10));
  });

  show(current, current === 1);
})();
