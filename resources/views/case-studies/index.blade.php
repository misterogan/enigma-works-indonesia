@extends('layouts.app')

@section('content')
<section class="page-banner">
  <div class="wrap">
    @include('partials.crumbs', ['items' => [['Beranda', route('home')], ['Studi kasus', null]]])
    <h1>Studi kasus dan portofolio</h1>
    <p class="lead">Proyek yang kami kerjakan langsung, beserta rumah sakit lain yang menggunakan platform SIMRS yang kami terapkan.</p>
  </div>
</section>

<section class="section dark">
  <div class="wrap" style="display:grid;gap:40px">
    @forelse ($cases as $case)
      @include('sections.case-card', ['case' => $case, 'link' => true])
    @empty
      <p class="empty">Studi kasus akan segera ditambahkan.</p>
    @endforelse
  </div>
</section>

@include('sections.portfolio', ['portfolio' => $portfolio])
@include('partials.final-cta')
@endsection
