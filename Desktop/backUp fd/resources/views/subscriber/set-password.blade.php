<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Criar senha · Florescer com Deus</title>
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
        <div class="auth-icon">✨</div>
        <h1 class="auth-title">Primeiro acesso</h1>
        <p class="auth-sub">Olá{{ $name ? ', ' . $name : '' }}! Crie uma senha para acessar sua área nas próximas vezes.</p>

        @if($errors->any())
            <div class="auth-alert">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('assinante.salvar-senha') }}" class="auth-form">
            @csrf
            <label class="auth-label" for="password">Nova senha (mínimo 6 caracteres)</label>
            <input class="auth-input" type="password" id="password" name="password"
                   required minlength="6" autocomplete="new-password" autofocus>
            <label class="auth-label" for="password_confirmation">Confirme a senha</label>
            <input class="auth-input" type="password" id="password_confirmation" name="password_confirmation"
                   required minlength="6" autocomplete="new-password">
            <button class="button button--full" type="submit">Criar senha e entrar</button>
        </form>
        <p class="auth-back"><a class="auth-back__link" href="{{ url('/') }}">← Voltar ao site</a></p>
    </div>
</main>

</body>
</html>
