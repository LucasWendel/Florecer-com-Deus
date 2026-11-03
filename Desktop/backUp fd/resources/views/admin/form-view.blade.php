@php
    $mapLang = ['pt' => 'Português', 'en' => 'English', 'es' => 'Español'];
    $mapYes = ['yes' => 'Sim', 'no' => 'Não', 'maybe' => 'Talvez'];
    $mapFound = ['social' => 'Redes Sociais', 'friend' => 'Amigo ou Familiar', 'church' => 'Igreja', 'invite' => 'Convite Pessoal da Idealizadora', 'other' => 'Outro'];
    $mapFaith = ['overcoming' => 'Superação de adversidades', 'growth' => 'Crescimento espiritual', 'purpose' => 'Encontrando propósito', 'service' => 'Atos de serviço', 'prayer' => 'Transformação pela oração'];
    $faith = [];
    if ($submission && $submission->faith_aspects) {
        foreach (array_filter(array_map('trim', explode(',', $submission->faith_aspects))) as $f) {
            $faith[] = $mapFaith[$f] ?? $f;
        }
    }
    $fmtDate = function ($d) {
        if (!$d) return '—';
        try { return \Carbon\Carbon::parse($d)->format('d/m/Y'); } catch (\Throwable $e) { return $d; }
    };
@endphp
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex,nofollow">
<title>Formulário de {{ $order->customer_name }} · Dashboard</title>
<link rel="stylesheet" href="{{ asset('css/florescer.css') }}">
</head>
<body class="auth-page">

<header class="topbar topbar--area">
    <a class="brand brand--link" href="{{ route('admin.dashboard') }}">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="brand-logo">
        Dashboard
    </a>
    <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button class="area-logout" type="submit">Sair</button>
    </form>
</header>

<main class="dash-wrap">
    <p><a class="dash-btn" href="{{ route('admin.dashboard') }}">← Voltar para a lista</a></p>

    <section class="dash-card">
        <div class="dash-head"><h2>Inscrita</h2></div>
        <div class="fv-grid">
            <div class="fv-row"><span>Nome</span><strong>{{ $order->customer_name ?: '—' }}</strong></div>
            <div class="fv-row"><span>E-mail</span><strong>{{ $order->customer_email ?: '—' }}</strong></div>
            <div class="fv-row"><span>WhatsApp</span><strong>{{ $order->customer_whatsapp ?: '—' }}</strong></div>
            <div class="fv-row"><span>Data da inscrição</span><strong>{{ optional($order->created_at)->format('d/m/Y H:i') ?? '—' }}</strong></div>
        </div>
    </section>

    <section class="dash-card">
        <div class="dash-head"><h2>Respostas do formulário</h2></div>

        @if(!$submission)
            <p class="dash-empty">Este inscrito ainda não enviou o formulário.</p>
        @else
            <p class="fv-sent">Enviado em {{ optional($submission->created_at)->format('d/m/Y H:i') }}</p>

            <div class="fv-downloads">
                @if($submission->photo_file)
                    <img class="fv-photo" src="{{ asset($submission->photo_file) }}" alt="Foto enviada">
                @endif
                <div class="fv-dl-btns">
                    @if($submission->testimony_file)
                        <a class="dash-btn dash-btn--form" href="{{ route('admin.download-file', [$order->id, 'testemunho']) }}">⬇ Baixar testemunho</a>
                    @else
                        <span class="dash-btn dash-btn--muted">Sem testemunho</span>
                    @endif
                    @if($submission->photo_file)
                        <a class="dash-btn dash-btn--form" href="{{ route('admin.download-file', [$order->id, 'foto']) }}">⬇ Baixar foto</a>
                    @else
                        <span class="dash-btn dash-btn--muted">Sem foto</span>
                    @endif
                </div>
            </div>

            <div class="fv-grid">
                <div class="fv-row"><span>Nome completo</span><strong>{{ $submission->full_name ?: '—' }}</strong></div>
                <div class="fv-row"><span>Nome para publicação</span><strong>{{ $submission->published_name ?: '—' }}</strong></div>
                <div class="fv-row"><span>E-mail</span><strong>{{ $submission->email ?: '—' }}</strong></div>
                <div class="fv-row"><span>Telefone / WhatsApp</span><strong>{{ $submission->phone ?: '—' }}</strong></div>
                <div class="fv-row"><span>País de nascimento</span><strong>{{ $submission->country_birth ?: '—' }}</strong></div>
                <div class="fv-row"><span>País onde mora</span><strong>{{ $submission->country_current ?: '—' }}</strong></div>
                <div class="fv-row"><span>Profissão</span><strong>{{ $submission->profession ?: '—' }}</strong></div>
                <div class="fv-row"><span>Aniversário</span><strong>{{ $fmtDate($submission->birthday) }}</strong></div>
                <div class="fv-row fv-row--full"><span>Mini biografia</span><strong>{!! $submission->mini_bio ? nl2br(e($submission->mini_bio)) : '—' !!}</strong></div>
                <div class="fv-row fv-row--full"><span>Título do testemunho</span><strong>{{ $submission->testimony_title ?: '—' }}</strong></div>
                <div class="fv-row"><span>Idioma de preferência</span><strong>{{ $mapLang[$submission->language_pref] ?? ($submission->language_pref ?: '—') }}</strong></div>
                <div class="fv-row"><span>Autoriza divulgação nas redes</span><strong>{{ $mapYes[$submission->social_auth] ?? ($submission->social_auth ?: '—') }}</strong></div>
                <div class="fv-row"><span>Como conheceu o projeto</span><strong>{{ $mapFound[$submission->how_found] ?? ($submission->how_found ?: '—') }}</strong></div>
                <div class="fv-row"><span>Participar de eventos futuros</span><strong>{{ $mapYes[$submission->future_events] ?? ($submission->future_events ?: '—') }}</strong></div>
                <div class="fv-row fv-row--full"><span>Aspectos da fé no testemunho</span><strong>{{ $faith ? implode(', ', $faith) : '—' }}</strong></div>
                <div class="fv-row"><span>Entusiasmo (1 a 5)</span><strong>{{ $submission->enthusiasm ? $submission->enthusiasm . ' / 5' : '—' }}</strong></div>
            </div>
        @endif
    </section>
</main>
</body>
</html>
