@extends('layouts.app')

@section('content')
<section class="page-banner">
  <div class="wrap">
    @include('partials.crumbs', ['items' => [['Beranda', route('home')], ['Kontak', null]]])
    <h1>Kontak dan konsultasi gratis</h1>
    <p class="lead">Ceritakan kondisi rumah sakit atau klinik Anda. Kami bantu memetakan kebutuhan SIMRS, integrasi, dan infrastrukturnya.</p>
  </div>
</section>
@include('partials.contact-section', ['services' => $services])
@endsection
