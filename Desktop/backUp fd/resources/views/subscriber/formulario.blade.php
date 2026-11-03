<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Formulário de Coautora · Florescer com Deus</title>
<link rel="stylesheet" href="{{ asset('css/florescer.css') }}">
</head>
<body class="auth-page">

<header class="topbar topbar--area">
    <a class="brand brand--link" href="{{ route('assinante.area') }}">
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
        <p class="eyebrow" data-i18n="form.eyebrow">Formulário de Coautora</p>
        <h1 data-i18n="form.title">Formulário de Coautora 🌷</h1>
        <p data-i18n="form.subtitle">Preencha com atenção todos os campos obrigatórios.</p>
    </div>

    {{-- JÁ ENVIADO --}}
    @if($submission || session('success') || session('already_sent'))
        <div class="form-success-box">
            <div class="form-success-icon">✅</div>
            <h2 data-i18n="form.sent">Formulário já enviado</h2>
            <p data-i18n="form.sent.info">Você já enviou o formulário de coautora. Se precisar de ajuda, entre em contato com a organização pelo grupo do WhatsApp.</p>
            <a class="button" href="{{ route('assinante.area') }}" data-i18n="form.back">← Voltar para minha área</a>
        </div>
    @else

    @if($errors->any())
        <div class="auth-alert" style="max-width:720px;margin:0 auto 20px;">
            <strong data-i18n="form.errors">Por favor, corrija os erros abaixo:</strong>
            <ul style="margin:6px 0 0 18px;">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('assinante.enviar-formulario') }}"
          enctype="multipart/form-data" class="form-coautora">
        @csrf

        <p class="form-required-note" data-i18n="form.required">Campos com * são obrigatórios.</p>

        {{-- SEÇÃO: DADOS PESSOAIS --}}
        <fieldset class="form-section">
            <legend class="form-section__title" data-i18n="form.sec1">Dados Pessoais</legend>

            <div class="form-group">
                <label class="auth-label" for="full_name" data-i18n="form.f1">Nome Completo *</label>
                <input class="auth-input" id="full_name" name="full_name" required value="{{ old('full_name') }}">
            </div>

            <div class="form-group">
                <label class="auth-label" for="published_name" data-i18n="form.f2">Nome a ser publicado *</label>
                <input class="auth-input" id="published_name" name="published_name" required value="{{ old('published_name') }}">
            </div>

            <div class="form-group">
                <label class="auth-label" for="email" data-i18n="form.f3">E-mail *</label>
                <input class="auth-input" type="email" id="email" name="email" required value="{{ old('email', $order->customer_email) }}">
            </div>

            <div class="form-group">
                <label class="auth-label" for="phone" data-i18n="form.f4">Telefone *</label>
                <input class="auth-input" id="phone" name="phone" required value="{{ old('phone', $order->customer_whatsapp) }}" placeholder="+55 61 99999-9999">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="auth-label" for="country_birth" data-i18n="form.f5">País de Nascimento *</label>
                    <input class="auth-input" id="country_birth" name="country_birth" required value="{{ old('country_birth') }}">
                </div>
                <div class="form-group">
                    <label class="auth-label" for="country_current" data-i18n="form.f6">País Atual *</label>
                    <input class="auth-input" id="country_current" name="country_current" required value="{{ old('country_current') }}">
                </div>
            </div>

            <div class="form-group">
                <label class="auth-label" for="profession" data-i18n="form.f7">Profissão ou Vocação *</label>
                <input class="auth-input" id="profession" name="profession" required value="{{ old('profession') }}">
            </div>

            <div class="form-group">
                <label class="auth-label" for="birthday" data-i18n="form.f9">Data do Aniversário (Dia e Mês) *</label>
                <input class="auth-input" id="birthday" name="birthday" required value="{{ old('birthday') }}" placeholder="Ex: 15 de março" data-i18n-placeholder="form.f9.ph">
            </div>
        </fieldset>

        {{-- SEÇÃO: MINI BIO --}}
        <fieldset class="form-section">
            <legend class="form-section__title" data-i18n="form.sec2">Mini Bio</legend>
            <div class="form-group">
                <label class="auth-label" for="mini_bio" data-i18n="form.f8">Breve informação sobre sua caminhada de fé (Limite: 60 palavras) *</label>
                <textarea class="auth-input form-textarea" id="mini_bio" name="mini_bio" required rows="5" data-word-limit="60">{{ old('mini_bio') }}</textarea>
                <span class="form-wordcount"><span id="mini_bio_count">0</span> / 60 <span data-i18n="form.words">palavras</span></span>
            </div>
        </fieldset>

        {{-- SEÇÃO: TESTEMUNHO --}}
        <fieldset class="form-section">
            <legend class="form-section__title" data-i18n="form.sec3">Testemunho</legend>

            <div class="form-group">
                <label class="auth-label" for="testimony_title" data-i18n="form.f10">Título do Testemunho (Opcional)</label>
                <input class="auth-input" id="testimony_title" name="testimony_title" value="{{ old('testimony_title') }}">
            </div>

            <div class="form-group">
                <label class="auth-label" data-i18n="form.f11.label">Arquivo do Testemunho – formato Word (.docx) *</label>
                <div class="form-hint" data-i18n-html="form.f11.hint">Escreva com naturalidade e sinceridade. Sua experiência é mais importante do que frases elaboradas. Escolha uma história central; evite contar toda a sua trajetória em 250 palavras. Use parágrafos curtos, revise nomes e datas e evite abreviações ou excesso de citações. Se mencionar outras pessoas, respeite a privacidade delas e não inclua informações pessoais sem autorização. Ao citar versículos bíblicos, informe o livro, capítulo, versículo e a tradução utilizada. Envie em formato Word (.docx).</div>
                <input class="auth-input form-file" type="file" id="testimony_file" name="testimony_file" required
                       accept=".doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                <span class="form-hint-sm" data-i18n="form.max10">Máximo 10 MB</span>
            </div>
        </fieldset>

        {{-- SEÇÃO: FOTO --}}
        <fieldset class="form-section">
            <legend class="form-section__title" data-i18n="form.sec4">Foto</legend>
            <div class="form-group">
                <label class="auth-label" data-i18n="form.f12">Foto – Retrato individual, boa iluminação, sem filtros excessivos *</label>
                <input class="auth-input form-file" type="file" id="photo_file" name="photo_file" required
                       accept="image/jpeg,image/png,image/webp,.jpg,.jpeg,.png,.webp">
                <span class="form-hint-sm" data-i18n="form.max10photo">Máximo 10 MB · JPG, PNG ou WEBP</span>
                <div id="photo_preview" class="form-photo-preview" style="display:none;">
                    <img id="photo_img" src="" alt="Pré-visualização">
                </div>
            </div>
        </fieldset>

        {{-- SEÇÃO: PREFERÊNCIAS --}}
        <fieldset class="form-section">
            <legend class="form-section__title" data-i18n="form.sec5">Preferências</legend>

            <div class="form-group">
                <label class="auth-label" data-i18n="form.f13">Idioma preferido para comunicação *</label>
                <div class="form-radios">
                    <label class="form-radio"><input type="radio" name="language_pref" value="pt" {{ old('language_pref','pt')==='pt'?'checked':'' }} required> <span data-i18n="form.opt.pt">Português</span></label>
                    <label class="form-radio"><input type="radio" name="language_pref" value="en" {{ old('language_pref')==='en'?'checked':'' }}> <span data-i18n="form.opt.en">Inglês</span></label>
                    <label class="form-radio"><input type="radio" name="language_pref" value="es" {{ old('language_pref')==='es'?'checked':'' }}> <span data-i18n="form.opt.es">Espanhol</span></label>
                </div>
            </div>

            <div class="form-group">
                <label class="auth-label" data-i18n="form.f14">Você autoriza a divulgação do seu nome e testemunho em nossas redes sociais para promover o livro? *</label>
                <div class="form-radios">
                    <label class="form-radio"><input type="radio" name="social_auth" value="yes" {{ old('social_auth')==='yes'?'checked':'' }} required> <span data-i18n="form.opt.yes">Sim</span></label>
                    <label class="form-radio"><input type="radio" name="social_auth" value="no" {{ old('social_auth')==='no'?'checked':'' }}> <span data-i18n="form.opt.no">Não</span></label>
                </div>
            </div>

            <div class="form-group">
                <label class="auth-label" for="how_found" data-i18n="form.f15">Como você soube deste projeto? *</label>
                <select class="auth-input" id="how_found" name="how_found" required>
                    <option value="" disabled {{ old('how_found')===null?'selected':'' }} data-i18n="form.choose">— selecione —</option>
                    <option value="social" {{ old('how_found')==='social'?'selected':'' }} data-i18n="form.opt.social">Redes Sociais</option>
                    <option value="friend" {{ old('how_found')==='friend'?'selected':'' }} data-i18n="form.opt.friend">Amigo ou Familiar</option>
                    <option value="church" {{ old('how_found')==='church'?'selected':'' }} data-i18n="form.opt.church">Igreja</option>
                    <option value="invite" {{ old('how_found')==='invite'?'selected':'' }} data-i18n="form.opt.invite">Convite Pessoal da Idealizadora</option>
                    <option value="other" {{ old('how_found')==='other'?'selected':'' }} data-i18n="form.opt.other">Outro</option>
                </select>
            </div>
        </fieldset>

        {{-- SEÇÃO: OPCIONAL --}}
        <fieldset class="form-section">
            <legend class="form-section__title" data-i18n="form.sec6">Opcional</legend>

            <div class="form-group">
                <label class="auth-label" data-i18n="form.f16">Qual aspecto da sua caminhada de fé você mais deseja compartilhar?</label>
                <div class="form-checks">
                    @php $aspects = (array) old('faith_aspects', []); @endphp
                    <label class="form-check"><input type="checkbox" name="faith_aspects[]" value="overcoming" {{ in_array('overcoming',$aspects)?'checked':'' }}> <span data-i18n="form.opt.overcoming">Superação de adversidades</span></label>
                    <label class="form-check"><input type="checkbox" name="faith_aspects[]" value="growth"     {{ in_array('growth',$aspects)?'checked':'' }}> <span data-i18n="form.opt.growth">Crescimento espiritual</span></label>
                    <label class="form-check"><input type="checkbox" name="faith_aspects[]" value="purpose"   {{ in_array('purpose',$aspects)?'checked':'' }}> <span data-i18n="form.opt.purpose">Encontrando propósito</span></label>
                    <label class="form-check"><input type="checkbox" name="faith_aspects[]" value="service"   {{ in_array('service',$aspects)?'checked':'' }}> <span data-i18n="form.opt.service">Atos de serviço</span></label>
                    <label class="form-check"><input type="checkbox" name="faith_aspects[]" value="prayer"    {{ in_array('prayer',$aspects)?'checked':'' }}> <span data-i18n="form.opt.prayer">Transformação pela oração</span></label>
                </div>
            </div>

            <div class="form-group">
                <label class="auth-label" data-i18n="form.f17">Tem interesse em participar de futuros eventos ou sessões ao vivo sobre o lançamento do livro?</label>
                <div class="form-radios">
                    <label class="form-radio"><input type="radio" name="future_events" value="yes"   {{ old('future_events')==='yes'?'checked':'' }}> <span data-i18n="form.opt.yes">Sim</span></label>
                    <label class="form-radio"><input type="radio" name="future_events" value="maybe" {{ old('future_events')==='maybe'?'checked':'' }}> <span data-i18n="form.opt.maybe">Talvez</span></label>
                    <label class="form-radio"><input type="radio" name="future_events" value="no"    {{ old('future_events')==='no'?'checked':'' }}> <span data-i18n="form.opt.no">Não</span></label>
                </div>
            </div>

            <div class="form-group">
                <label class="auth-label" data-i18n="form.f18">Qual é o seu nível de entusiasmo para participar desta obra coletiva?</label>
                <div class="form-scale">
                    <span class="form-scale__lo" data-i18n="form.scale.lo">Baixo</span>
                    @for ($i = 1; $i <= 5; $i++)
                        <label class="form-scale__item">
                            <input type="radio" name="enthusiasm" value="{{ $i }}" {{ old('enthusiasm')==$i?'checked':'' }}>
                            <span>{{ $i }}</span>
                        </label>
                    @endfor
                    <span class="form-scale__hi" data-i18n="form.scale.hi">Alto</span>
                </div>
            </div>
        </fieldset>

        <div style="text-align:center; margin-top:10px;">
            <button class="button button--lg" type="submit" data-i18n="form.submit">Enviar formulário 🌷</button>
        </div>
    </form>
    @endif
</main>

<script src="{{ asset('js/i18n.js') }}"></script>
<script>
// Contador de palavras mini bio
(function(){
    var ta=document.getElementById('mini_bio'); if(!ta)return;
    function count(){var w=ta.value.trim().split(/\s+/).filter(Boolean).length; document.getElementById('mini_bio_count').textContent=w;}
    ta.addEventListener('input',count); count();
})();
// Pré-visualização de foto
(function(){
    var f=document.getElementById('photo_file'); if(!f)return;
    f.addEventListener('change',function(){
        if(!f.files||!f.files[0])return;
        var r=new FileReader(); r.onload=function(e){
            document.getElementById('photo_img').src=e.target.result;
            document.getElementById('photo_preview').style.display='block';
        }; r.readAsDataURL(f.files[0]);
    });
})();
</script>
</body>
</html>
