<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Entrar · Florescer com Deus</title>
<link rel="stylesheet" href="{{ asset('css/florescer.css') }}">
</head>
<body class="auth-page">

<header class="topbar">
    <a class="brand brand--link" href="{{ url('/') }}">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="brand-logo">
        Florescer com Deus
    </a>
</header>

<main class="auth-wrap">
    <div class="auth-card">
        <div class="auth-icon">🔒</div>
        <h1 class="auth-title">Bem-vinda de volta!</h1>
        <p class="auth-sub">{{ $email }}</p>

        @if($errors->any())
            <div class="auth-alert">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('assinante.login-password') }}" class="auth-form">
            @csrf
            <label class="auth-label" for="password">Senha</label>
            <input class="auth-input" type="password" id="password" name="password"
                   placeholder="Sua senha" required autocomplete="current-password" autofocus>
            <button class="button button--full" type="submit">Entrar</button>
        </form>
        <p class="auth-back"><a class="auth-back__link" href="{{ url('/') }}">← Voltar ao site</a></p>

        <p class="auth-foot">
            <a href="{{ route('assinante.login') }}">← Usar outro e-mail</a>
            &nbsp;·&nbsp; Esqueceu a senha? Fale com a organização pelo WhatsApp.
        </p>
    </div>
</main>

</body>
</html>
