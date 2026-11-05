@extends('layouts.app')

@section('content')
<section class="page-banner">
  <div class="wrap">
    @include('partials.crumbs', ['items' => array_values(array_filter([
      ['Beranda', route('home')],
      ['Blog', $active ? route('blog.index') : null],
      $active ? [$categories[$active], null] : null,
    ]))])
    <h1>{{ $heading }}</h1>
    <p class="lead">{{ $set('blog_text') }}</p>
  </div>
</section>

<section class="section">
  <div class="wrap">
    <ul class="cat-filter" aria-label="Kategori">
      <li><a href="{{ route('blog.index') }}" @if (! $active) aria-current="page" @endif>Semua</a></li>
      @foreach ($categories as $key => $label)
        <li><a href="{{ route('blog.category', $key) }}" @if ($active === $key) aria-current="page" @endif>{{ $label }}</a></li>
      @endforeach
    </ul>
    @if ($posts->isEmpty())
      <p class="empty">Belum ada artikel di kategori ini. Lihat <a href="{{ route('blog.index') }}">semua artikel</a>.</p>
    @else
      <div class="posts">@foreach ($posts as $post)@include('partials.post-card', ['post' => $post])@endforeach</div>
      {{ $posts->links('partials.pagination') }}
    @endif
  </div>
</section>

@include('partials.final-cta')
@endsection
