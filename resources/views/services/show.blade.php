@extends('layouts.app')

@section('content')
<section class="page-banner">
  <div class="wrap">
    @include('partials.crumbs', ['items' => [['Beranda', route('home')], ['Layanan', route('services.index')], [$service->name, null]]])
    <h1>{{ $service->h1 ?: $service->name }}</h1>
    <p class="lead">{{ $service->intro ?: $service->short }}</p>
    <div class="banner-actions">
      <a href="{{ route('contact') }}" class="bbtn bbtn-fill">Konsultasikan kebutuhan Anda</a>
      <a href="https://wa.me/{{ $set('whatsapp') }}?text={{ rawurlencode('Halo '.$set('company_name').', saya ingin bertanya tentang '.$service->name.'.') }}" class="bbtn bbtn-line">Tanya lewat WhatsApp</a>
    </div>
  </div>
</section>

<section class="section">
  <div class="wrap two-col">
    <div>
      @if (! empty($service->points))
      <div class="block">
        <h2>Yang kami kerjakan</h2>
        <ul class="points">
          @foreach ($service->points as [$title, $text])
            <li class="reveal"><h3>{{ $title }}</h3><p>{{ $text }}</p></li>
          @endforeach
        </ul>
      </div>
      @endif

      @if (! empty($service->tags))
      <div class="block">
        <h2>Cakupan</h2>
        <div class="chips">@foreach ($service->tags as $tag)<span>{{ $tag }}</span>@endforeach</div>
      </div>
      @endif

      <div class="block">
        <h2>Tahapan pekerjaan</h2>
        <ol class="steps" style="grid-template-columns:repeat(auto-fit,minmax(170px,1fr))">
          @foreach (\App\Models\Setting::pairs('process_steps') as [$title, $text])
            <li class="reveal"><h3>{{ $title }}</h3><p>{{ $text }}</p></li>
          @endforeach
        </ol>
      </div>

      @if ($cities->isNotEmpty())
      <div class="block">
        <h2>Tersedia di wilayah</h2>
        <ul class="links">
          @foreach ($cities as $c)
            <li><a href="{{ route('cities.show', $c->slug) }}">{{ $service->name }} di {{ $c->name }}<span>Lihat area</span></a></li>
          @endforeach
        </ul>
      </div>
      @endif

      @if (! empty($service->faqs))
      <div class="block">
        <h2>Pertanyaan seputar {{ \Illuminate\Support\Str::lcfirst($service->name) }}</h2>
        @include('partials.faq-list', ['faqs' => $service->faqs])
      </div>
      @endif
    </div>

    <aside class="aside">
      <div class="abox dark">
        <h2>Butuh {{ \Illuminate\Support\Str::lcfirst($service->name) }}?</h2>
        <p>Ceritakan kondisi rumah sakit Anda. Konsultasi awal tanpa biaya.</p>
        <a href="{{ route('contact') }}" class="hbtn hbtn-fill" style="justify-content:center">Jadwalkan konsultasi</a>
      </div>
      @if ($others->isNotEmpty())
      <div class="abox">
        <h2>Layanan lainnya</h2>
        <ul>@foreach ($others as $o)<li><a href="{{ route('services.show', $o->slug) }}">{{ $o->name }}</a></li>@endforeach</ul>
      </div>
      @endif
      @if ($case)
      <div class="abox">
        <h2>Studi kasus</h2>
        <p>{{ $case->title }}</p>
        <a href="{{ route('cases.show', $case->slug) }}">Baca studi kasus</a>
      </div>
      @endif
    </aside>
  </div>
</section>

@if ($posts->isNotEmpty())
<section class="section" style="padding-top:0">
  <div class="wrap">
    <div class="head reveal"><h2>Artikel terkait</h2></div>
    <div class="posts">@foreach ($posts as $post)@include('partials.post-card', ['post' => $post])@endforeach</div>
  </div>
</section>
@endif

@include('partials.final-cta')
@endsection
