<div class="bento">
  @if ($hero)
  <a href="{{ route('services.show', $hero->slug) }}" class="tile hero-tile reveal">
    @if ($hero->badge)<span class="badge">{{ $hero->badge }}</span>@endif
    <span class="layer">{{ $hero->layer }}</span>
    <h3>{{ $hero->name }}</h3>
    <p>{{ $hero->short }}</p>
    @if (! empty($hero->tags))<div class="mods">@foreach ($hero->tags as $tag)<span>{{ $tag }}</span>@endforeach</div>@endif
    <span class="more">Pelajari {{ \Illuminate\Support\Str::lcfirst($hero->name) }} @include('partials.icon', ['name' => 'arrow'])</span>
    <span class="glow"></span>
  </a>
  @endif
  @php $rest = $services->reject(fn ($s) => $hero && $s->id === $hero->id)->values(); @endphp
  @foreach ($rest as $i => $svc)
    @php
      // 4 kartu pertama kecil, sisanya lebar; kartu terakhir penuh bila jumlahnya ganjil
      $isLast = $i === $rest->count() - 1;
      $class = $i < 4 ? '' : (($isLast && ($rest->count() - 4) % 2 === 1) ? 'full' : 'wide');
    @endphp
    <a href="{{ route('services.show', $svc->slug) }}" class="tile {{ $class }} reveal">
      @if ($svc->badge)<span class="badge">{{ $svc->badge }}</span>@endif
      <span class="ico">@include('partials.icon', ['name' => $svc->icon])</span>
      <span class="layer">{{ $svc->layer }}</span>
      <h3>{{ $svc->name }}</h3>
      <p>{{ $svc->short }}</p>
      <span class="more">Pelajari @include('partials.icon', ['name' => 'arrow'])</span>
    </a>
  @endforeach
</div>
