@extends('company.layout')
@php
  $hero = $company['hero'];
  $about = $company['about'];
  $products = $company['products'];
  $stack = $company['stack'];
  $phone = $contact['phone'];
  $wa = $contact['whatsapp'];
  $icons = [
    'code' => '<path d="M8 8l-4 4 4 4M16 8l4 4-4 4M13.5 5l-3 14"/>',
    'link' => '<path d="M10 14a4 4 0 0 0 5.7 0l3-3a4 4 0 0 0-5.7-5.7l-1 1"/><path d="M14 10a4 4 0 0 0-5.7 0l-3 3a4 4 0 0 0 5.7 5.7l1-1"/>',
    'health' => '<path d="M3 12h4l2-5 3 10 2-5h7"/>',
    'server' => '<rect x="4" y="3.5" width="16" height="7" rx="2"/><rect x="4" y="13.5" width="16" height="7" rx="2"/><path d="M8 7h.01M8 17h.01"/>',
    'shield' => '<path d="M12 3l8 3v6c0 4.5-3.4 8-8 9-4.6-1-8-4.5-8-9V6z"/><path d="M9 12l2 2 4-4"/>',
    'support' => '<circle cx="12" cy="12" r="8"/><path d="M12 8v4l3 2"/>',
  ];
@endphp

@section('content')
<header class="nav" id="nav">
  <div class="wrap nav-in">
    <a href="#top" class="brand" aria-label="{{ $company['name'] }}, ke atas">
      <svg viewBox="0 0 32 32" aria-hidden="true"><rect width="32" height="32" rx="9" fill="currentColor"/><path d="M9 11h9M9 16h14M9 21h9" stroke="#fff" stroke-width="2.6" stroke-linecap="round"/><circle cx="22" cy="11" r="2" fill="#F5A524"/></svg>
      <span>{{ $company['name'] }}</span>
    </a>
    <nav aria-label="Navigasi halaman">
      <ul class="nav-links" id="navLinks">
        @foreach ($company['nav'] as $anchor => $label)
          <li><a href="#{{ $anchor }}">{{ $label }}</a></li>
        @endforeach
      </ul>
    </nav>
    <a href="#kontak" class="btn btn-primary btn-sm nav-cta">Hubungi kami</a>
    <button class="menu" id="menuToggle" type="button" aria-label="Buka menu" aria-expanded="false" aria-controls="navLinks">
      <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
    </button>
  </div>
</header>

<main id="konten">
  {{-- ============ HERO ============ --}}
  <section class="hero" id="top">
    <div class="hero-bg" aria-hidden="true"></div>
    <div class="wrap hero-grid">
      <div class="hero-copy">
        <p class="eyebrow reveal"><span></span>{{ $hero['eyebrow'] }}</p>
        <h1 class="reveal">{{ \App\Support\Text::highlight($hero['title'], 'hl') }}</h1>
        <p class="lead reveal">{{ $hero['subtitle'] }}</p>
        <div class="actions reveal">
          <a href="#layanan" class="btn btn-primary">{{ $hero['cta_primary'] }}
            <svg viewBox="0 0 16 16" aria-hidden="true"><path d="M3 8h10M9 4l4 4-4 4"/></svg></a>
          <a href="#kontak" class="btn btn-ghost">{{ $hero['cta_secondary'] }}</a>
        </div>
        <ul class="chips reveal">
          @foreach ($hero['highlights'] as $item)<li>{{ $item }}</li>@endforeach
        </ul>
      </div>

      <div class="circuit reveal" role="img" aria-label="Ilustrasi: perangkat lunak, integrasi, infrastruktur, dan sistem kesehatan terhubung ke satu pusat">
        <svg viewBox="0 0 480 420" id="circuitArt" aria-hidden="true">
          <defs>
            <linearGradient id="trace" x1="0" x2="1"><stop offset="0" stop-color="#3B3FD8"/><stop offset="1" stop-color="#8B8EF5"/></linearGradient>
          </defs>
          <g class="traces">
            <path id="t1" d="M240 210 H170 V90 H90"/>
            <path id="t2" d="M240 210 H310 V90 H390"/>
            <path id="t3" d="M240 210 H170 V330 H90"/>
            <path id="t4" d="M240 210 H310 V330 H390"/>
            <path id="t5" d="M240 210 V40"/>
            <path id="t6" d="M240 210 V380"/>
          </g>
          <g class="flows">
            <use href="#t1"/><use href="#t2"/><use href="#t3"/><use href="#t4"/><use href="#t5"/><use href="#t6"/>
          </g>
          @foreach (['t1' => 0, 't2' => 0.7, 't3' => 1.4, 't4' => 2.1, 't5' => 0.35, 't6' => 1.75] as $id => $delay)
            <circle class="pkt" r="4"><animateMotion dur="2.8s" begin="{{ $delay }}s" repeatCount="indefinite" keyPoints="1;0" keyTimes="0;1" calcMode="linear"><mpath href="#{{ $id }}"/></animateMotion></circle>
          @endforeach
          <g class="pads">
            <circle cx="240" cy="40" r="6"/><circle cx="240" cy="380" r="6"/>
          </g>
          <g class="core">
            <rect x="196" y="166" width="88" height="88" rx="18"/>
            <path d="M210 166v-10M226 166v-10M242 166v-10M258 166v-10M274 166v-10M210 264v-10M226 264v-10M242 264v-10M258 264v-10M274 264v-10" class="pins"/>
            <text x="240" y="206" text-anchor="middle" class="core-t">EWI</text>
            <text x="240" y="226" text-anchor="middle" class="core-s">integrasi</text>
          </g>
        </svg>
        @foreach ([['Perangkat lunak', 'web & mobile', 'code', 'n1'], ['Integrasi', 'API & data', 'link', 'n2'], ['Kesehatan', 'SIMRS · BPJS · SATUSEHAT', 'health', 'n3'], ['Infrastruktur', 'server & jaringan', 'server', 'n4']] as [$t, $s, $icon, $pos])
          <div class="node {{ $pos }}"><span class="node-ico"><svg viewBox="0 0 24 24" aria-hidden="true">{!! $icons[$icon] !!}</svg></span><span><b>{{ $t }}</b><small>{{ $s }}</small></span></div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ============ TENTANG ============ --}}
  <section class="section" id="tentang">
    <div class="wrap">
      <div class="head reveal">
        <p class="label">{{ $about['label'] }}</p>
        <h2>{{ $about['title'] }}</h2>
      </div>
      <div class="about">
        <div class="about-text reveal">
          @foreach ($about['paragraphs'] as $paragraph)<p>{{ $paragraph }}</p>@endforeach
          @if ($filled($about['founder_story']))
            <blockquote class="founder">{{ $about['founder_story'] }}</blockquote>
          @endif
          @if ($filled($about['team_photo']))
            <figure class="team"><img src="{{ \App\Support\Media::url($about['team_photo']) }}" alt="Tim {{ $company['legal_name'] }}" loading="lazy"></figure>
          @endif
        </div>
        <div class="vm">
          <article class="card vision reveal">
            <p class="label">Visi</p>
            <p>{{ $about['vision'] }}</p>
          </article>
          <article class="card reveal">
            <p class="label">Misi</p>
            <ol class="mission">
              @foreach ($about['mission'] as $item)<li>{{ $item }}</li>@endforeach
            </ol>
          </article>
        </div>
      </div>
    </div>
  </section>

  {{-- ============ LAYANAN ============ --}}
  <section class="section alt" id="layanan">
    <div class="wrap">
      <div class="head head-split reveal">
        <div>
          <p class="label">{{ $company['services']['label'] }}</p>
          <h2>{{ $company['services']['title'] }}</h2>
        </div>
        <p>{{ $company['services']['text'] }}</p>
      </div>
      <div class="services">
        @foreach ($company['services']['items'] as $i => $svc)
          <article class="card service reveal">
            <span class="ico"><svg viewBox="0 0 24 24" aria-hidden="true">{!! $icons[$svc['icon']] !!}</svg></span>
            <span class="num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
            <h3>{{ $svc['title'] }}</h3>
            <p>{{ $svc['text'] }}</p>
          </article>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ============ TEKNOLOGI ============ --}}
  <section class="section stack" id="teknologi">
    <div class="wrap">
      <div class="head head-center reveal">
        <p class="label">{{ $stack['label'] }}</p>
        <h2>{{ $stack['title'] }}</h2>
        <p>{{ $stack['text'] }}</p>
      </div>
      <div class="orbit-stage reveal" aria-hidden="true">
        <div class="orbit-core"><span></span></div>
        @foreach ($stack['orbits'] as $ring => $badges)
          <div class="orbit orbit-{{ $ring + 1 }}">
            @foreach ($badges as $i => [$abbr, $name, $color])
              <span class="orbit-slot" style="--a: {{ round(360 / count($badges) * $i + $ring * 40) }}deg">
                <span class="tech-badge" style="--c: {{ $color }}" title="{{ $name }}">{{ $abbr }}</span>
              </span>
            @endforeach
          </div>
        @endforeach
      </div>
      <div class="stack-groups">
        @foreach ($stack['groups'] as $group => $items)
          <div class="stack-group reveal">
            <h3>{{ $group }}</h3>
            <ul>@foreach ($items as $item)<li>{{ $item }}</li>@endforeach</ul>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ============ PRODUK & KEMITRAAN ============ --}}
  <section class="section" id="produk">
    <div class="wrap">
      <div class="head reveal">
        <p class="label">{{ $products['label'] }}</p>
        <h2>{{ $products['title'] }}</h2>
      </div>
      <div class="products">
        <article class="product-main reveal">
          <span class="badge">{{ $products['main']['badge'] }}</span>
          <h3>{{ $products['main']['name'] }}</h3>
          <p class="tagline">{{ $products['main']['tagline'] }}</p>
          <p>{{ $products['main']['text'] }}</p>
          <ul class="ticks">
            @foreach ($products['main']['points'] as $point)<li>{{ $point }}</li>@endforeach
          </ul>
          <a href="{{ $company['main_url'] }}" class="btn btn-amber">{{ $products['main']['cta'] }}
            <svg viewBox="0 0 16 16" aria-hidden="true"><path d="M3 8h10M9 4l4 4-4 4"/></svg></a>
          <svg class="product-art" viewBox="0 0 200 200" aria-hidden="true"><path d="M20 100h40l14-34 22 70 14-36h70"/></svg>
        </article>
        <article class="card partner reveal">
          <span class="badge badge-soft">{{ $products['partner']['badge'] }}</span>
          <h3>{{ $products['partner']['name'] }}</h3>
          <p class="tagline">{{ $products['partner']['tagline'] }}</p>
          <p>{{ $products['partner']['text'] }}</p>
        </article>
      </div>

    </div>
  </section>

  {{-- ============ CARA KERJA ============ --}}
  <section class="section alt" id="cara-kerja">
    <div class="wrap">
      <div class="head reveal">
        <p class="label">{{ $company['process']['label'] }}</p>
        <h2>{{ $company['process']['title'] }}</h2>
      </div>
      <ol class="steps">
        @foreach ($company['process']['steps'] as $i => [$title, $text])
          <li class="reveal"><span class="step-num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span><h3>{{ $title }}</h3><p>{{ $text }}</p></li>
        @endforeach
      </ol>
    </div>
  </section>

  {{-- ============ MENGAPA KAMI ============ --}}
  <section class="section dark" id="mengapa">
    <div class="wrap">
      <div class="head reveal">
        <p class="label">{{ $company['why']['label'] }}</p>
        <h2>{{ $company['why']['title'] }}</h2>
      </div>
      <div class="why">
        @foreach ($company['why']['items'] as [$title, $text])
          <div class="why-item reveal"><h3>{{ $title }}</h3><p>{{ $text }}</p></div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ============ KONTAK ============ --}}
  <section class="section" id="kontak">
    <div class="wrap contact">
      <div class="reveal">
        <p class="label">{{ $company['contact_section']['label'] }}</p>
        <h2>{{ $company['contact_section']['title'] }}</h2>
        <p class="contact-lead">{{ $company['contact_section']['text'] }}</p>
        <dl class="contact-list">
          <div><dt>Telepon / WhatsApp</dt><dd><a href="https://wa.me/{{ $wa }}">{{ $phone }}</a></dd></div>
          @if ($filled($contact['email']))<div><dt>Email</dt><dd><a href="mailto:{{ $contact['email'] }}">{{ $contact['email'] }}</a></dd></div>@endif
          <div><dt>Alamat</dt><dd>{{ $contact['street'] }}, {{ $contact['city'] }}, {{ $contact['region'] }}</dd></div>
          @if ($filled($contact['hours']))<div><dt>Jam kerja</dt><dd>{{ $contact['hours'] }}</dd></div>@endif
        </dl>
      </div>
      <form class="card form reveal" id="contactForm" data-whatsapp="{{ $wa }}" data-company="{{ $company['name'] }}" novalidate>
        <div class="row2">
          <div class="field"><label for="c-nama">Nama</label><input id="c-nama" autocomplete="name" required></div>
          <div class="field"><label for="c-perusahaan">Perusahaan / instansi</label><input id="c-perusahaan" autocomplete="organization" required></div>
        </div>
        <div class="field"><label for="c-kebutuhan">Kebutuhan</label>
          <select id="c-kebutuhan">@foreach ($company['contact_section']['needs'] as $need)<option>{{ $need }}</option>@endforeach</select>
        </div>
        <div class="field"><label for="c-pesan">Pesan</label><textarea id="c-pesan" rows="4"></textarea></div>
        <p class="form-error" id="formError" role="alert" hidden>Mohon isi nama dan perusahaan Anda.</p>
        <button type="submit" class="btn btn-primary btn-block">Kirim lewat WhatsApp</button>
        <p class="hint">Pesan akan terbuka di WhatsApp dan siap dikirim.</p>
      </form>
    </div>
  </section>
</main>

<footer class="footer">
  <div class="wrap footer-in">
    <div>
      <p class="footer-name">{{ $company['legal_name'] }}</p>
      <p>{{ $contact['street'] }}, {{ $contact['city'] }}, {{ $contact['region'] }}</p>
      @if ($filled($company['nib']))<p>NIB {{ $company['nib'] }}</p>@endif
    </div>
    <div class="footer-links">
      <a href="{{ $company['main_url'] }}">Enigma Health</a>
      <a href="#layanan">Layanan</a>
      <a href="#kontak">Kontak</a>
    </div>
  </div>
  <div class="wrap footer-bottom">© {{ date('Y') }} {{ $company['legal_name'] }}</div>
</footer>
@endsection
