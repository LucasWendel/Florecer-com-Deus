@php
    // Valor único: €10 (o Stripe converte para a moeda local no checkout).
    $valorFmt = '€ ' . number_format($valor ?? 10, 2, ',', '.');
    $locais = [
        'chip.africa' => 'África', 'chip.brasil' => 'Brasil', 'chip.london' => 'Reino Unido',
        'chip.eua' => 'Estados Unidos', 'chip.japao' => 'Japão', 'chip.portugal' => 'Portugal',
        'chip.espanha' => 'Espanha', 'chip.argentina' => 'Argentina', 'chip.colombia' => 'Colômbia',
        'chip.chile' => 'Chile', 'chip.outros' => 'e outros lugares',
    ];
@endphp
<!doctype html>
<html lang="pt-BR" data-i18n-title="doc.home">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Florescer com Deus | Projeto missionário para mulheres</title>
    <meta name="description" content="Florescer com Deus: um projeto missionário com 365 histórias reais de fé escritas por mulheres cristãs do mundo todo.">
    <meta property="og:title" content="Florescer com Deus">
    <meta property="og:description" content="Sua história com Deus pode ser a flor que faltava no dia de outra mulher.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <link rel="stylesheet" href="{{ asset('css/florescer.css') }}">
</head>
<body>
<header class="site-nav" data-site-nav>
    <div class="site-nav__inner">
        <a class="brand brand--link site-nav__brand" href="{{ url('/') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Florescer com Deus" class="brand-logo">
            <span data-i18n="brand.name">Florescer com Deus</span>
        </a>

        <button class="site-nav__toggle" type="button" aria-expanded="false" aria-controls="site-nav-menu" aria-label="Menu" data-nav-toggle>
            <span></span><span></span><span></span>
        </button>

        <nav class="site-nav__menu" id="site-nav-menu" data-nav-menu>
            <a class="site-nav__link" href="#sobre" data-i18n="nav.quem">Quem idealizou?</a>
            <a class="site-nav__link" href="#faq" data-i18n="nav.faq">Perguntas frequentes</a>
            <a class="site-nav__link site-nav__link--pill" href="#participar" data-i18n="nav.participar">Fazer parte</a>

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
                <label for="lang-select" class="sr-only" data-i18n="lang.label">Idioma</label>
                <select id="lang-select" class="lang-select" data-lang-select aria-label="Idioma / Language / Idioma">
                    <option value="pt">🇧🇷 Português</option>
                    <option value="en">🇺🇸 English</option>
                    <option value="es">🇪🇸 Español</option>
                </select>
            </div>
        </nav>
    </div>
</header>

<main>
    <section class="section section--center">
        <div class="container reveal">
            <div class="hero-brand reveal">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Florescer com Deus" class="hero-brand__logo">
            <div class="hero-brand__text">
                <span class="hero-brand__name" data-i18n="brand.line1">Florescer</span>
                <span class="hero-brand__sub" data-i18n="brand.line2">com Deus</span>
            </div>
        </div>
                <p class="eyebrow" data-i18n="hero.eyebrow">Um devocional escrito por 365 mulheres adventistas</p>
            <h1 data-i18n="hero.title">Sua história com Deus pode ser a flor que faltava no dia de outra mulher.</h1>
            <p class="hero-text" data-i18n="hero.text">Florescer com Deus reúne 365 histórias reais, uma para cada dia do ano, contadas por mulheres do mundo inteiro. E existe um dia esperando pela sua: o do seu aniversário.</p>
            <a class="button" href="#participar" data-i18n="hero.cta">Quero fazer parte</a>
        </div>
    </section>

    <section class="section section--soft">
        <div class="container--narrow reveal">
            <p class="eyebrow" data-i18n="msg.eyebrow">Uma mensagem para você</p>
            <h2 data-i18n="msg.title">Querida mulher,</h2>
            <p data-i18n="msg.p1">Existe um momento da sua vida em que você soube, sem sombra de dúvida, que Deus estava ali. Talvez numa noite em que não havia mais saída. Talvez numa porta que se abriu quando tudo parecia fechado. Talvez num silêncio que, de repente, se encheu de paz.</p>
            <p data-i18n-html="msg.p2">Esse momento não foi só seu. Foi um presente que Deus colocou em suas mãos para que, no tempo certo, você o entregasse a alguém que precisa ouvir: <em>você não está sozinha</em>.</p>
            <p data-i18n="msg.p3">Neste instante, em algum lugar do mundo, uma mulher acorda cansada, com medo e com perguntas que não consegue dizer em voz alta. Ela não precisa de um discurso. Precisa de uma história verdadeira, contada por alguém que também já chorou, também já duvidou e também viu Deus agir.</p>
            <p style="margin-bottom:0;" data-i18n="msg.p4">Foi assim que nasceu o Florescer com Deus.</p>
        </div>
    </section>

    <section id="sobre" class="section section--white">
        <div class="container two-col reveal">
            <div class="sobre-foto-wrap">
                <img
                    src="{{ asset('images/alexandra.jpg') }}"
                    alt="Alexandra Sá Bezerra Fagundes — Idealizadora do Florescer com Deus"
                    class="sobre-foto"
                >
            </div>
            <div>
                <p class="eyebrow" data-i18n="author.eyebrow">Quem idealizou este projeto</p>
                <h2>Alexandra Sá</h2>
                <p data-i18n-html="author.p1">Alexandra é cristã, adventista do sétimo dia, casada, mãe de dois filhos e mora na Irlanda. O <em>Florescer com Deus</em> nasceu de um sonho guardado em seu coração: reunir histórias reais de mulheres do mundo todo para que a fé de uma fortaleça a fé de outras.</p>
                <p data-i18n-html="author.p2"><em>"Porque existem lágrimas que só quem chorou consegue descrever, orações que só quem esperou pela resposta conhece e vitórias cujo verdadeiro significado só entende quem caminhou com Deus até alcançá-las."</em></p>
                <a class="button" href="{{ route('sobre') }}" data-i18n="author.lermais">Ler mais 🌷</a>
            </div>
        </div>
    </section>

    <section class="section section--warm section--center">
        <div class="container--narrow reveal">
            <p class="eyebrow" data-i18n="invite.eyebrow">UM CONVITE ESPECIAL PARA VOCÊ</p>
            <p class="quote" style="font-style:normal;" data-i18n="invite.quote">Se este convite chegou até você, é porque, de alguma forma, sua história já tocou a minha vida ou de alguém que me conhece e me ajudou eu chegar até você. E acredito, de todo o coração, que ela também pode tocar, inspirar e transformar a vida de muitas outras mulheres.</p>
            <p style="margin-top:18px; font-style:italic;" data-i18n-html="invite.italic"><em>Sua história é única. Sua voz tem valor. E aquilo que Deus fez em sua vida pode fazer florescer a esperança no coração de outra mulher.</em></p>
        </div>
    </section>

    <section class="section section--center">
        <div class="container reveal">
            <p class="eyebrow" data-i18n="project.eyebrow">O projeto</p>
            <h2 data-i18n="project.title">365 histórias reais para o ano inteiro</h2>
            <div class="grid grid-3" style="margin-top:42px; text-align:left;">
                <article class="card">
                    <h3 data-i18n="project.c1t">365 histórias</h3>
                    <p data-i18n="project.c1p">Uma para cada dia do ano. Cada devocional é um testemunho verdadeiro, contado com palavras de quem viveu.</p>
                </article>
                <article class="card">
                    <h3 data-i18n="project.c2t">No seu aniversário</h3>
                    <p data-i18n="project.c2p">Sua história ocupa a data em que você nasceu: um dia do livro que leva sua fé e sua voz a outras mulheres.</p>
                </article>
                <article class="card">
                    <h3 data-i18n="project.c3t">Milagres e cuidado</h3>
                    <p data-i18n="project.c3p">Relatos de fé, milagres e do cuidado de Deus para fortalecer mulheres em cada fase da vida.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="section section--soft section--center">
        <div class="container--narrow reveal">
            <p class="eyebrow" data-i18n="world.eyebrow">Mulheres do mundo todo</p>
            <h2 data-i18n="world.title">Idiomas diferentes, o mesmo Deus</h2>
            <p data-i18n="world.text">Mulheres da África, Brasil, Reino Unido, Estados Unidos, Japão, Portugal, Espanha, Argentina, Colômbia, Chile e muitos outros lugares, unidas pela mesma fé em Cristo.</p>
            <div class="chips" style="margin-top:24px;">
                @foreach ($locais as $chave => $local)
                    <span class="chip" data-i18n="{{ $chave }}">{{ $local }}</span>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section section--white section--center">
        <div class="container--narrow reveal">
            <p class="quote" data-i18n="verse.text">“Vinde, ouvi, todos vós que temeis a Deus, e eu contarei o que ele tem feito por minha alma.”</p>
            <p class="eyebrow" style="margin-bottom:0;" data-i18n="verse.ref">Salmos 66:16 (ARC)</p>
        </div>
    </section>

    <section class="section section--soft section--center">
        <div class="container reveal">
            <p class="eyebrow" data-i18n="why.eyebrow">Por que participar</p>
            <h2 data-i18n="why.title">O que a sua história pode fazer</h2>
            <div class="grid grid-3" style="margin-top:42px; text-align:left;">
                <article class="card">
                    <h3 data-i18n="why.c1t">Consolar</h3>
                    <p data-i18n="why.c1p">Uma mulher pode ler o que Deus fez na sua vida e lembrar que Ele também cuida dela.</p>
                </article>
                <article class="card">
                    <h3 data-i18n="why.c2t">Ser ouvida</h3>
                    <p data-i18n="why.c2p">Sua experiência com Deus importa. Ela merece ser registrada, guardada e compartilhada.</p>
                </article>
                <article class="card">
                    <h3 data-i18n="why.c3t">Fazer parte de algo maior</h3>
                    <p data-i18n="why.c3p">Um projeto missionário que cresce para incentivar, motivar e inspirar mulheres.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="section section--center">
        <div class="container reveal">
            <p class="eyebrow" data-i18n="how.eyebrow">Como participar</p>
            <h2 data-i18n="how.title">Três passos simples</h2>
            <div class="steps grid grid-3" style="margin-top:38px;">
                <article class="step">
                    <div class="step-badge">1º</div>
                    <div class="step-content">
                        <h3 data-i18n="how.s1t">Garanta a sua participação</h3>
                        <p data-i18n="how.s1p">Reserve o seu lugar e o dia do seu aniversário no livro.</p>
                    </div>
                </article>
                <article class="step">
                    <div class="step-badge">2º</div>
                    <div class="step-content">
                        <h3 data-i18n="how.s2t">Conte a sua história</h3>
                        <p data-i18n="how.s2p">Compartilhe a experiência com Deus que mais marcou sua vida.</p>
                    </div>
                </article>
                <article class="step">
                    <div class="step-badge">3º</div>
                    <div class="step-content">
                        <h3 data-i18n="how.s3t">Floresça no seu dia</h3>
                        <p data-i18n="how.s3p">Sua história será publicada na data do seu aniversário no livro.</p>
                    </div>
                </article>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section id="faq" class="section section--white">
        <div class="container--narrow reveal">
            <p class="eyebrow" data-i18n="faq.eyebrow">Tire suas dúvidas</p>
            <h2 data-i18n="faq.title">Perguntas Frequentes</h2>
            <ul class="faq-list" style="margin-top:40px;">
                <li class="faq-item">
                    <button class="faq-trigger" aria-expanded="false">
                        <span data-i18n="faq.q1">Preciso ser escritora profissional para participar?</span>
                        <i class="faq-icon">+</i>
                    </button>
                    <div class="faq-body" data-i18n-html="faq.a1">
                        <p>Não! Você só precisa ter uma história verdadeira para compartilhar. O mais importante é contar, com sinceridade, uma experiência marcante da sua caminhada com Deus. Nosso desejo é reunir testemunhos capazes de inspirar e fortalecer a fé de outras mulheres.</p>
                    </div>
                </li>
                <li class="faq-item">
                    <button class="faq-trigger" aria-expanded="false">
                        <span data-i18n="faq.q2">Preciso pagar alguma coisa para participar?</span>
                        <i class="faq-icon">+</i>
                    </button>
                    <div class="faq-body" data-i18n-html="faq.a2">
                        <p>Para apoiar a realização deste sonho, solicitamos uma <strong>contribuição simbólica no momento da inscrição</strong>.</p>
                        <p>Esse valor será destinado a auxiliar nos custos de preparação, impressão e publicação do livro. Sua contribuição é uma forma de ajudar esse projeto missionário a seguir adiante e alcançar mulheres em diferentes partes do mundo.</p>
                    </div>
                </li>
                <li class="faq-item">
                    <button class="faq-trigger" aria-expanded="false">
                        <span data-i18n="faq.q3">Vou poder adquirir o livro depois de publicado?</span>
                        <i class="faq-icon">+</i>
                    </button>
                    <div class="faq-body" data-i18n-html="faq.a3">
                        <p>Sim! O Florescer com Deus estará disponível para compra em formato <strong>físico e digital</strong>, com a proposta de alcançar leitoras em diferentes países. Assim, você poderá adquirir seu exemplar e compartilhar essa mensagem especial com familiares e amigas.</p>
                    </div>
                </li>
                <li class="faq-item">
                    <button class="faq-trigger" aria-expanded="false">
                        <span data-i18n="faq.q4">Também posso ajudar a divulgar o livro e receber pelas vendas?</span>
                        <i class="faq-icon">+</i>
                    </button>
                    <div class="faq-body" data-i18n-html="faq.a4">
                        <p>Sim! As participantes poderão receber um <strong>link exclusivo de divulgação</strong>, permitindo compartilhar o livro com outras pessoas e receber uma comissão pelas vendas realizadas através desse link.</p>
                        <p>Antes de confirmar sua participação, você terá acesso aos termos e condições, incluindo as informações sobre o programa de afiliadas, os percentuais de comissão e as regras de pagamento.</p>
                    </div>
                </li>
                <li class="faq-item">
                    <button class="faq-trigger" aria-expanded="false">
                        <span data-i18n="faq.q5">O livro será publicado apenas em um idioma?</span>
                        <i class="faq-icon">+</i>
                    </button>
                    <div class="faq-body" data-i18n-html="faq.a5">
                        <p>Nossa missão é levar essas histórias ao maior número possível de mulheres! E temos escritoras de vários países que farão parte do projeto. Por isso, o projeto prevê a disponibilização do livro em <strong>diferentes idiomas</strong>, ampliando seu alcance internacional.</p>
                        <p>As traduções e versões disponíveis serão informadas conforme o cronograma de publicação em cada mercado.</p>
                    </div>
                </li>
                <li class="faq-item">
                    <button class="faq-trigger" aria-expanded="false">
                        <span data-i18n="faq.q6">Como faço para me inscrever?</span>
                        <i class="faq-icon">+</i>
                    </button>
                    <div class="faq-body" data-i18n-html="faq.a6">
                        <p>É muito simples!</p>
                        <ol style="padding-left:20px; margin-top:8px;">
                            <li style="margin-bottom:6px;">Clique no botão <strong>Quero fazer parte</strong>.</li>
                            <li style="margin-bottom:6px;">Leia atentamente e aceite os termos e condições de participação.</li>
                            <li>Preencha seus dados e finalize sua inscrição.</li>
                        </ol>
                        <p style="margin-top:12px;">Após a confirmação, você receberá as orientações para enviar sua história e participar das próximas etapas do projeto.</p>
                    </div>
                </li>
                <li class="faq-item">
                    <button class="faq-trigger" aria-expanded="false">
                        <span data-i18n="faq.q7">Conheço uma amiga adventista com um testemunho lindo. Ela também pode participar?</span>
                        <i class="faq-icon">+</i>
                    </button>
                    <div class="faq-body" data-i18n-html="faq.a7">
                        <p>Claro! Ficaremos muito felizes em conhecer a história dela!</p>
                        <p>Compartilhe esta página e convide outras mulheres adventistas a fazer parte dessa missão. Enquanto houver oportunidades disponíveis para novas coautoras, as inscrições poderão ser recebidas e avaliadas pela organização do projeto.</p>
                    </div>
                </li>
                <li class="faq-item">
                    <button class="faq-trigger" aria-expanded="false">
                        <span data-i18n="faq.q8">A forma de pagamento é segura?</span>
                        <i class="faq-icon">+</i>
                    </button>
                    <div class="faq-body" data-i18n-html="faq.a8">
                        <p>A contribuição será realizada por meio de uma plataforma de pagamento online com processamento seguro e proteção dos dados financeiros.</p>
                        <p>As informações de pagamento serão tratadas pelo provedor responsável, conforme suas políticas de segurança e privacidade. Antes de concluir, você poderá conferir o valor e as informações da transação.</p>
                    </div>
                </li>
                <li class="faq-item">
                    <button class="faq-trigger" aria-expanded="false">
                        <span data-i18n="faq.q9">Vou receber direitos autorais pelas vendas do livro?</span>
                        <i class="faq-icon">+</i>
                    </button>
                    <div class="faq-body" data-i18n-html="faq.a9">
                        <p>A participação como coautora não prevê o pagamento de royalties sobre as vendas gerais da obra.</p>
                        <p>Entretanto, você poderá participar do programa de divulgação por meio de um link exclusivo e receber comissões pelas vendas elegíveis realizadas através dele, conforme as condições apresentadas antes da inscrição.</p>
                    </div>
                </li>
                <li class="faq-item">
                    <button class="faq-trigger" aria-expanded="false">
                        <span data-i18n="faq.q10">Quando o livro será publicado?</span>
                        <i class="faq-icon">+</i>
                    </button>
                    <div class="faq-body" data-i18n-html="faq.a10">
                        <p>Estamos trabalhando com muito carinho para que o Florescer com Deus seja publicado o mais breve possível. As participantes receberão informações sobre o cronograma, as etapas de produção e a previsão de lançamento.</p>
                    </div>
                </li>
            </ul>

            <div class="faq-closing reveal" style="margin-top:52px; text-align:center;">
                <p class="faq-closing-line" data-i18n="faq.closing1">Sua história pode ser a resposta à oração de outra mulher.</p>
                <p class="faq-closing-big" style="margin-bottom:10px;" data-i18n="faq.closing2">Mais do que escrever um livro, queremos unir mulheres em uma missão de fé, amor e esperança.</p>
                <p class="faq-closing-big" style="margin-bottom:0;" data-i18n="faq.closing3">Vamos florescer com Deus, juntas!</p>
            </div>
        </div>
    </section>

    {{-- CTA participar --}}
    <section id="participar" class="section section--soft section--center">
        <div class="container--narrow reveal">
            <p class="eyebrow" data-i18n="part.eyebrow">Sua participação</p>
            <h2 data-i18n="part.title">Florescer com Deus está esperando pela sua história</h2>
            <p class="part-lead" data-i18n="part.p1">Cada mulher que faz parte desse projeto carrega uma história que outra mulher precisa ouvir. Uma história de fé, de recomeço, de cura, de milagre — escrita por você, para ela.</p>
            <p data-i18n="part.p2">Ao participar, você não apenas compartilha um testemunho. Você se torna coautora de uma missão que vai alcançar mulheres em diferentes países, idiomas e culturas.</p>
            <p data-i18n="part.p3" style="margin-bottom:36px;">Sua história merece ser lida. Há um dia no livro com o seu nome esperando por você.</p>
            <a class="button button--lg" href="{{ route('funil') }}" data-i18n="part.cta">Quero fazer parte desse projeto →</a>

            @if (! $whatsappConfigured)
                <p class="helper" style="margin-top:14px;">⚠️ Lembre-se de definir <code>WHATSAPP_GROUP_LINK</code> no arquivo .env antes de publicar.</p>
            @endif
        </div>
    </section>

    <section class="section section--center">
        <div class="container--narrow reveal">
            <h2 data-i18n="final.title">Talvez este seja o chamado de Deus para você</h2>
            <p data-i18n="final.text">Se estas palavras tocaram o seu coração, talvez seja porque chegou o momento de compartilhar a sua história, ela chegará em vários lugares do mundo, nunca saberemos as vidas que iremos alcançar, mas serão as sementes que Deus e o Espírito Santo irão cultivar, sua semente poderá fazer a vida de outra mulher florescer!</p>
            <p style="margin-top:16px;" data-i18n="final.text2">Não guarde apenas para si aquilo que Deus fez em sua vida. Em algum lugar do mundo, existe uma mulher que precisa encontrar esperança através do seu testemunho.</p>
            <p style="margin-top:16px; font-style:italic; font-weight:500;" data-i18n="final.text3">Sua história pode ser a resposta à oração de alguém. E neste livro, há um espaço especial esperando por você.</p>
            <p style="font-family:'Cormorant Garamond', Georgia, serif; font-style:italic; font-size:1.6rem; margin-top:26px; margin-bottom:4px;" data-i18n="final.sign">Com carinho,</p>
            <p style="margin-bottom:0;" data-i18n="final.author">Alexandra Sá · Idealizadora do Florescer com Deus</p>
        </div>
    </section>
</main>

<footer class="footer" data-i18n="footer.text">
    Florescer com Deus · Um projeto missionário de mulheres para alcançar mulheres do mundo todo
</footer>

<script src="{{ asset('js/florescer.js') }}"></script>
<script src="{{ asset('js/i18n.js') }}"></script>
</body>
</html>
