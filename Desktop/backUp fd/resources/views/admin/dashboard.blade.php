@php
    $simbolos = ['brl' => 'R$', 'usd' => 'US$', 'eur' => '€'];
    // Monta os últimos 7 dias (inclusive dias sem inscrição)
    $porDia = $dailyCounts->pluck('total', 'day')->toArray();
    $dias = [];
    for ($i = 6; $i >= 0; $i--) {
        $d = now()->subDays($i)->toDateString();
        $dias[$d] = (int) ($porDia[$d] ?? 0);
    }
    $max = max(1, max($dias));
    $receita = [];
    foreach ($subscribers as $s) {
        $cur = strtolower($s->currency ?: 'brl');
        $receita[$cur] = ($receita[$cur] ?? 0) + $s->amount;
    }
@endphp
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex,nofollow">
<title>Dashboard · Florescer com Deus</title>
<link rel="stylesheet" href="{{ asset('css/florescer.css') }}">
</head>
<body class="auth-page">

<header class="topbar topbar--area">
    <a class="brand brand--link" href="{{ url('/') }}">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="brand-logo">
        Dashboard
    </a>
    <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button class="area-logout" type="submit">Sair</button>
    </form>
</header>

<main class="dash-wrap">
    @if(session('success'))
        <div class="dash-success">{{ session('success') }}</div>
    @endif

    <section class="dash-kpis">
        <div class="dash-kpi">
            <span class="dash-kpi__label">Inscrições hoje</span>
            <strong class="dash-kpi__value">{{ $todayCount }}</strong>
        </div>
        <div class="dash-kpi">
            <span class="dash-kpi__label">Total de assinantes</span>
            <strong class="dash-kpi__value">{{ $totalCount }}</strong>
        </div>
        <div class="dash-kpi">
            <span class="dash-kpi__label">Receita (lista atual)</span>
            <strong class="dash-kpi__value dash-kpi__value--sm">
                @forelse($receita as $cur => $cents)
                    {{ $simbolos[$cur] ?? strtoupper($cur) }} {{ number_format($cents / 100, 2, ',', '.') }}<br>
                @empty
                    —
                @endforelse
            </strong>
        </div>
    </section>

    <section class="dash-card">
        <h2>Inscrições por dia (últimos 7 dias)</h2>
        <div class="dash-chart">
            @foreach($dias as $d => $n)
                <div class="dash-bar">
                    <span class="dash-bar__num">{{ $n }}</span>
                    <div class="dash-bar__fill" style="height: {{ max(4, round($n / $max * 140)) }}px"></div>
                    <span class="dash-bar__day">{{ \Carbon\Carbon::parse($d)->format('d/m') }}</span>
                </div>
            @endforeach
        </div>
    </section>

    <section class="dash-card">
        <div class="dash-head">
            <h2>Assinantes ({{ $subscribers->count() }})</h2>
            <div class="dash-search-row">
                <form method="GET" action="{{ route('admin.dashboard') }}" class="dash-search">
                    <input class="auth-input" type="search" name="search" value="{{ $search }}" placeholder="Buscar nome, e-mail ou WhatsApp">
                    <button class="button" type="submit">Buscar</button>
                </form>
                <a class="button button--outline" href="{{ route('admin.export-excel') }}" title="Baixar planilha com todos os inscritos">
                    ⬇ Exportar Excel
                </a>
            </div>
        </div>

        <div class="dash-table-wrap">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>WhatsApp</th>
                        <th>Valor</th>
                        <th>ID Stripe</th>
                        <th>Senha</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($subscribers as $s)
                    <tr>
                        <td>{{ optional($s->created_at)->format('d/m/Y H:i') }}</td>
                        <td>{{ $s->customer_name }}</td>
                        <td>{{ $s->customer_email }}</td>
                        <td>{{ $s->customer_whatsapp }}</td>
                        <td>{{ $simbolos[strtolower($s->currency)] ?? strtoupper($s->currency) }} {{ number_format($s->amount / 100, 2, ',', '.') }}</td>
                        <td class="dash-mono" title="{{ $s->checkout_session_id }}">{{ \Illuminate\Support\Str::limit($s->checkout_session_id, 18) }}</td>
                        <td>{{ $s->password_set_at ? 'Criada' : 'Pendente' }}</td>
                        <td class="dash-actions">
                            @if($s->formSubmission)
                            <a class="dash-btn dash-btn--form" href="{{ route('admin.form-view', $s->id) }}">Ver formulário</a>
                            @else
                            <span class="dash-btn dash-btn--muted">Sem formulário</span>
                            @endif
                            <a class="dash-btn" href="{{ route('admin.edit', $s->id) }}">Editar</a>
                            @if($s->password_set_at)
                            <form method="POST" action="{{ route('admin.reset-password', $s->id) }}" onsubmit="return confirm('Redefinir a senha deste assinante?');">
                                @csrf
                                <button class="dash-btn" type="submit">Resetar senha</button>
                            </form>
                            @endif
                            <form method="POST" action="{{ route('admin.delete', $s->id) }}" onsubmit="return confirm('Excluir este assinante? Esta ação não pode ser desfeita.');">
                                @csrf
                                <button class="dash-btn dash-btn--danger" type="submit">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="dash-empty">Nenhum assinante encontrado.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>
</main>

</body>
</html>
