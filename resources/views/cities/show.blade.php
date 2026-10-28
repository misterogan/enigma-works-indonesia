@extends('layouts.app')

@section('content')
<section class="page-banner">
  <div class="wrap">
    @include('partials.crumbs', ['items' => [['Beranda', route('home')], ['Area layanan', route('home').'#area'], [$city->name, null]]])
    <h1>{{ $city->h1 ?: 'Solusi IT rumah sakit di '.$city->name }}</h1>
    <p class="lead">{{ $city->intro }}</p>
    <div class="banner-actions">
      <a href="{{ route('contact') }}" class="bbtn bbtn-fill">Konsultasi gratis</a>
      <a href="{{ route('cases.index') }}" class="bbtn bbtn-line">Lihat studi kasus</a>
    </div>
  </div>
</section>

<section class="section">
  <div class="wrap two-col">
    <div>
      @if (count($city->paragraphs()))
      <div class="block prose-text">
        <h2>Cara kami melayani {{ $city->name }}</h2>
        @foreach ($city->paragraphs() as $paragraph)<p>{{ $paragraph }}</p>@endforeach
      </div>
      @endif

      <div class="block">
        <h2>Layanan untuk rumah sakit di {{ $city->name }}</h2>
        <ul class="links">
          @foreach ($services as $svc)
            <li><a href="{{ route('services.show', $svc->slug) }}">{{ $svc->name }}<span>{{ implode(', ', array_slice($svc->tags ?? [], 0, 2)) }}</span></a></li>
          @endforeach
        </ul>
      </div>

      <div class="block">
        <h2>Tahapan pekerjaan</h2>
        <ol class="steps" style="grid-template-columns:repeat(auto-fit,minmax(170px,1fr))">
          @foreach (\App\Models\Setting::pairs('process_steps') as [$title, $text])
            <li class="reveal"><h3>{{ $title }}</h3><p>{{ $text }}</p></li>
          @endforeach
        </ol>
      </div>
    </div>

    <aside class="aside">
      <div class="abox dark">
        <h2>Konsultasi untuk {{ $city->name }}</h2>
        <p>Hubungi kami untuk survei dan estimasi kebutuhan rumah sakit atau klinik Anda.</p>
        <a href="https://wa.me/{{ $set('whatsapp') }}?text={{ rawurlencode('Halo '.$set('company_name').', saya dari '.$city->name.', ingin konsultasi IT rumah sakit.') }}" class="hbtn hbtn-fill" style="justify-content:center">Chat WhatsApp</a>
      </div>
      @if ($nearby->isNotEmpty())
      <div class="abox">
        <h2>Wilayah sekitar</h2>
        <ul>@foreach ($nearby as $n)<li><a href="{{ route('cities.show', $n->slug) }}">IT rumah sakit {{ $n->name }}</a></li>@endforeach</ul>
      </div>
      @endif
    </aside>
  </div>
</section>

@include('partials.final-cta', ['title' => 'Rumah sakit Anda di '.$city->name.'?'])
@endsection
