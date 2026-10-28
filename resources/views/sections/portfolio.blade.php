@if ($portfolio->isNotEmpty())
<section class="section" id="portofolio">
  <div class="wrap">
    <div class="head reveal">
      <span class="pill"><b></b>Portofolio</span>
      <h2>{{ \App\Support\Text::highlight($set('portfolio_title')) }}</h2>
      <p>{{ $set('portfolio_text') }}</p>
    </div>
    <div class="rail" id="rail">
      @foreach ($portfolio as $item)
        <article class="pcard">
          <div class="pimg {{ $item->is_own ? 'own' : 'dh' }}">
            @if ($item->image)
              <img src="{{ \App\Support\Media::url($item->image) }}" alt="{{ $item->name }}" loading="lazy" style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0">
            @else
              {{ $item->name }}
            @endif
          </div>
          <div class="pbody">
            <span class="ptag {{ $item->is_own ? 'own' : '' }}">{{ $item->label }}</span>
            <h3>@if ($item->link)<a href="{{ url($item->link) }}" style="text-decoration:none">{{ $item->name }}</a>@else{{ $item->name }}@endif</h3>
            <p>{{ $item->text }}</p>
          </div>
        </article>
      @endforeach
    </div>
    <div class="rail-foot">
      <span>{{ $set('portfolio_more') }}</span>
      <div class="rail-btns">
        <button type="button" data-dir="-1" aria-label="Geser ke kiri"><svg viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M10 3L5 8l5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
        <button type="button" data-dir="1" aria-label="Geser ke kanan"><svg viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M6 3l5 5-5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
      </div>
    </div>
  </div>
</section>
@endif
