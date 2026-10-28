@extends('layouts.app')
@php
  $badges = \App\Models\Setting::lines('hero_badges');
  $logos = \App\Models\Setting::lines('logos_items');
  $ribbon = \App\Models\Setting::lines('ribbon_items');
  $stats = \App\Models\Setting::pairs('stats');
  $steps = \App\Models\Setting::pairs('process_steps');
  $hero = $services->firstWhere('badge', 'Layanan utama') ?? $services->first();
@endphp

@section('content')

{{-- ============ BANNER ============ --}}
<section class="banner ecg-paper">
  <div class="wrap banner-grid">
    <div class="banner-copy">
      @if (count($badges))
        <span class="eyebrow reveal">@include('partials.icon', ['name' => 'pulse']){{ $badges[0] }}</span>
      @endif
      <h1 class="reveal">{{ \App\Support\Text::highlight($set('hero_title'), 'banner-grad') }}</h1>
      <p class="banner-sub reveal">{{ $set('hero_subtitle') }}</p>
      <div class="banner-actions reveal">
        <a href="{{ route('contact') }}" class="bbtn bbtn-fill">{{ $set('hero_cta_primary', 'Konsultasi gratis') }} <svg viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
        <a href="{{ route('services.index') }}" class="bbtn bbtn-line">{{ $set('hero_cta_secondary', 'Lihat layanan') }}</a>
      </div>
      @if (count($badges) > 1)
      <ul class="banner-badge reveal">
        @foreach (array_slice($badges, 1) as $badge)
          <li>@include('partials.icon', ['name' => 'check']){{ $badge }}</li>
        @endforeach
      </ul>
      @endif
    </div>

    <div class="monitor reveal" role="img" aria-label="Ilustrasi panel status: SIMRS terhubung ke BPJS Kesehatan, SATUSEHAT, laboratorium, farmasi, serta kasir dan klaim">
      <div class="mon-head"><span><i class="live"></i>Status integrasi</span><span>SIMRS · 24/7</span></div>
      <div class="mon-screen">
        <span class="mon-bpm">♥ ONLINE</span>
        <svg class="ecg" viewBox="0 0 600 120" preserveAspectRatio="none" aria-hidden="true">
          <defs><path id="ecgBeat" d="M0 70H90q8-10 16 0h24l6 10 10-58 10 70 7-22h37q14-16 28 0H300q8-10 16 0h24l6 10 10-58 10 70 7-22h37q14-16 28 0H600"/></defs>
          <g class="ecg-run"><use href="#ecgBeat"/><use href="#ecgBeat" x="600"/></g>
        </svg>
      </div>
      <ul class="mon-rows">
        <li><i style="background:#0F9A5F">B</i><div><b>BPJS Kesehatan</b><small>V-Claim · antrean online</small></div><span class="ok">Terhubung</span></li>
        <li><i style="background:#2F6BF0">S</i><div><b>SATUSEHAT</b><small>Kemenkes RI</small></div><span class="ok">Sinkron</span></li>
        <li><i style="background:#C2417A">L</i><div><b>Laboratorium</b><small>hasil otomatis ke RME</small></div><span class="ok">Aktif</span></li>
        <li><i style="background:#E0874A">F</i><div><b>Farmasi</b><small>resep dan stok</small></div><span class="ok">Aktif</span></li>
        <li><i style="background:#0B7A6C">K</i><div><b>Kasir dan klaim</b><small>tanpa input ulang</small></div><span class="ok">Aktif</span></li>
      </ul>
      <div class="mon-foot"><span>Satu data pasien</span><b>pendaftaran → klaim</b></div>
      <div class="mon-tag" aria-hidden="true">@include('partials.icon', ['name' => 'shield'])Data tersimpan aman</div>
    </div>
  </div>

  @if (count($logos))
  <div class="banner-logos">
    <p>{{ $set('logos_label') }}</p>
    <div class="marquee">
      <div class="marquee-track">
        @foreach (array_merge($logos, $logos) as $item)<span>{{ $item }}</span>@endforeach
        @foreach (array_merge($logos, $logos) as $item)<span aria-hidden="true">{{ $item }}</span>@endforeach
      </div>
    </div>
  </div>
  @endif
</section>

{{-- ============ HUB ============ --}}
<section class="section hub-section">
  <div class="wrap">
    <div class="head reveal">
      <span class="pill"><b></b>{{ $set('hub_pill') }}</span>
      <h2>{{ \App\Support\Text::highlight($set('hub_title')) }}</h2>
      <p>{{ $set('hub_text') }}</p>
    </div>
    <div class="hub-wrap reveal">
      <div class="hub" role="img" aria-label="Ilustrasi SIMRS sebagai pusat data yang terhubung ke BPJS, SATUSEHAT, laboratorium, radiologi, farmasi, kasir, dan Mekari">
        <svg viewBox="0 0 1000 500" preserveAspectRatio="none" aria-hidden="true">
          <defs><linearGradient id="wireGrad" x1="0" x2="1"><stop offset="0" stop-color="#2FD1B2"/><stop offset="1" stop-color="#8FF0DC"/></linearGradient></defs>
          <path class="wire" d="M500 250 C 360 250, 300 110, 170 110"/><path class="wire" d="M500 250 C 360 250, 300 250, 140 260"/>
          <path class="wire" d="M500 250 C 360 250, 300 390, 180 400"/><path class="wire" d="M500 250 C 640 250, 700 110, 830 110"/>
          <path class="wire" d="M500 250 C 640 250, 700 250, 860 260"/><path class="wire" d="M500 250 C 640 250, 700 390, 820 400"/>
          <path class="wire" d="M500 250 L 500 60"/>
        </svg>
        <div class="hub-core"><div><b>SIMRS</b><span>pusat data rumah sakit</span></div></div>
        <div class="hub-node" style="left:17%;top:22%;animation-delay:-1s"><i style="background:#0FA36B">B</i><div>BPJS Kesehatan<small>V-Claim, antrean</small></div></div>
        <div class="hub-node" style="left:14%;top:52%;animation-delay:-3s"><i style="background:#3A6FF8">S</i><div>SATUSEHAT<small>Kemenkes RI</small></div></div>
        <div class="hub-node" style="left:18%;top:80%;animation-delay:-2s"><i style="background:#E0874A">F</i><div>Farmasi<small>resep dan stok</small></div></div>
        <div class="hub-node" style="left:83%;top:22%;animation-delay:-4s"><i style="background:#C2417A">L</i><div>Laboratorium<small>hasil otomatis</small></div></div>
        <div class="hub-node" style="left:86%;top:52%;animation-delay:-1.5s"><i style="background:#7B5CFA">R</i><div>Radiologi<small>terhubung RME</small></div></div>
        <div class="hub-node" style="left:82%;top:80%;animation-delay:-2.5s"><i style="background:#0FB5A3">K</i><div>Kasir dan klaim<small>tanpa input ulang</small></div></div>
        <div class="hub-node" style="left:50%;top:12%;animation-delay:-3.5s"><i style="background:#2C4A9A">M</i><div>Mekari<small>HR dan akuntansi</small></div></div>
      </div>
    </div>
  </div>
</section>

@if (count($ribbon))
<div class="ribbon" aria-hidden="true">
  <div class="ribbon-track">
    @foreach (array_merge($ribbon, $ribbon) as $item)<span>{{ $item }}</span>@endforeach
  </div>
</div>
@endif

{{-- ============ LAYANAN ============ --}}
<section class="section" id="layanan">
  <div class="wrap">
    <div class="head reveal">
      <span class="pill"><b></b>Layanan</span>
      <h2>{{ \App\Support\Text::highlight($set('services_title')) }}</h2>
      <p>{{ $set('services_text') }}</p>
    </div>
    @include('sections.bento', ['services' => $services, 'hero' => $hero])
  </div>
</section>

{{-- ============ BUKTI ============ --}}
<section class="section dark" id="studi-kasus">
  <div class="wrap">
    <div class="head reveal">
      <span class="pill">Bukti di lapangan</span>
      <h2>{{ \App\Support\Text::highlight($set('proof_title')) }}</h2>
      <p>{{ $set('proof_text') }}</p>
    </div>
    @if (count($stats))
    <div class="stats">
      @foreach ($stats as [$num, $label])
        @php
          $digits = (int) preg_replace('/\D/', '', $num);
          $suffix = preg_replace('/[\d.]/', '', $num);
        @endphp
        <div class="stat reveal"><strong @if ($digits > 0) data-count="{{ $digits }}" data-suffix="{{ $suffix }}" @endif>{{ $num }}</strong><span>{{ $label }}</span></div>
      @endforeach
    </div>
    <p class="stat-note">{{ $set('stats_note') }}</p>
    @endif
    @if ($case)
      @include('sections.case-card', ['case' => $case, 'link' => true])
    @endif
  </div>
</section>

{{-- ============ PORTOFOLIO ============ --}}
@include('sections.portfolio', ['portfolio' => $portfolio])

{{-- ============ PROSES ============ --}}
<section class="section" style="padding-top:0">
  <div class="wrap">
    <div class="head reveal">
      <span class="pill"><b></b>Cara kerja</span>
      <h2>{{ \App\Support\Text::highlight($set('process_title')) }}</h2>
      <p>{{ $set('process_text') }}</p>
    </div>
    <ol class="steps">
      @foreach ($steps as [$title, $text])
        <li class="reveal"><h3>{{ $title }}</h3><p>{{ $text }}</p></li>
      @endforeach
    </ol>
  </div>
</section>

{{-- ============ AREA ============ --}}
<section class="section" id="area" style="padding-top:0">
  <div class="wrap">
    <div class="area reveal">
      <div>
        <span class="pill"><b></b>Area layanan</span>
        <h2 style="margin-top:18px">{{ $set('area_title') }}</h2>
        <p>{{ $set('area_text') }}</p>
      </div>
      <div class="cities">
        @foreach ($cities as $c)
          @if ($c->has_page)
            <a href="{{ route('cities.show', $c->slug) }}" class="{{ $c->is_main ? 'main' : '' }}">{{ $c->name }}</a>
          @else
            <span>{{ $c->name }}</span>
          @endif
        @endforeach
      </div>
    </div>
  </div>
</section>

{{-- ============ BLOG ============ --}}
@if ($posts->isNotEmpty())
<section class="section" id="blog" style="padding-top:0">
  <div class="wrap">
    <div class="head reveal">
      <span class="pill"><b></b>Artikel</span>
      <h2>{{ \App\Support\Text::highlight($set('blog_title')) }}</h2>
      <p>{{ $set('blog_text') }}</p>
    </div>
    <div class="posts">
      @foreach ($posts as $post)
        @include('partials.post-card', ['post' => $post])
      @endforeach
    </div>
    <p style="text-align:center;margin-top:36px"><a href="{{ route('blog.index') }}" class="btn btn-line">Lihat semua artikel</a></p>
  </div>
</section>
@endif

{{-- ============ FAQ ============ --}}
@if ($faqs->isNotEmpty())
<section class="section" id="faq" style="padding-top:0">
  <div class="wrap faq-grid">
    <div class="reveal">
      <span class="pill"><b></b>FAQ</span>
      <h2 style="margin-top:18px">{{ $set('faq_title') }}</h2>
      <p>{{ $set('faq_text') }}</p>
    </div>
    <div class="reveal">
      @include('partials.faq-list', ['faqs' => $faqs->map(fn ($f) => [$f->question, $f->answer])->all()])
    </div>
  </div>
</section>
@endif

@include('partials.final-cta')
@include('partials.contact-section', ['services' => $services])
@endsection
