<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>{{ $seo['title'] }}</title>
<meta name="description" content="{{ $seo['description'] }}">
<meta name="robots" content="{{ $seo['robots'] }}">
<link rel="canonical" href="{{ $seo['canonical'] }}">
<meta name="geo.region" content="ID-SU">
<meta name="geo.placename" content="Medan">
<meta property="og:type" content="{{ $seo['type'] }}">
<meta property="og:locale" content="id_ID">
<meta property="og:site_name" content="{{ $set('company_name', 'Enigma Works Indonesia') }}">
<meta property="og:title" content="{{ $seo['title'] }}">
<meta property="og:description" content="{{ $seo['description'] }}">
<meta property="og:url" content="{{ $seo['canonical'] }}">
@if (! empty($seo['image']))
<meta property="og:image" content="{{ $seo['image'] }}">
@endif
<meta name="twitter:card" content="summary_large_image">
<link rel="icon" href="{{ asset('favicon.ico') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,600;1,9..144,400;1,9..144,500&family=JetBrains+Mono:wght@500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
{{-- CSS dan JS dimuat langsung dari folder public, tanpa npm. ?v= berganti otomatis saat file diubah agar browser tidak memakai versi lama. --}}
<link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}">
<script type="module" src="{{ asset('js/app.js') }}?v={{ filemtime(public_path('js/app.js')) }}"></script>
{{-- Muat halaman tujuan lebih awal saat link disorot, agar perpindahan terasa instan. Tidak memengaruhi SEO. --}}
<script type="speculationrules">
{"prefetch":[{"where":{"and":[{"href_matches":"/*"},{"not":{"href_matches":["/admin","/admin/*","/sitemap.xml"]}}]},"eagerness":"moderate"}]}
</script>
@foreach (($schema ?? []) as $data)
<script type="application/ld+json">{!! \App\Support\Seo::json($data) !!}</script>
@endforeach
</head>
<body>
<div class="page-loader" id="pageLoader" aria-hidden="true"><span></span></div>
<svg width="0" height="0" style="position:absolute" aria-hidden="true"><defs><linearGradient id="lg" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#0B7A6C"/><stop offset="1" stop-color="#2FD1B2"/></linearGradient></defs></svg>

@if ($set('announce_text'))
<div class="announce">{{ $set('announce_text') }}@if ($set('announce_link'))<a href="{{ url($set('announce_link')) }}">Selengkapnya</a>@endif</div>
@endif

@include('partials.header')

<main id="konten">
  @yield('content')
</main>

@include('partials.footer')
@include('partials.wa-float')
</body>
</html>
