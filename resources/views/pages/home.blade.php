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

    @php
      // Diagram konsol: koordinat dalam viewBox 520 x 330, node kiri = aplikasi rumah sakit, kanan = layanan eksternal
      $internal = [['P', 'Pendaftaran & poli', 'RME · antrean', '#0C8580'], ['L', 'Laboratorium', 'LIS · HL7', '#C2417A'], ['R', 'Radiologi', 'PACS · DICOM', '#7B5CFA'], ['F', 'Farmasi & kasir', 'resep, stok, tagihan', '#E0874A']];
      $external = [['B', 'BPJS Kesehatan', 'V-Claim · SEP', '#16A36A'], ['S', 'SATUSEHAT', 'FHIR R4 · Kemenkes', '#2F6BF0'], ['J', 'Mobile JKN', 'antrean online', '#0FA3B1'], ['M', 'Mekari', 'ERP, HR, akuntansi', '#2C4A9A']];
      $rows = [60, 130, 200, 270];
      $log = [
        ['08:14:02', 'SEP terbit · pasien JKN poli dalam', '200 OK'],
        ['08:14:05', 'ORM^O01 order lab → LIS', 'ACK'],
        ['08:14:09', 'POST /Encounter → SATUSEHAT', '201'],
        ['08:14:12', 'ORU^R01 hasil lab → RME', 'ACK'],
      ];
    @endphp
    <div class="console-wrap reveal">
      <div class="console" role="img" aria-label="Ilustrasi SIMRS Enigma Health sebagai pusat data: pendaftaran, laboratorium, radiologi, farmasi dan kasir terhubung ke BPJS Kesehatan, SATUSEHAT, Mobile JKN, dan Mekari">
        <div class="console-bar"><span class="dots"><i></i><i></i><i></i></span><span>integration-engine · rumah-sakit-anda</span><span class="live-tag"><i class="live"></i>Live</span></div>
        <div class="console-map">
          <span class="ccol-label" style="left:4%">Aplikasi RS</span>
          <span class="ccol-label" style="right:4%">Layanan eksternal</span>
          <svg id="bannerArt" viewBox="0 0 520 330" aria-hidden="true">
            <defs><linearGradient id="wireGrad" x1="0" x2="1"><stop offset="0" stop-color="#2ED3B7"/><stop offset="1" stop-color="#3BB4F2"/></linearGradient></defs>
            @foreach ($rows as $i => $y)
              <path id="wi{{ $i }}" class="wire" d="M128 {{ $y }} C170 {{ $y }},160 165,192 165"/>
              <path id="wo{{ $i }}" class="wire" d="M328 165 C360 165,350 {{ $y }},392 {{ $y }}"/>
              <path class="wire hot" d="M128 {{ $y }} C170 {{ $y }},160 165,192 165"/>
              <path class="wire hot" d="M328 165 C360 165,350 {{ $y }},392 {{ $y }}"/>
              <circle class="pkt" r="3.5"><animateMotion dur="2.4s" begin="-{{ $i * 0.6 }}s" repeatCount="indefinite"><mpath href="#wi{{ $i }}"/></animateMotion></circle>
              <circle class="pkt out" r="3.5"><animateMotion dur="2.4s" begin="-{{ 1.2 + $i * 0.5 }}s" repeatCount="indefinite"><mpath href="#wo{{ $i }}"/></animateMotion></circle>
            @endforeach
          </svg>
          @foreach ($internal as $i => [$letter, $name, $note, $color])
            <div class="cnode" style="left:15%;top:{{ round($rows[$i] / 330 * 100, 1) }}%"><i style="background:{{ $color }}">{{ $letter }}</i><div>{{ $name }}<small>{{ $note }}</small></div></div>
          @endforeach
          <div class="ccore"><div><b>{{ $set('product_name', 'Enigma Health') }}</b><span>SIMRS terintegrasi</span></div></div>
          @foreach ($external as $i => [$letter, $name, $note, $color])
            <div class="cnode ext" style="left:85%;top:{{ round($rows[$i] / 330 * 100, 1) }}%"><i style="background:{{ $color }}">{{ $letter }}</i><div>{{ $name }}<small>{{ $note }}</small></div></div>
          @endforeach
        </div>
        <ul class="console-log" id="consoleLog" aria-hidden="true">
          @foreach ($log as [$time, $event, $status])
            <li><time>{{ $time }}</time><span>{{ $event }}</span><b>{{ $status }}</b></li>
          @endforeach
        </ul>
      </div>
      <div class="console-tag" aria-hidden="true">@include('partials.icon', ['name' => 'shield'])Terenkripsi · tercatat di audit log</div>
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
    @php
      $layers = [
        ['ext', 'Lapisan 03', 'Layanan nasional & mitra', 'Regulator, penjamin, dan aplikasi pihak ketiga.', [['BPJS Kesehatan · V-Claim', '#16A36A'], ['Antrean Mobile JKN', '#0FA3B1'], ['SATUSEHAT Kemenkes', '#2F6BF0'], ['Mekari · HR & akuntansi', '#2C4A9A']]],
        ['core', 'Lapisan 02', 'Lapisan integrasi', 'Diimplementasikan dan dirawat oleh tim kami.', [['API gateway & kredensial'], ['Pemetaan data & kode (ICD, LOINC, KFA)'], ['Antrean pesan & kirim ulang otomatis'], ['Pemantauan & peringatan 24/7'], ['Audit log']]],
        ['app', 'Lapisan 01', 'Aplikasi rumah sakit', 'Sistem yang sudah ada tetap dipakai.', [[$set('product_name', 'Enigma Health').' · SIMRS & RME', '#0C8580'], ['Laboratorium (LIS)', '#C2417A'], ['Radiologi (RIS/PACS)', '#7B5CFA'], ['Farmasi & logistik', '#E0874A'], ['Kasir & klaim', '#16A36A'], ['Dashboard manajemen', '#3BB4F2']]],
      ];
      $standards = \App\Models\Setting::lines('standards_items');
    @endphp
    <div class="stack reveal" role="list" aria-label="Arsitektur integrasi tiga lapis">
      @foreach ($layers as [$type, $num, $title, $text, $items])
        <div class="stack-layer {{ $type }}" role="listitem">
          <div class="stack-label"><small>{{ $num }}</small><b>{{ $title }}</b><p>{{ $text }}</p></div>
          <div class="stack-items">
            @foreach ($items as $item)<span><i @isset($item[1]) style="--c:{{ $item[1] }}" @endisset></i>{{ $item[0] }}</span>@endforeach
          </div>
        </div>
      @endforeach
    </div>
    @if (count($standards))
    <div class="standards reveal">
      <p>{{ $set('standards_label', 'Standar yang kami tangani') }}</p>
      @foreach ($standards as $item)<span>{{ $item }}</span>@endforeach
    </div>
    @endif
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
        <div class="stat reveal"><strong @if ($digits > 0) data-count="{{ $digits }}" data-suffix="{{ $suffix }}" @else class="word" @endif>{{ $num }}</strong><span>{{ $label }}</span></div>
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
