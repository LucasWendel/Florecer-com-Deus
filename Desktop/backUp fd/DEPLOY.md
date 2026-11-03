# DEPLOY.md — Guia de publicação (pt-BR)

Este guia mostra como publicar o projeto **Florescer com Deus** em hospedagem compartilhada/cPanel e conectar com Stripe real.

## 1) Requisitos de hospedagem

- PHP >= 8.2
- Composer disponível (SSH) ou suporte a `composer install` pela hospedagem
- Extensões PHP: `curl`, `mbstring`, `xml`, `bcmath`, `zip`, `sqlite3` (ou `pdo_mysql` para MySQL)
- SSL ativo no domínio (HTTPS)

## 2) Upload do projeto

1. Compacte o projeto em `.zip` (sem pasta `vendor` se quiser reduzir upload).
2. Envie para sua hospedagem (Gerenciador de Arquivos ou Git).
3. Extraia em uma pasta fora do `public_html`, por exemplo:
   - `/home/SEU_USUARIO/florescer_com_deus`

## 3) Instalação de dependências

No terminal SSH da hospedagem (dentro da pasta do projeto):

```bash
composer install --no-dev --optimize-autoloader
```

## 4) Configuração do `.env`

1. Copie `.env.example` para `.env`.
2. Defina `APP_ENV=production`, `APP_DEBUG=false`.
3. Defina `APP_URL=https://SEU-DOMINIO.com`.
4. Configure banco de dados (MySQL, na maioria dos cPanel):

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=seu_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

5. Configure Stripe e WhatsApp:

```env
STRIPE_SECRET_KEY=sk_live_...
STRIPE_PUBLISHABLE_KEY=pk_live_...
STRIPE_WEBHOOK_SECRET=whsec_...
STRIPE_MOCK=false
WHATSAPP_GROUP_LINK=https://chat.whatsapp.com/SEU_LINK_PRIVADO_REAL
```

## 5) Chave da aplicação, migrações e cache

```bash
php artisan key:generate
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 6) Permissões importantes

Garanta permissão de escrita em:

- `storage/`
- `bootstrap/cache/`

Em muitos ambientes Linux:

```bash
chmod -R 775 storage bootstrap/cache
```

## 7) Document Root (essencial no cPanel)

O domínio/subdomínio deve apontar para:

- `.../florescer_com_deus/public`

> **Não** aponte para a raiz do projeto, sempre para a pasta `public/`.

## 8) Configuração Stripe (produção)

1. Acesse [https://dashboard.stripe.com](https://dashboard.stripe.com).
2. Em **Developers > API keys**, copie:
   - `Secret key` → `STRIPE_SECRET_KEY`
   - `Publishable key` → `STRIPE_PUBLISHABLE_KEY`
3. Em **Developers > Webhooks**, crie endpoint:
   - URL: `https://SEU-DOMINIO.com/stripe/webhook`
   - Evento: `checkout.session.completed`
4. Copie o segredo `whsec_...` do webhook para `STRIPE_WEBHOOK_SECRET`.
5. Confirme `STRIPE_MOCK=false` em produção.

## 9) Dicas para o link do grupo privado do WhatsApp

- O link de convite pode expirar ou ser revogado.
- Se parar de funcionar, gere um novo convite no admin do grupo.
- Atualize `WHATSAPP_GROUP_LINK` no `.env` com o novo link.
- Se possível, ajuste permissões do grupo para manter o convite válido por mais tempo.

## 10) Como testar antes de abrir ao público

### A) Teste local em modo mock
- `STRIPE_MOCK=true`
- Fluxo libera link em segundos sem chave Stripe real.

### B) Teste real com Stripe
1. Use chaves de teste (`sk_test`, `pk_test`).
2. Configure webhook de teste com `checkout.session.completed`.
3. Faça uma compra teste no checkout.
4. Confira se o pedido muda para `paid` e se o link do WhatsApp é liberado.

## 11) Checklist final de publicação

- [ ] Home abrindo com layout correto no mobile.
- [ ] Botão **Quero fazer parte** abrindo checkout.
- [ ] Webhook recebendo evento `checkout.session.completed`.
- [ ] Página `/confirmacao` liberando WhatsApp somente quando `paid`.
- [ ] `APP_DEBUG=false` em produção.
- [ ] `STRIPE_MOCK=false` em produção.
