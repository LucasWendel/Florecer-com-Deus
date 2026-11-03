<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Exception\UnexpectedValueException;
use Stripe\StripeClient;
use Stripe\Webhook;

class FlorescerController extends Controller
{
    public function home(): View
    {
        return view('florescer.home', [
            'valor' => 10.00,
            'whatsappConfigured' => ! blank(config('services.whatsapp.group_link')),
        ]);
    }

    public function sobre(): View
    {
        return view('florescer.sobre');
    }

    public function funil(): View
    {
        // Valor único da inscrição: €10. O Stripe (Adaptive Pricing) converte
        // automaticamente para a moeda local de quem paga no checkout.
        [$currency, $valor, $simbolo] = ['eur', 10.00, '€'];

        return view('florescer.funil', [
            'valor'   => $valor,
            'currency' => $currency,
            'simbolo' => $simbolo,
        ]);
    }

    public function checkout(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name'     => ['required', 'string', 'max:255'],
            'customer_whatsapp' => ['required', 'string', 'max:30'],
            'country_code'      => ['nullable', 'string', 'regex:/^\+\d{1,4}$/'],
            'customer_email'    => ['required', 'email:rfc,dns', 'max:255'],
            'currency'          => ['nullable', 'string', 'in:brl,usd,eur'],
        ], [
            'customer_name.required'     => 'Por favor, informe seu nome completo.',
            'customer_whatsapp.required' => 'Por favor, informe seu WhatsApp com DDD.',
            'customer_email.required'    => 'Por favor, informe seu e-mail.',
            'customer_email.email'       => 'Informe um e-mail válido.',
        ]);

        $name      = $validated['customer_name'];
        $whatsapp  = trim($validated['customer_whatsapp']);
        // Junta o código do país escolhido ao número (se a pessoa já não digitou com +)
        $countryCode = $validated['country_code'] ?? '';
        if ($countryCode !== '' && ! str_starts_with($whatsapp, '+')) {
            $whatsapp = $countryCode . ' ' . $whatsapp;
        }
        $email     = $validated['customer_email'];
        // Inscrição: €10,00 (em centavos). A conversão para a moeda local
        // é feita pelo próprio Stripe no checkout (Adaptive Pricing).
        $currency   = 'eur';
        $unitAmount = 1000;
        $accessToken = Str::random(50);

        if ($this->isMockMode()) {
            $sessionId = 'mock_session_' . Str::lower(Str::random(20));

            Order::create([
                'checkout_session_id' => $sessionId,
                'customer_name'       => $name,
                'customer_whatsapp'   => $whatsapp,
                'customer_email'      => $email,
                'amount'              => $unitAmount,
                'currency'            => $currency,
                'status'              => 'pending',
                'access_token'        => $accessToken,
            ]);

            return redirect()->route('confirmacao', [
                'session_id' => $sessionId,
                'token' => $accessToken,
                'mock' => 1,
            ]);
        }

        $stripeSecret = config('services.stripe.secret_key');

        if (blank($stripeSecret)) {
            return back()->withErrors([
                'checkout' => 'Não foi possível iniciar o checkout. Configure a chave STRIPE_SECRET_KEY no arquivo .env.',
            ]);
        }

        $stripe = new StripeClient($stripeSecret);

        $successUrl = route('confirmacao') . '?token=' . $accessToken;
        $cancelUrl = url('/#participar');

        $payload = [
            'mode' => 'payment',
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
            'customer_email' => $email,
            // Mostra e cobra na moeda local da pessoa (conversão feita pelo Stripe)
            'adaptive_pricing' => ['enabled' => true],
            'line_items' => [[
                'quantity' => 1,
                'price_data' => [
                    'currency' => $currency,
                    'unit_amount' => $unitAmount,
                    'product_data' => [
                        'name' => 'Participação no Florescer com Deus',
                        'description' => 'Inscrição para participar do projeto missionário Florescer com Deus.',
                    ],
                ],
            ]],
            'metadata' => [
                'project'            => 'florescer_com_deus',
                'customer_name'      => $name,
                'customer_whatsapp'  => $whatsapp,
            ],
        ];

        try {
            $session = $stripe->checkout->sessions->create($payload);
        } catch (\Throwable $exception) {
            Log::error('Falha ao criar sessão de checkout no Stripe.', ['message' => $exception->getMessage()]);

            return back()->withInput()->withErrors([
                'checkout' => 'Não foi possível iniciar o pagamento agora. Detalhe: ' . $exception->getMessage(),
            ]);
        }

        try {
            Order::create([
            'checkout_session_id' => $session->id,
            'customer_name'       => $name,
            'customer_whatsapp'   => $whatsapp,
            'customer_email'      => $email,
            'amount'              => $unitAmount,
            'currency'            => $currency,
            'status'              => 'pending',
            'access_token'        => $accessToken,
            ]);
        } catch (\Throwable $exception) {
            Log::error('Falha ao salvar o pedido no banco.', ['message' => $exception->getMessage()]);

            return back()->withInput()->withErrors([
                'checkout' => 'Não foi possível registrar sua inscrição. Verifique se o banco foi atualizado (colunas customer_name e customer_whatsapp).',
            ]);
        }

        return redirect()->away($session->url);
    }

    public function confirmacao(Request $request): View
    {
        $token = (string) $request->query('token', '');
        $order = $token !== '' ? Order::where('access_token', $token)->first() : null;

        if ($order) {
            $this->syncOrderWithStripe($order);
        }

        return view('florescer.confirmacao', [
            // O session_id não vem mais na URL (ModSecurity bloqueava); usamos o do pedido salvo.
            'sessionId' => $order?->checkout_session_id,
            'token' => $order ? $token : null,
            'statusUrl' => route('status.pedido'),
        ]);
    }

    public function statusPedido(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'session_id' => ['nullable', 'string', 'max:255'],
            'token' => ['required', 'string', 'max:255'],
        ]);

        $order = Order::where('access_token', $validated['token'])->first();

        if (! $order) {
            return response()->json([
                'status' => 'not_found',
                'paid' => false,
                'message' => 'Pedido não encontrado ou token inválido.',
            ], 404);
        }

        $this->syncOrderWithStripe($order);

        if ($this->isMockMode() && $order->status !== 'paid') {
            $createdAt = $order->created_at;

            if ($createdAt && $createdAt->lte(now()->subSeconds(2))) {
                $order->status = 'paid';
                $order->save();
            }
        }

        $paid = $order->status === 'paid';

        return response()->json([
            'status' => $order->status,
            'paid' => $paid,
            'whatsapp_link' => $paid ? config('services.whatsapp.group_link') : null,
            'message' => $paid ? 'Pagamento confirmado com sucesso.' : 'Aguardando confirmação do pagamento.',
        ]);
    }

    public function stripeWebhook(Request $request): JsonResponse
    {
        $payload = $request->getContent();
        $signature = $request->header('Stripe-Signature');
        $webhookSecret = config('services.stripe.webhook_secret');

        if (blank($webhookSecret) || $this->isMockMode()) {
            Log::info('Webhook Stripe ignorado (modo mock ou segredo ausente).');

            return response()->json(['received' => true, 'mode' => 'mock_or_no_secret']);
        }

        try {
            $event = Webhook::constructEvent($payload, (string) $signature, $webhookSecret);
        } catch (UnexpectedValueException|SignatureVerificationException $exception) {
            Log::warning('Assinatura inválida no webhook Stripe.', [
                'message' => $exception->getMessage(),
            ]);

            return response()->json(['error' => 'Assinatura inválida'], 400);
        }

        if ($event->type !== 'checkout.session.completed') {
            return response()->json(['received' => true]);
        }

        $session = $event->data->object;
        $sessionId = $session->id ?? null;

        if ($sessionId) {
            $order = Order::where('checkout_session_id', $sessionId)->first();

            if ($order && $order->status !== 'paid') {
                $order->status = 'paid';
                $order->save();

                Log::info('Pagamento confirmado via webhook Stripe.', [
                    'session_id' => $sessionId,
                    'order_id' => $order->id,
                ]);
            }
        }

        return response()->json(['received' => true]);
    }

    /**
     * Consulta o Stripe direto pelo servidor e marca o pedido como pago,
     * sem depender só do webhook.
     */
    private function syncOrderWithStripe(Order $order): void
    {
        if ($order->status === 'paid' || $this->isMockMode()) {
            return;
        }

        $secret = config('services.stripe.secret_key');
        if (blank($secret) || ! Str::startsWith((string) $order->checkout_session_id, 'cs_')) {
            return;
        }

        try {
            $session = (new StripeClient($secret))->checkout->sessions->retrieve($order->checkout_session_id);

            if (($session->payment_status ?? null) === 'paid') {
                $order->status = 'paid';
                $order->save();
                Log::info('Pagamento confirmado via consulta ao Stripe.', ['order_id' => $order->id]);
            }
        } catch (\Throwable $e) {
            Log::warning('Falha ao consultar sessão no Stripe.', ['message' => $e->getMessage()]);
        }
    }

    private function isMockMode(): bool
    {
        $mockEnabled = filter_var(env('STRIPE_MOCK', false), FILTER_VALIDATE_BOOL);
        $secret = (string) config('services.stripe.secret_key');

        $secretLooksPlaceholder = blank($secret)
            || Str::contains(Str::lower($secret), ['placeholder', 'sua_chave', 'your_key']);

        return (app()->environment('local') && $mockEnabled) || $secretLooksPlaceholder;
    }
}
