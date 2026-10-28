@extends('layouts.app')

@section('content')
<section class="page-banner">
  <div class="wrap">
    @include('partials.crumbs', ['items' => [['Beranda', route('home')], ['Studi kasus', route('cases.index')], [$case->client, null]]])
    <h1>{{ $case->title }}</h1>
    <p class="lead">{{ $case->summary }}</p>
  </div>
</section>

<section class="section">
  <div class="wrap two-col">
    <div class="case-story">
      @if ($case->image)
        <figure class="article-cover"><img src="{{ \App\Support\Media::url($case->image) }}" alt="{{ $case->client }}"></figure>
      @endif
      @foreach (($case->sections ?? []) as [$title, $text])
        <div class="reveal"><h2>{{ $title }}</h2><p>{{ $text }}</p></div>
      @endforeach
      @if ($case->showQuote())
        <figure class="quote-card reveal" style="margin:0">
          <blockquote>“{{ $case->quote }}”</blockquote>
          <figcaption><b>{{ $case->quote_by }}</b>{{ $case->quote_role }}</figcaption>
        </figure>
      @endif
    </div>
    <aside class="aside">
      @if (! empty($case->facts))
      <div class="abox">
        <h2>Ringkasan proyek</h2>
        <dl class="facts">@foreach ($case->facts as [$label, $value])<div><dt>{{ $label }}</dt><dd>{{ $value }}</dd></div>@endforeach</dl>
      </div>
      @endif
      @if ($services->isNotEmpty())
      <div class="abox">
        <h2>Layanan dalam proyek ini</h2>
        <ul>@foreach ($services as $svc)<li><a href="{{ route('services.show', $svc->slug) }}">{{ $svc->name }}</a></li>@endforeach</ul>
      </div>
      @endif
    </aside>
  </div>
</section>

@include('partials.final-cta', ['title' => 'Ingin hasil serupa di rumah sakit Anda?'])
@endsection
