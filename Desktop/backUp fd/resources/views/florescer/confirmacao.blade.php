<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Confirmação de pagamento | Florescer com Deus</title>
    <meta name="description" content="Confirmação da sua inscrição no Florescer com Deus.">
    <link rel="stylesheet" href="{{ asset('css/florescer.css') }}">
</head>
<body>
<header class="topbar">
    <a class="brand brand--link" href="{{ url('/') }}">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Florescer com Deus" class="brand-logo">
        Florescer com Deus
    </a>
</header>

<main class="section section--center">
    <div class="container--narrow">
        <div class="pricing reveal" data-order-status data-status-url="{{ $statusUrl }}" data-session-id="{{ $sessionId }}" data-token="{{ $token }}">
            <p class="eyebrow">Confirmação da inscrição</p>
            <p class="confirm-waiting-title" data-waiting-title>Estamos verificando seu pagamento…</p>

            <div data-waiting>
                <p>Assim que o pagamento for confirmado, esta página mostrará automaticamente o seu próximo passo.</p>
                <p class="helper">Essa verificação leva poucos segundos. Não feche esta página.</p>
            </div>

            <div data-success hidden class="confirm-success">
                <div class="confirm-success__icon">🌷</div>
                <p><span class="payment-confirmed-box">Pagamento realizado com sucesso! 🙌</span></p>
                <h1 class="confirm-success__title">Parabéns pela sua iniciativa!</h1>
                <p>Hoje você disse <strong>sim</strong> a algo muito maior do que um livro. Você decidiu transformar a sua história com Deus em esperança para outras mulheres, e isso é lindo.</p>
                <p>A partir de agora você é oficialmente <strong>coautora do Florescer com Deus</strong>. Em algum lugar do mundo, uma mulher vai abrir este livro no dia do seu aniversário e encontrar, nas suas palavras, a força de que precisava para continuar.</p>
                <p class="confirm-success__verse"><em>"Contarei o que Ele tem feito por minha alma." Salmos 66:16</em></p>

                <div class="confirm-next">
                    <p class="eyebrow" style="margin-bottom:6px;">Próximo passo</p>
                    <p>Faça o seu <strong>primeiro login</strong> com o e-mail que você usou no pagamento e crie a sua senha. Na sua área de coautora você terá acesso a tudo para participar: o grupo exclusivo, o Guia de Escrita para Coautoras e o formulário para enviar o seu testemunho.</p>
                    <a class="button button--lg" href="{{ route('assinante.login') }}">Fazer meu primeiro login →</a>
                </div>
            </div>

            <p class="alert alert-error" data-error hidden></p>
        </div>
    </div>
</main>

<footer class="footer">
    <span data-waiting-note>Se você já pagou e ainda está aguardando, mantenha esta página aberta por até 1 minuto.</span>
</footer>

<script src="{{ asset('js/florescer.js') }}"></script>
</body>
</html>
