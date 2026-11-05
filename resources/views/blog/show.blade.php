@extends('layouts.app')

@section('content')
<article>
  <header class="page-banner">
    <div class="wrap">
      @include('partials.crumbs', ['items' => [['Beranda', route('home')], ['Blog', route('blog.index')], [$post->categoryLabel(), route('blog.category', $post->category)]]])
      <h1>{{ $post->title }}</h1>
      <p class="post-meta">
        <b>{{ $post->categoryLabel() }}</b>, ditulis oleh {{ $post->author }}
        @if ($post->published_at), <time datetime="{{ $post->published_at->toDateString() }}">{{ $post->published_at->translatedFormat('j F Y') }}</time>@endif,
        {{ $content['reading'] }} menit baca
      </p>
    </div>
  </header>

  <section class="section">
    <div class="wrap two-col">
      <div>
        @if ($post->cover)
          <figure class="article-cover"><img src="{{ \App\Support\Media::url($post->cover) }}" alt="" width="1200" height="630"></figure>
        @endif
        <div class="prose">{!! $content['html'] !!}</div>
      </div>
      <aside class="aside">
        @if (count($content['toc']) > 1)
        <nav class="abox toc" aria-label="Daftar isi">
          <h2>Daftar isi</h2>
          <ol>@foreach ($content['toc'] as $item)<li><a href="#{{ $item['id'] }}">{{ $item['text'] }}</a></li>@endforeach</ol>
        </nav>
        @endif
        <div class="abox dark">
          <h2>Butuh bantuan langsung?</h2>
          <p>Tim kami berpengalaman menangani bridging BPJS dan integrasi SATUSEHAT di rumah sakit.</p>
          <a href="{{ route('contact') }}" class="hbtn hbtn-fill" style="justify-content:center">Jadwalkan konsultasi</a>
        </div>
      </aside>
    </div>
  </section>
</article>

@if ($related->isNotEmpty())
<section class="section" style="padding-top:0">
  <div class="wrap">
    <div class="head reveal"><h2>Artikel lainnya</h2></div>
    <div class="posts">@foreach ($related as $item)@include('partials.post-card', ['post' => $item])@endforeach</div>
  </div>
</section>
@endif
@endsection
