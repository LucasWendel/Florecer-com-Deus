<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Minha área · Florescer com Deus</title>
<link rel="stylesheet" href="{{ asset('css/florescer.css') }}">
</head>
<body class="auth-page">

<header class="topbar topbar--area">
    <a class="brand brand--link" href="{{ url('/') }}">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="brand-logo">
        Florescer com Deus
    </a>
    @include('florescer.partials.lang-switcher')
    <form method="POST" action="{{ route('assinante.logout') }}">
        @csrf
        <button class="area-logout" type="submit" data-i18n="nav.sair">Sair</button>
    </form>
</header>

<main class="area-wrap">
    <div class="area-hello">
        <p class="eyebrow" data-i18n="area.eyebrow">Área do Participante</p>
        <h1><span data-i18n="area.hello">Olá</span>, {{ $order->customer_name ?: 'participante' }}! 🌷</h1>
        <p data-i18n-html="area.intro">Que alegria ter você no <em>Florescer com Deus</em>. Aqui você encontra tudo para participar do livro.</p>
    </div>

    <div class="area-grid">
        {{-- 1. Grupo WhatsApp --}}
        <div class="area-card">
            <div class="area-card__icon">💬</div>
            <h2 data-i18n="area.wa.title">Grupo exclusivo</h2>
            <p data-i18n="area.wa.desc">Entre no grupo do WhatsApp das participantes para receber orientações e avisos.</p>
            @if($whatsappLink)
                <a class="button button--full" href="{{ $whatsappLink }}" target="_blank" rel="noopener" data-i18n="area.wa.cta">Entrar no grupo</a>
            @else
                <span class="area-pending" data-i18n="area.wa.soon">Link em breve</span>
            @endif
        </div>

        {{-- 2. Formulário --}}
        <div class="area-card">
            <div class="area-card__icon">📝</div>
            <h2 data-i18n="area.form.title">Formulário de Coautora</h2>
            <p data-i18n="area.form.desc">Envie seu testemunho e as informações para o livro.</p>
            @if($submission)
                <span class="area-pending" data-i18n="area.form.done">✅ Formulário enviado</span>
            @else
                <a class="button button--full" href="{{ route('assinante.formulario') }}" data-i18n="area.form.cta">Preencher formulário</a>
            @endif
        </div>

        {{-- 3. Diretrizes --}}
        <div class="area-card">
            <div class="area-card__icon">📄</div>
            <h2 data-i18n="area.guide.title">Guia de Escrita para Coautoras</h2>
            <p data-i18n="area.guide.desc">Baixe o PDF com as orientações para escrever sua história.</p>
            @if(file_exists(public_path('downloads/diretrizes.pdf')))
                <a class="button button--full" href="{{ asset('downloads/diretrizes.pdf') }}" download="Guia-de-Escrita-Coautoras-Florescer-com-Deus.pdf" data-i18n="area.guide.cta">Baixar Guia de Escrita (PDF)</a>
            @else
                <span class="area-pending" data-i18n="area.guide.soon">Disponível em breve</span>
            @endif
        </div>
    </div>
</main>

<script src="{{ asset('js/i18n.js') }}"></script>
</body>
</html>
