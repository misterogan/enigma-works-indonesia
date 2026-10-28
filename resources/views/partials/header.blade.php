@php
  $nav = [
    ['Layanan', route('services.index'), 'services.*'],
    ['Studi kasus', route('cases.index'), 'cases.*'],
    ['Blog', route('blog.index'), 'blog.*'],
    ['Tentang kami', route('about'), 'about'],
    ['Kontak', route('contact'), 'contact'],
  ];
@endphp
<header class="site-header" id="siteHeader">
  <nav class="wrap nav" aria-label="Navigasi utama">
    <a href="{{ route('home') }}" class="brand" aria-label="{{ $set('company_name') }}, beranda">
      @include('partials.logo')
      @if ($set('show_company_name', '1') === '1' || ! $set('logo'))
        <span class="brand-name">{{ $set('company_name', 'Enigma Works Indonesia') }}</span>
      @endif
    </a>
    <ul class="nav-links" id="navLinks">
      @foreach ($nav as [$label, $url, $pattern])
        <li><a href="{{ $url }}" @if (request()->routeIs($pattern)) aria-current="page" @endif>{{ $label }}</a></li>
      @endforeach
    </ul>
    <div class="nav-cta">
      <a href="https://wa.me/{{ $set('whatsapp') }}" class="hbtn hbtn-line">WhatsApp</a>
      <a href="{{ route('contact') }}" class="hbtn hbtn-fill">Konsultasi gratis</a>
    </div>
    <button class="menu-toggle" id="menuToggle" aria-label="Buka menu" aria-expanded="false" aria-controls="navLinks">
      <svg width="20" height="20" viewBox="0 0 20 20" aria-hidden="true"><path d="M3 6h14M3 10h14M3 14h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
    </button>
  </nav>
</header>
