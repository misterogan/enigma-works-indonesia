@extends('layouts.app', ['seo' => \App\Support\Seo::meta(['title' => 'Halaman tidak ditemukan', 'robots' => 'noindex, follow'])])

@section('content')
<section class="page-banner" style="min-height:60vh;display:flex;align-items:center">
  <div class="wrap">
    <h1>Halaman tidak ditemukan</h1>
    <p class="lead">Alamat yang Anda buka tidak tersedia atau sudah dipindahkan.</p>
    <div class="banner-actions">
      <a href="{{ route('home') }}" class="bbtn bbtn-fill">Kembali ke beranda</a>
      <a href="{{ route('services.index') }}" class="bbtn bbtn-line">Lihat layanan</a>
    </div>
  </div>
</section>
@endsection
