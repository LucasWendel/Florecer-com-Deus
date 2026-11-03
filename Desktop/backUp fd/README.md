# Florescer com Deus (Laravel + Stripe + WhatsApp)

Landing page gospel cristã para mulheres, com foco em **força, fé e propósito**, construída em **PHP + Laravel** (sem Node.js), com:

- Página institucional responsiva (mobile-first).
- Animações de entrada ao rolar a página (IntersectionObserver).
- Fluxo de pagamento via Stripe Checkout (R$ 35,00).
- Webhook Stripe para confirmação segura de pagamento.
- Liberação automática do link privado do WhatsApp **somente após status pago**.
- Modo mock para testar tudo localmente sem credenciais reais.

## 1) Requisitos

- PHP >= 8.2 (compatível com este projeto Laravel).
- Composer.
- Extensões PHP: `curl`, `mbstring`, `xml`, `bcmath`, `zip`, `sqlite3`.

> Este projeto foi preparado para rodar **sem npm, sem Vite, sem Mix e sem Node.js**.

## 2) Estrutura principal

- `resources/views/florescer/home.blade.php` → landing page.
- `resources/views/florescer/confirmacao.blade.php` → página de confirmação pós-checkout.
- `public/css/florescer.css` → estilos (paleta e tipografia do template original).
- `public/js/florescer.js` → animações de scroll + polling de status do pedido.
- `app/Http/Controllers/FlorescerController.php` → checkout, confirmação, status e webhook.
- `app/Models/Order.php` + migration `orders`.

## 3) Configuração local rápida

```bash
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan serve --host=127.0.0.1 --port=8000
```

Abrir: `http://127.0.0.1:8000`

## 4) Fluxo Stripe implementado

### Checkout
- Botão **Quero fazer parte** envia `POST /checkout`.
- Cria sessão Stripe em `mode=payment`, moeda `brl`, valor `3500` centavos.
- `success_url` retorna para `/confirmacao?session_id={CHECKOUT_SESSION_ID}&token=...`.
- `cancel_url` volta para a seção de participação na landing.

### Confirmação segura
- `/confirmacao` não mostra o link direto.
- O JavaScript consulta `GET /status-do-pedido?session_id=...&token=...`.
- O servidor só retorna `whatsapp_link` quando o pedido está `paid`.
- Até o webhook chegar, a página faz polling leve (até ~60s).

### Webhook
- Endpoint: `POST /stripe/webhook`.
- Verifica assinatura com `STRIPE_WEBHOOK_SECRET`.
- No evento `checkout.session.completed`, marca pedido como `paid`.
- Registra log simples em `storage/logs/laravel.log`.

## 5) Modo MOCK (teste sem Stripe real)

Quando `APP_ENV=local` e `STRIPE_MOCK=true` (ou sem chave Stripe válida):

- `POST /checkout` cria pedido mock e redireciona para confirmação.
- Em ~2 segundos o status muda para `paid` automaticamente.
- O botão do grupo WhatsApp aparece, simulando o fluxo completo.

## 6) Variáveis importantes no `.env`

- `APP_URL`
- `STRIPE_SECRET_KEY`
- `STRIPE_PUBLISHABLE_KEY`
- `STRIPE_WEBHOOK_SECRET`
- `STRIPE_MOCK`
- `WHATSAPP_GROUP_LINK`

## 7) Banco de dados

Padrão local: SQLite (`database/database.sqlite`) com migration `orders`:

- `checkout_session_id` (único)
- `customer_email` (nullable)
- `amount`
- `currency`
- `status` (`pending` / `paid`)
- `access_token` (único)
- timestamps

Para produção em MySQL, ajustar `DB_*` no `.env` e rodar `php artisan migrate`.

## 8) Teste rápido do fluxo

1. Abra a home e clique em **Quero fazer parte**.
2. No modo mock, você será redirecionada para `/confirmacao`.
3. Aguarde alguns segundos: o botão de entrada no grupo aparece automaticamente.

---

## Observação de segurança

A liberação do link do WhatsApp acontece no servidor, condicionada ao status pago do pedido. O front-end apenas consulta status autenticado por `session_id + token`.
