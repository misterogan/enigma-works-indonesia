@extends('layouts.app')

@section('content')
<section class="page-banner">
  <div class="wrap">
    @include('partials.crumbs', ['items' => [['Beranda', route('home')], ['Tentang kami', null]]])
    <h1>Tentang {{ $set('company_name') }}</h1>
    <p class="lead">{{ $set('about_intro') }}</p>
  </div>
</section>

<section class="section">
  <div class="wrap two-col">
    <div class="prose">{!! $body !!}</div>
    <aside class="aside">
      <div class="abox">
        <h2>Legalitas</h2>
        <p>{{ $set('legal_name') }}<br>{{ $set('street') }}, {{ $set('city') }}, {{ $set('region') }}</p>
      </div>
      @if ($cities->isNotEmpty())
      <div class="abox">
        <h2>Area layanan</h2>
        <ul>@foreach ($cities as $c)<li><a href="{{ route('cities.show', $c->slug) }}">{{ $c->name }}</a></li>@endforeach</ul>
      </div>
      @endif
    </aside>
  </div>
</section>

@include('partials.final-cta')
@endsection
