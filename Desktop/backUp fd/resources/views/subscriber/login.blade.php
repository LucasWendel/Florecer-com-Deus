<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Área do Participante · Florescer com Deus</title>
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
        <div class="auth-icon">🌷</div>
        <h1 class="auth-title">Área do Participante</h1>
        <p class="auth-sub">Informe o e-mail cadastrado na sua inscrição para acessar sua área exclusiva.</p>

        @if($errors->any())
            <div class="auth-alert">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('assinante.check-email') }}" class="auth-form">
            @csrf
            <label class="auth-label" for="email">E-mail</label>
            <input class="auth-input" type="email" id="email" name="email"
                   value="{{ old('email') }}" placeholder="seu@email.com"
                   required autocomplete="email" autofocus>
            <button class="button button--full" type="submit">Continuar →</button>
        </form>

        <p class="auth-back"><a class="auth-back__link" href="{{ url('/') }}">← Voltar ao site</a></p>

        <p class="auth-foot">
            Ainda não participou?
            <a href="{{ url('/#participar') }}">Quero me inscrever 🌷</a>
        </p>
    </div>
</main>

</body>
</html>
