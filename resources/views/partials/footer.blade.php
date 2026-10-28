@php
  $footerServices = \App\Models\Service::active()->ordered()->take(6)->get();
  $footerCities = \App\Models\City::withPage()->ordered()->get();
@endphp
<footer class="footer">
  <div class="wrap">
    <div class="fgrid">
      <div>
        <a href="{{ route('home') }}" class="brand">@include('partials.logo')@if ($set('show_company_name', '1') === '1' || ! $set('logo'))<span class="brand-name">{{ $set('company_name') }}</span>@endif</a>
        <address>{{ $set('legal_name') }}<br>{{ $set('street') }}, {{ $set('city') }}<br>
          <a href="tel:{{ $set('phone_e164') }}">{{ $set('phone') }}</a><br>
          <a href="mailto:{{ $set('email') }}">{{ $set('email') }}</a></address>
      </div>
      <div><h4>Layanan</h4><ul>
        @foreach ($footerServices as $svc)<li><a href="{{ route('services.show', $svc->slug) }}">{{ $svc->name }}</a></li>@endforeach
      </ul></div>
      <div><h4>Area layanan</h4><ul>
        @foreach ($footerCities as $c)<li><a href="{{ route('cities.show', $c->slug) }}">IT rumah sakit {{ $c->name }}</a></li>@endforeach
      </ul></div>
      <div><h4>Perusahaan</h4><ul>
        <li><a href="{{ route('cases.index') }}">Studi kasus</a></li>
        <li><a href="{{ route('blog.index') }}">Blog</a></li>
        <li><a href="{{ route('about') }}">Tentang kami</a></li>
        <li><a href="{{ route('contact') }}">Kontak</a></li>
      </ul></div>
    </div>
    <div class="fbottom"><span>© {{ date('Y') }} {{ $set('legal_name') }}</span><span>{{ $set('partner_line') }}</span></div>
  </div>
</footer>
