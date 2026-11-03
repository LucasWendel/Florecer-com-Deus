@php
    // Valor único: €10 (o Stripe converte para a moeda local no checkout).
    $valorFmt = '€ ' . number_format($valor ?? 10, 2, ',', '.');
    // Se o checkout voltou com erros de validação, abre direto na etapa 3.
    $etapaInicial = $errors->any() ? 3 : 1;
@endphp
<!doctype html>
<html lang="pt-BR" data-i18n-title="doc.funil">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>Inscrição | Florescer com Deus</title>
    <link rel="stylesheet" href="{{ asset('css/florescer.css') }}">
</head>
<body class="funnel-page">
@include('florescer.partials.lang-switcher')

<header class="topbar">
    <a class="brand brand--link" href="{{ route('home') }}"><img src="{{ asset('images/logo.png') }}" alt="Logo Florescer com Deus" class="brand-logo"><span data-i18n="brand.name">Florescer com Deus</span></a>
</header>

<main class="section funnel" data-funnel data-start-step="{{ $etapaInicial }}">
    <div class="container--narrow">
        <a class="funnel-home" href="{{ route('home') }}" data-i18n="funnel.backHome">← Voltar ao início</a>

        {{-- Barra de progresso --}}
        <div class="funnel-progress" aria-hidden="true">
            <div class="funnel-progress__track"><div class="funnel-progress__fill" data-progress-fill></div></div>
            <ol class="funnel-progress__steps">
                <li data-progress-step="1"><span class="funnel-progress__dot">1</span><span data-i18n="funnel.p1">Termos</span></li>
                <li data-progress-step="2"><span class="funnel-progress__dot">2</span><span data-i18n="funnel.p2">Seu lugar</span></li>
                <li data-progress-step="3"><span class="funnel-progress__dot">3</span><span data-i18n="funnel.p3">Pagamento</span></li>
            </ol>
        </div>

        {{-- ETAPA 1 — Termos --}}
        <section class="funnel-step" data-step="1" @if ($etapaInicial !== 1) hidden @endif>
            <p class="eyebrow" data-i18n="funnel.stepOf1">Etapa 1 de 3</p>
            <h1 class="funnel-title" data-i18n="s1.title">Antes de começar, leia e aceite os termos</h1>
            <p data-i18n="s1.intro">Queremos que você participe com tranquilidade e clareza. Leia com carinho os termos abaixo.</p>

            <div class="terms-box" tabindex="0">
                <h2 class="terms-heading" data-i18n="terms.heading">Termos de Participação — Florescer com Deus</h2>
                <p data-i18n="terms.preamble">O Florescer com Deus, no Grace Hub, nasceu do desejo de Alexandra Sá Fagundes de reunir histórias reais de mulheres de diferentes lugares do mundo — respostas de oração, milagres, recomeços e experiências do cotidiano com Deus — e transformá-las em mensagens de fé, esperança e encorajamento. Ao se inscrever, você concorda com os termos a seguir:</p>
                <p data-i18n-html="terms.t1"><strong>1. Autorização de compartilhamento.</strong> A participante autoriza, de forma gratuita, o uso e o compartilhamento de sua história/testemunho no livro Florescer com Deus e em materiais de divulgação do projeto.</p>
                <p data-i18n-html="terms.t2"><strong>2. Data de publicação.</strong> A história será publicada no livro na data correspondente ao aniversário da participante, compondo um dos 365 dias da obra.</p>
                <p data-i18n-html="terms.t3"><strong>3. Veracidade e autoria.</strong> A participante declara que o conteúdo compartilhado é verídico, baseado em sua própria experiência, e de sua autoria, sem violar direitos de terceiros.</p>
                <p data-i18n-html="terms.t4"><strong>4. Edição do texto.</strong> A Grace Hub e Alexandra Sá Fagundes poderão revisar e editar o texto para fins de publicação (ortografia, tamanho, clareza e padronização), sempre preservando o sentido original do testemunho.</p>
                <p data-i18n-html="terms.t5"><strong>5. Participação voluntária e valor de custeio.</strong> A participação é voluntária. O valor cobrado destina-se exclusivamente ao custeio do projeto missionário (confecção do livro, site, hospedagem e manutenção) e não representa compra de espaço publicitário.</p>
                <p data-i18n-html="terms.t6"><strong>6. Dados pessoais.</strong> Nome, e-mail e WhatsApp informados serão utilizados apenas para contato relacionado ao projeto Florescer com Deus, não sendo vendidos nem compartilhados com terceiros para outras finalidades.</p>
                <p data-i18n-html="terms.t7"><strong>7. Exemplar digital.</strong> Após a publicação, a participante receberá um exemplar digital do livro Florescer com Deus.</p>
                <p data-i18n-html="terms.t8" style="margin-bottom:0;"><strong>8. Aceite.</strong> Ao marcar a opção abaixo e prosseguir com a inscrição, a participante declara ter lido, compreendido e aceito integralmente estes Termos de Participação.</p>
            </div>

            <label class="terms-check">
                <input type="checkbox" data-terms-checkbox @if ($etapaInicial === 3) checked @endif>
                <span data-i18n="s1.accept">Li e aceito os Termos de Participação</span>
            </label>

            <div class="funnel-actions">
                <button type="button" class="button button--lg" data-go="2" data-terms-next disabled data-i18n="s1.next">Continuar →</button>
            </div>
        </section>

        {{-- ETAPA 2 — Momento de dopamina --}}
        <section class="funnel-step funnel-step--dream" data-step="2" hidden>
            <p class="eyebrow" data-i18n="funnel.stepOf2">Etapa 2 de 3</p>
            <h1 class="funnel-title funnel-title--big" data-i18n="s2.title">Sua história já tem um lugar reservado no livro ✨</h1>
            <p class="funnel-impact" data-i18n="s2.impact">Você está prestes a se tornar parte de algo eterno.</p>

            <div class="benefits">
                <article class="benefit">
                    <div class="benefit__icon" aria-hidden="true">📖</div>
                    <h3 data-i18n="s2.b1t">Sua história publicada no livro Florescer com Deus</h3>
                    <p data-i18n="s2.b1p">O que Deus fez na sua vida será registrado e guardado para inspirar gerações.</p>
                </article>
                <article class="benefit">
                    <div class="benefit__icon" aria-hidden="true">🌍</div>
                    <h3 data-i18n="s2.b2t">Sua mensagem alcançará mulheres em todo o mundo</h3>
                    <p data-i18n="s2.b2p">Um testemunho pode atravessar fronteiras e chegar a quem precisa de esperança hoje.</p>
                </article>
                <article class="benefit">
                    <div class="benefit__icon" aria-hidden="true">🎂</div>
                    <h3 data-i18n="s2.b3t">Publicada no seu aniversário — um presente especial</h3>
                    <p data-i18n="s2.b3p">O dia em que você nasceu se torna o dia em que sua fé floresce na vida de outra mulher.</p>
                </article>
            </div>

            <blockquote class="funnel-quote" data-i18n="s2.quote">“Aquilo que Deus fez em sua vida pode trazer esperança para alguém que ainda está esperando pela própria resposta.”</blockquote>
            <p class="funnel-belong" data-i18n="s2.belong">Cada história é única. A sua também é.</p>

            <div class="funnel-actions">
                <button type="button" class="button button--lg" data-go="3" data-i18n="s2.next">Quero garantir minha participação →</button>
                <button type="button" class="funnel-back" data-go="1" data-i18n="funnel.back">← Voltar</button>
            </div>
        </section>

        {{-- ETAPA 3 — Pagamento --}}
        <section class="funnel-step" data-step="3" @if ($etapaInicial !== 3) hidden @endif>
            <p class="eyebrow" data-i18n="funnel.stepOf3">Etapa 3 de 3</p>
            <h1 class="funnel-title" data-i18n="s3.title">Última etapa — Garanta sua participação</h1>
            <p class="funnel-price">
                <span data-i18n="s3.subtitle" data-i18n-valor="{{ $valorFmt }}">Valor único de participação: {{ $valorFmt }}</span>
            </p>

            <div class="pricing funnel-form">
                @if ($errors->has('checkout'))
                    <div class="alert alert-error">{{ $errors->first('checkout') }}</div>
                @endif

                <form action="{{ route('checkout') }}" method="post" novalidate>
                    @csrf
                    <input type="hidden" name="currency" id="checkout_currency" value="{{ $currency ?? 'eur' }}">
                    <div class="form-group">
                        <label for="customer_name" class="form-label"><span data-i18n="s3.name">Seu nome completo</span> <span class="form-required">*</span></label>
                        <input type="text" class="form-input {{ $errors->has('customer_name') ? 'form-input--error' : '' }}" name="customer_name" id="customer_name" placeholder="Maria da Silva" data-i18n-placeholder="s3.namePh" value="{{ old('customer_name') }}" autocomplete="name" required>
                        @error('customer_name')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label"><span data-i18n="s3.whatsapp">WhatsApp</span> <span class="form-required">*</span></label>
                        <div class="phone-wrap">
                            <select id="country_code" name="country_code" class="form-select phone-flag" autocomplete="tel-country-code" data-old="{{ old('country_code', '+55') }}">
                                {{-- Países mais comuns no topo --}}
                                <option value="+55" data-flag="🇧🇷">🇧🇷 +55</option>
                                <option value="+1" data-flag="🇺🇸">🇺🇸 +1</option>
                                <option value="+351" data-flag="🇵🇹">🇵🇹 +351</option>
                                <option value="+34" data-flag="🇪🇸">🇪🇸 +34</option>
                                <option value="+49" data-flag="🇩🇪">🇩🇪 +49</option>
                                <option value="+44" data-flag="🇬🇧">🇬🇧 +44</option>
                                <option value="+33" data-flag="🇫🇷">🇫🇷 +33</option>
                                <option value="+39" data-flag="🇮🇹">🇮🇹 +39</option>
                                <option value="+54" data-flag="🇦🇷">🇦🇷 +54</option>
                                <option value="+57" data-flag="🇨🇴">🇨🇴 +57</option>
                                <option value="+56" data-flag="🇨🇱">🇨🇱 +56</option>
                                <option value="+598" data-flag="🇺🇾">🇺🇾 +598</option>
                                <option value="+595" data-flag="🇵🇾">🇵🇾 +595</option>
                                <option value="+591" data-flag="🇧🇴">🇧🇴 +591</option>
                                <option value="+58" data-flag="🇻🇪">🇻🇪 +58</option>
                                <option value="+593" data-flag="🇪🇨">🇪🇨 +593</option>
                                <option value="+51" data-flag="🇵🇪">🇵🇪 +51</option>
                                <option value="+507" data-flag="🇵🇦">🇵🇦 +507</option>
                                <option value="+506" data-flag="🇨🇷">🇨🇷 +506</option>
                                <option value="+502" data-flag="🇬🇹">🇬🇹 +502</option>
                                <option value="+503" data-flag="🇸🇻">🇸🇻 +503</option>
                                <option value="+504" data-flag="🇭🇳">🇭🇳 +504</option>
                                <option value="+505" data-flag="🇳🇮">🇳🇮 +505</option>
                                <option value="+53" data-flag="🇨🇺">🇨🇺 +53</option>
                                <option value="+1809" data-flag="🇩🇴">🇩🇴 +1809</option>
                                <option value="+52" data-flag="🇲🇽">🇲🇽 +52</option>
                                <option value="+61" data-flag="🇦🇺">🇦🇺 +61</option>
                                <option value="+81" data-flag="🇯🇵">🇯🇵 +81</option>
                                <option value="+82" data-flag="🇰🇷">🇰🇷 +82</option>
                                <option value="+86" data-flag="🇨🇳">🇨🇳 +86</option>
                                <option value="+91" data-flag="🇮🇳">🇮🇳 +91</option>
                                <option value="+27" data-flag="🇿🇦">🇿🇦 +27</option>
                                <option value="+234" data-flag="🇳🇬">🇳🇬 +234</option>
                                <option value="+254" data-flag="🇰🇪">🇰🇪 +254</option>
                                <option value="+244" data-flag="🇦🇴">🇦🇴 +244</option>
                                <option value="+258" data-flag="🇲🇿">🇲🇿 +258</option>
                                <option value="+239" data-flag="🇸🇹">🇸🇹 +239</option>
                                <option value="+238" data-flag="🇨🇻">🇨🇻 +238</option>
                                <option value="+245" data-flag="🇬🇼">🇬🇼 +245</option>
                                <option disabled>──────────</option>
                                {{-- Demais países em ordem alfabética --}}
                                <option value="+93">🇦🇫 Afeganistão +93</option>
                                <option value="+355">🇦🇱 Albânia +355</option>
                                <option value="+213">🇩🇿 Argélia +213</option>
                                <option value="+376">🇦🇩 Andorra +376</option>
                                <option value="+244">🇦🇴 Angola +244</option>
                                <option value="+1264">🇦🇮 Anguilla +1264</option>
                                <option value="+1268">🇦🇬 Antígua e Barbuda +1268</option>
                                <option value="+966">🇸🇦 Arábia Saudita +966</option>
                                <option value="+374">🇦🇲 Armênia +374</option>
                                <option value="+297">🇦🇼 Aruba +297</option>
                                <option value="+43">🇦🇹 Áustria +43</option>
                                <option value="+994">🇦🇿 Azerbaijão +994</option>
                                <option value="+1242">🇧🇸 Bahamas +1242</option>
                                <option value="+880">🇧🇩 Bangladesh +880</option>
                                <option value="+1246">🇧🇧 Barbados +1246</option>
                                <option value="+32">🇧🇪 Bélgica +32</option>
                                <option value="+501">🇧🇿 Belize +501</option>
                                <option value="+229">🇧🇯 Benim +229</option>
                                <option value="+975">🇧🇹 Butão +975</option>
                                <option value="+375">🇧🇾 Bielorrússia +375</option>
                                <option value="+387">🇧🇦 Bósnia e Herzegovina +387</option>
                                <option value="+267">🇧🇼 Botswana +267</option>
                                <option value="+673">🇧🇳 Brunei +673</option>
                                <option value="+359">🇧🇬 Bulgária +359</option>
                                <option value="+226">🇧🇫 Burkina Faso +226</option>
                                <option value="+257">🇧🇮 Burundi +257</option>
                                <option value="+855">🇰🇭 Camboja +855</option>
                                <option value="+237">🇨🇲 Camarões +237</option>
                                <option value="+1">🇨🇦 Canadá +1</option>
                                <option value="+236">🇨🇫 República Centro-Africana +236</option>
                                <option value="+235">🇹🇩 Chade +235</option>
                                <option value="+420">🇨🇿 Chéquia +420</option>
                                <option value="+357">🇨🇾 Chipre +357</option>
                                <option value="+65">🇸🇬 Singapura +65</option>
                                <option value="+269">🇰🇲 Comores +269</option>
                                <option value="+242">🇨🇬 Congo +242</option>
                                <option value="+243">🇨🇩 Congo RD +243</option>
                                <option value="+850">🇰🇵 Coreia do Norte +850</option>
                                <option value="+225">🇨🇮 Costa do Marfim +225</option>
                                <option value="+385">🇭🇷 Croácia +385</option>
                                <option value="+45">🇩🇰 Dinamarca +45</option>
                                <option value="+253">🇩🇯 Djibouti +253</option>
                                <option value="+20">🇪🇬 Egito +20</option>
                                <option value="+503">🇸🇻 El Salvador +503</option>
                                <option value="+971">🇦🇪 Emirados Árabes +971</option>
                                <option value="+291">🇪🇷 Eritreia +291</option>
                                <option value="+421">🇸🇰 Eslováquia +421</option>
                                <option value="+386">🇸🇮 Eslovênia +386</option>
                                <option value="+372">🇪🇪 Estônia +372</option>
                                <option value="+251">🇪🇹 Etiópia +251</option>
                                <option value="+679">🇫🇯 Fiji +679</option>
                                <option value="+63">🇵🇭 Filipinas +63</option>
                                <option value="+358">🇫🇮 Finlândia +358</option>
                                <option value="+241">🇬🇦 Gabão +241</option>
                                <option value="+220">🇬🇲 Gâmbia +220</option>
                                <option value="+233">🇬🇭 Gana +233</option>
                                <option value="+995">🇬🇪 Geórgia +995</option>
                                <option value="+350">🇬🇮 Gibraltar +350</option>
                                <option value="+30">🇬🇷 Grécia +30</option>
                                <option value="+1473">🇬🇩 Granada +1473</option>
                                <option value="+502">🇬🇹 Guatemala +502</option>
                                <option value="+224">🇬🇳 Guiné +224</option>
                                <option value="+240">🇬🇶 Guiné Equatorial +240</option>
                                <option value="+592">🇬🇾 Guiana +592</option>
                                <option value="+509">🇭🇹 Haiti +509</option>
                                <option value="+36">🇭🇺 Hungria +36</option>
                                <option value="+967">🇾🇪 Iémen +967</option>
                                <option value="+964">🇮🇶 Iraque +964</option>
                                <option value="+98">🇮🇷 Irã +98</option>
                                <option value="+353">🇮🇪 Irlanda +353</option>
                                <option value="+354">🇮🇸 Islândia +354</option>
                                <option value="+972">🇮🇱 Israel +972</option>
                                <option value="+1876">🇯🇲 Jamaica +1876</option>
                                <option value="+962">🇯🇴 Jordânia +962</option>
                                <option value="+7">🇰🇿 Cazaquistão +7</option>
                                <option value="+686">🇰🇮 Kiribati +686</option>
                                <option value="+965">🇰🇼 Kuwait +965</option>
                                <option value="+856">🇱🇦 Laos +856</option>
                                <option value="+371">🇱🇻 Letônia +371</option>
                                <option value="+961">🇱🇧 Líbano +961</option>
                                <option value="+266">🇱🇸 Lesoto +266</option>
                                <option value="+231">🇱🇷 Libéria +231</option>
                                <option value="+218">🇱🇾 Líbia +218</option>
                                <option value="+423">🇱🇮 Liechtenstein +423</option>
                                <option value="+370">🇱🇹 Lituânia +370</option>
                                <option value="+352">🇱🇺 Luxemburgo +352</option>
                                <option value="+389">🇲🇰 Macedônia do Norte +389</option>
                                <option value="+261">🇲🇬 Madagascar +261</option>
                                <option value="+265">🇲🇼 Malawi +265</option>
                                <option value="+60">🇲🇾 Malásia +60</option>
                                <option value="+960">🇲🇻 Maldivas +960</option>
                                <option value="+223">🇲🇱 Mali +223</option>
                                <option value="+356">🇲🇹 Malta +356</option>
                                <option value="+212">🇲🇦 Marrocos +212</option>
                                <option value="+222">🇲🇷 Mauritânia +222</option>
                                <option value="+230">🇲🇺 Maurícias +230</option>
                                <option value="+691">🇫🇲 Micronésia +691</option>
                                <option value="+373">🇲🇩 Moldávia +373</option>
                                <option value="+377">🇲🇨 Mônaco +377</option>
                                <option value="+976">🇲🇳 Mongólia +976</option>
                                <option value="+382">🇲🇪 Montenegro +382</option>
                                <option value="+1664">🇲🇸 Montserrat +1664</option>
                                <option value="+264">🇳🇦 Namíbia +264</option>
                                <option value="+977">🇳🇵 Nepal +977</option>
                                <option value="+505">🇳🇮 Nicarágua +505</option>
                                <option value="+227">🇳🇪 Níger +227</option>
                                <option value="+47">🇳🇴 Noruega +47</option>
                                <option value="+64">🇳🇿 Nova Zelândia +64</option>
                                <option value="+968">🇴🇲 Omã +968</option>
                                <option value="+92">🇵🇰 Paquistão +92</option>
                                <option value="+970">🇵🇸 Palestina +970</option>
                                <option value="+675">🇵🇬 Papua Nova Guiné +675</option>
                                <option value="+974">🇶🇦 Qatar +974</option>
                                <option value="+40">🇷🇴 Romênia +40</option>
                                <option value="+250">🇷🇼 Ruanda +250</option>
                                <option value="+7">🇷🇺 Rússia +7</option>
                                <option value="+685">🇼🇸 Samoa +685</option>
                                <option value="+1869">🇰🇳 São Cristóvão e Nevis +1869</option>
                                <option value="+1758">🇱🇨 Santa Lúcia +1758</option>
                                <option value="+1784">🇻🇨 São Vicente e Granadinas +1784</option>
                                <option value="+378">🇸🇲 San Marino +378</option>
                                <option value="+221">🇸🇳 Senegal +221</option>
                                <option value="+381">🇷🇸 Sérvia +381</option>
                                <option value="+248">🇸🇨 Seychelles +248</option>
                                <option value="+232">🇸🇱 Serra Leoa +232</option>
                                <option value="+963">🇸🇾 Síria +963</option>
                                <option value="+252">🇸🇴 Somália +252</option>
                                <option value="+94">🇱🇰 Sri Lanka +94</option>
                                <option value="+268">🇸🇿 Suazilândia +268</option>
                                <option value="+249">🇸🇩 Sudão +249</option>
                                <option value="+211">🇸🇸 Sudão do Sul +211</option>
                                <option value="+46">🇸🇪 Suécia +46</option>
                                <option value="+41">🇨🇭 Suíça +41</option>
                                <option value="+66">🇹🇭 Tailândia +66</option>
                                <option value="+886">🇹🇼 Taiwan +886</option>
                                <option value="+255">🇹🇿 Tanzânia +255</option>
                                <option value="+670">🇹🇱 Timor-Leste +670</option>
                                <option value="+228">🇹🇬 Togo +228</option>
                                <option value="+676">🇹🇴 Tonga +676</option>
                                <option value="+1868">🇹🇹 Trinidad e Tobago +1868</option>
                                <option value="+216">🇹🇳 Tunísia +216</option>
                                <option value="+993">🇹🇲 Turcomenistão +993</option>
                                <option value="+90">🇹🇷 Turquia +90</option>
                                <option value="+688">🇹🇻 Tuvalu +688</option>
                                <option value="+380">🇺🇦 Ucrânia +380</option>
                                <option value="+256">🇺🇬 Uganda +256</option>
                                <option value="+598">🇺🇾 Uruguai +598</option>
                                <option value="+998">🇺🇿 Uzbequistão +998</option>
                                <option value="+678">🇻🇺 Vanuatu +678</option>
                                <option value="+58">🇻🇪 Venezuela +58</option>
                                <option value="+84">🇻🇳 Vietnã +84</option>
                                <option value="+260">🇿🇲 Zâmbia +260</option>
                                <option value="+263">🇿🇼 Zimbábue +263</option>
                            </select>
                            <script>(function(){var s=document.getElementById('country_code');var v=s.getAttribute('data-old');for(var i=0;i<s.options.length;i++){if(s.options[i].value===v){s.selectedIndex=i;break;}}})();</script>
                            <input type="tel" class="form-input phone-number {{ $errors->has('customer_whatsapp') ? 'form-input--error' : '' }}" name="customer_whatsapp" id="customer_whatsapp" placeholder="11 99999-9999" data-i18n-placeholder="s3.whatsappPh" value="{{ old('customer_whatsapp') }}" autocomplete="tel-national" required>
                        </div>
                        @error('customer_whatsapp')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="customer_email" class="form-label"><span data-i18n="s3.email">Seu e-mail</span> <span class="form-required">*</span></label>
                        <input type="email" class="form-input {{ $errors->has('customer_email') ? 'form-input--error' : '' }}" name="customer_email" id="customer_email" placeholder="voce@exemplo.com" data-i18n-placeholder="s3.emailPh" value="{{ old('customer_email') }}" autocomplete="email" required>
                        @error('customer_email')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                    <button type="submit" class="button button--lg button--block" data-i18n="s3.submit">Finalizar inscrição e pagar</button>
                </form>
                <p class="helper" style="margin:16px 0 0;" data-i18n="s3.secure">🔒 Pagamento seguro processado pela Stripe. Após a confirmação, você recebe o link do grupo privado no WhatsApp.</p>
            </div>

            <div class="funnel-actions">
                <button type="button" class="funnel-back" data-go="2" data-i18n="funnel.back">← Voltar</button>
            </div>
        </section>
    </div>
</main>

<footer class="footer" data-i18n="footer.text">
    Florescer com Deus · Um projeto missionário de mulheres para alcançar mulheres do mundo todo
</footer>

<script src="{{ asset('js/funil.js') }}"></script>
<script src="{{ asset('js/i18n.js') }}"></script>
</body>
</html>
