<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex,nofollow">
<title>Editar assinante · Dashboard</title>
<link rel="stylesheet" href="{{ asset('css/florescer.css') }}">
</head>
<body class="auth-page">

<header class="topbar topbar--area">
    <a class="brand brand--link" href="{{ route('admin.dashboard') }}">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="brand-logo">
        Dashboard
    </a>
</header>

<main class="auth-wrap">
    <div class="auth-card">
        <h1 class="auth-title">Editar assinante</h1>
        <p class="auth-sub">Inscrição #{{ $order->id }} · {{ optional($order->created_at)->format('d/m/Y H:i') }}</p>

        @if($errors->any())
            <div class="auth-alert">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('admin.update', $order->id) }}" class="auth-form">
            @csrf
            <label class="auth-label" for="customer_name">Nome</label>
            <input class="auth-input" id="customer_name" name="customer_name" value="{{ old('customer_name', $order->customer_name) }}" required>
            <label class="auth-label" for="customer_email">E-mail (login)</label>
            <input class="auth-input" type="email" id="customer_email" name="customer_email" value="{{ old('customer_email', $order->customer_email) }}" required>
            <label class="auth-label" for="customer_whatsapp">WhatsApp</label>
            <input class="auth-input" id="customer_whatsapp" name="customer_whatsapp" value="{{ old('customer_whatsapp', $order->customer_whatsapp) }}">
            <button class="button button--full" type="submit">Salvar</button>
        </form>

        <p class="auth-foot"><a href="{{ route('admin.dashboard') }}">← Voltar ao dashboard</a></p>
    </div>
</main>

</body>
</html>
