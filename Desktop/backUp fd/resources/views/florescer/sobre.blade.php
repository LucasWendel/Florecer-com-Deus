<!doctype html>
<html lang="pt-BR" data-i18n-title="doc.sobre">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Conheça Alexandra Sá | Florescer com Deus</title>
    <meta name="description" content="Conheça Alexandra Sá, idealizadora do projeto Florescer com Deus, e a história do sonho que a moveu a reunir 365 histórias reais de fé.">
    <link rel="stylesheet" href="{{ asset('css/florescer.css') }}">
</head>
<body>
<header class="site-nav" data-site-nav>
    <div class="site-nav__inner">
        <a class="brand brand--link site-nav__brand" href="{{ url('/') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Florescer com Deus" class="brand-logo">
            <span data-i18n="brand.name">Florescer com Deus</span>
        </a>

        <button class="site-nav__toggle" type="button" aria-expanded="false" aria-controls="site-nav-menu-sobre" aria-label="Menu" data-nav-toggle>
            <span></span><span></span><span></span>
        </button>

        <nav class="site-nav__menu" id="site-nav-menu-sobre" data-nav-menu>
            <a class="site-nav__link" href="{{ url('/') }}" data-i18n="nav.inicio">Início</a>
            <a class="site-nav__link site-nav__link--pill" href="{{ url('/#participar') }}" data-i18n="nav.participar">Fazer parte</a>

            <div class="site-nav__dropdown" data-dropdown>
                <button class="site-nav__link site-nav__dropbtn" type="button" aria-expanded="false" aria-haspopup="true" data-dropdown-toggle>
                    <span data-i18n="nav.login">Login</span>
                    <svg class="site-nav__chevron" viewBox="0 0 12 8" width="12" height="8" aria-hidden="true"><path d="M1 1l5 5 5-5" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                </button>
                <ul class="site-nav__submenu" role="menu">
                    <li role="none"><a class="site-nav__sublink" role="menuitem" href="{{ route('assinante.login') }}" data-i18n="nav.submenu1">Já faço parte</a></li>
                    <li role="none"><a class="site-nav__sublink" role="menuitem" href="{{ route('admin.dashboard') }}" data-i18n="nav.submenu2">Área restrita</a></li>
                </ul>
            </div>

            <div class="site-nav__lang">
                <label for="lang-select-sobre" class="sr-only" data-i18n="lang.label">Idioma</label>
                <select id="lang-select-sobre" class="lang-select" data-lang-select aria-label="Idioma / Language / Idioma">
                    <option value="pt">🇧🇷 Português</option>
                    <option value="en">🇺🇸 English</option>
                    <option value="es">🇪🇸 Español</option>
                </select>
            </div>
        </nav>
    </div>
</header>

<main>
    <section class="section sobre-hero">
        <div class="container two-col reveal">
            <div class="sobre-foto-wrap">
                <img src="{{ asset('images/alexandra.jpg') }}" alt="Alexandra Sá Bezerra Fagundes — Idealizadora do Florescer com Deus" class="sobre-foto">
            </div>
            <div>
                <p class="eyebrow" data-i18n="sobre.eyebrow">Idealizadora do projeto</p>
                <h1 class="sobre-titulo" data-i18n="sobre.title">Conheça um pouquinho de mim e da história desse sonho 🌷</h1>
                <p class="sobre-intro" data-i18n-html="sobre.intro"><em>Olá, minha querida! Que alegria ter você aqui!</em></p>
            </div>
        </div>
    </section>

    <section class="section section--white">
        <div class="container--narrow sobre-body reveal">
            <p data-i18n="sobre.p1">Antes de compartilhar esse projeto tão especial, quero me apresentar e contar um pouquinho sobre o sonho que Deus colocou em meu coração.</p>
            <p data-i18n-html="sobre.p2"><strong>Meu nome é Alexandra Sá.</strong> Sou cristã, adventista do sétimo dia, casada, mãe de dois filhos e atualmente moro na Irlanda com minha família.</p>
            <p data-i18n="sobre.p3">Assim como você, sou uma mulher que vive seus desafios, suas alegrias, suas preocupações e seus momentos de fé. Uma mulher que também tem sonhos, enfrenta dias difíceis, aprende com os recomeços e encontra em Deus a força necessária para continuar.</p>
            <p data-i18n="sobre.p4">Ao longo da minha caminhada, Deus me presenteou com a oportunidade de conhecer mulheres maravilhosas, cada uma com uma história única. Mulheres que enfrentaram batalhas silenciosas, passaram por momentos de dor, viveram experiências extraordinárias com Deus e receberam respostas de oração que emocionam só de ouvir.</p>
            <p data-i18n-html="sobre.p5">Quantas vezes me peguei pensando: <em>Meu Deus, como eu gostaria que outras mulheres também pudessem ouvir essa história!</em></p>
            <p data-i18n="sobre.p6">Mas havia algo que sempre tocava meu coração: por mais que eu tentasse contar o testemunho de outra pessoa, jamais conseguiria transmitir a mesma emoção, os mesmos sentimentos e a profundidade de quem realmente viveu aquela experiência.</p>
            <blockquote class="sobre-quote" data-i18n-html="sobre.q1"><strong>Porque existem lágrimas que só quem chorou consegue descrever, orações que só quem esperou pela resposta conhece e vitórias cujo verdadeiro significado só entende quem caminhou com Deus até alcançá-las.</strong></blockquote>
            <p data-i18n="sobre.p7">E eu pensava em quantas mulheres, espalhadas pelo mundo, poderiam ser fortalecidas por esses testemunhos.</p>
            <p data-i18n="sobre.p8">Talvez uma mulher esteja hoje enfrentando uma luta silenciosa, sentindo-se sozinha, cansada ou até perdendo a esperança. E talvez a história que você carrega seja exatamente aquilo que ela precisa ler para encontrar forças, renovar sua fé ou simplesmente lembrar que Deus não se esqueceu dela.</p>
            <p data-i18n="sobre.p9">Foi assim que um sonho, guardado por tanto tempo em meu coração e apresentado tantas vezes a Deus em oração, começou a ganhar forma.</p>
            <p class="sobre-destaque" data-i18n-html="sobre.h1"><strong>E nasceu o Florescer com Deus! 🌷</strong></p>
            <p data-i18n-html="sobre.p10">Um livro com <strong>365 meditações</strong>, escrito a partir de experiências reais de mulheres adventistas de diferentes partes do mundo. Um projeto que nasceu do desejo de compartilhar aquilo que Deus tem feito em nossas vidas e transformar cada testemunho em uma mensagem de fé, amor e esperança.</p>
            <p data-i18n="sobre.p11">E sabe o que torna esse sonho ainda mais bonito?</p>
            <p data-i18n-html="sobre.p12"><strong>Eu não quero realizá-lo sozinha. Quero que você faça parte dele!</strong></p>
            <p data-i18n="sobre.p13">Você não precisa ser escritora, ter uma história extraordinária aos olhos do mundo ou encontrar palavras perfeitas. Precisa apenas compartilhar, com o coração aberto, uma experiência da sua caminhada com Deus.</p>
            <p data-i18n="sobre.p14">Porque, muitas vezes, aquilo que consideramos simples em nossa vida pode representar um verdadeiro milagre para outra pessoa.</p>
            <p data-i18n="sobre.p15">Mais do que escrever um livro, quero que juntas possamos viver uma linda missão.</p>
            <p class="sobre-destaque" data-i18n-html="sobre.h2"><strong>Vamos ser missionárias juntas?</strong></p>
            <p data-i18n="sobre.p16">Acredito que não precisamos estar em um púlpito ou viajar para lugares distantes para falar do amor de Deus. Nossos testemunhos também podem ser instrumentos em Suas mãos, alcançando mulheres que talvez nunca conheceremos pessoalmente.</p>
            <p data-i18n="sobre.p17">Imagine que, em algum lugar do mundo, uma mulher abra este livro em um dia difícil e encontre, justamente na sua história, as palavras que precisava para não desistir.</p>
            <p data-i18n="sobre.p18">Que presente maravilhoso seria fazer parte disso!</p>
            <p data-i18n="sobre.p19">Gosto de imaginar que somos pequenas sementes nas mãos de Deus. Cada uma com sua história, suas experiências e seu tempo de florescer. Mas, quando nos unimos em um mesmo propósito, podemos formar um lindo jardim de fé, amor e esperança.</p>
            <blockquote class="sobre-quote" data-i18n-html="sobre.q2"><strong>E quem sabe a sua história seja justamente a sementinha que Deus usará para fazer outra mulher florescer?</strong></blockquote>
            <p data-i18n="sobre.p20">Por isso, minha querida, receba este convite com todo o carinho do meu coração.</p>
            <p data-i18n-html="sobre.p21"><strong>Venha fazer parte desse sonho. Vamos compartilhar nossas histórias, espalhar esperança e ser missionárias juntas!</strong></p>
            <p data-i18n="sobre.p22">Que Deus seja o verdadeiro autor dessa missão e que cada página seja um instrumento do Seu amor.</p>
            <p class="sobre-destaque" data-i18n-html="sobre.h3"><strong>Vamos florescer com Deus, juntas! 🌷💕</strong></p>
            <p data-i18n="sobre.farewell">Com muito carinho e orações,</p>
            <p class="sobre-assinatura">
                <strong>Alexandra Sá Bezerra Fagundes</strong><br>
                <span data-i18n="sobre.role">Idealizadora do projeto Florescer com Deus</span>
            </p>
            <div class="sobre-cta">
                <a class="button button--lg" href="{{ url('/#sobre') }}" data-i18n="sobre.cta">Quero fazer parte! 🌷</a>
            </div>
        </div>
    </section>
</main>

<footer class="footer">
    <p>&copy; {{ date('Y') }} Florescer com Deus · Projeto missionário</p>
</footer>

<script src="{{ asset('js/florescer.js') }}"></script>
<script src="{{ asset('js/i18n.js') }}"></script>
</body>
</html>
