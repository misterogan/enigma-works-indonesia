<a href="{{ route('blog.show', $post->slug) }}" class="post reveal">
  <div class="post-cover grad-text" style="background:var(--bg-soft)">
    @if ($post->cover)
      <img src="{{ \App\Support\Media::url($post->cover) }}" alt="" loading="lazy" width="640" height="360">
    @else
      {{ $post->categoryLabel() }}
    @endif
  </div>
  <div class="post-body">
    <small>{{ $post->categoryLabel() }}</small>
    <h3>{{ $post->title }}</h3>
    @if ($post->published_at)<time datetime="{{ $post->published_at->toDateString() }}">{{ $post->published_at->translatedFormat('j F Y') }}</time>@endif
  </div>
</a>
