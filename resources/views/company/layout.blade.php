<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>{{ $company['seo']['title'] }}</title>
<meta name="description" content="{{ $company['seo']['description'] }}">
<meta name="robots" content="index, follow">
<link rel="canonical" href="https://{{ $company['domain'] }}/">
<meta name="theme-color" content="#3B3FD8">
<meta property="og:type" content="website">
<meta property="og:locale" content="id_ID">
<meta property="og:site_name" content="{{ $company['legal_name'] }}">
<meta property="og:title" content="{{ $company['seo']['title'] }}">
<meta property="og:description" content="{{ $company['seo']['description'] }}">
<meta property="og:url" content="https://{{ $company['domain'] }}/">
@if ($ogImage)
<meta property="og:image" content="{{ $ogImage }}">
<meta name="twitter:card" content="summary_large_image">
@endif
<link rel="icon" href="{{ url('favicon.ico') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
{{-- Aset dimuat dari domain ini sendiri (url(), bukan asset()), karena ASSET_URL menunjuk ke domain Enigma Health --}}
<link rel="stylesheet" href="{{ url('css/company.css') }}?v={{ filemtime(public_path('css/company.css')) }}">
<script type="module" src="{{ url('js/company.js') }}?v={{ filemtime(public_path('js/company.js')) }}"></script>
<script type="application/ld+json">{!! \App\Support\Seo::json($schema) !!}</script>
</head>
<body>
<a class="skip" href="#konten">Lewati ke konten</a>
@yield('content')
</body>
</html>
