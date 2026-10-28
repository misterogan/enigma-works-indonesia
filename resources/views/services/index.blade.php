@extends('layouts.app')

@section('content')
<section class="page-banner">
  <div class="wrap">
    @include('partials.crumbs', ['items' => [['Beranda', route('home')], ['Layanan', null]]])
    <h1>Layanan SIMRS dan IT rumah sakit</h1>
    <p class="lead">{{ $set('services_text') }}</p>
  </div>
</section>

<section class="section">
  <div class="wrap">
    @include('sections.bento', ['services' => $services, 'hero' => $services->firstWhere('badge', 'Layanan utama') ?? $services->first()])
  </div>
</section>

@include('partials.final-cta')
@endsection
