<div class="case">
  <article class="case-card reveal">
    <span class="pill" style="justify-self:start">Studi kasus</span>
    <h3>{{ $case->title }}</h3>
    <p>{{ $case->summary }}</p>
    @if (! empty($case->checks))
    <ul class="checks">
      @foreach ($case->checks as $check)<li>@include('partials.icon', ['name' => 'check']){{ $check }}</li>@endforeach
    </ul>
    @endif
    @if (! empty($link))
      <a href="{{ route('cases.show', $case->slug) }}" class="btn btn-main" style="background:#fff;color:#0B1324;justify-self:start;margin-top:8px">Baca studi kasus lengkap</a>
    @endif
  </article>
  @if ($case->showQuote())
  <figure class="quote-card reveal" style="margin:0">
    <blockquote>“{{ $case->quote }}”</blockquote>
    <figcaption><b>{{ $case->quote_by }}</b>{{ $case->quote_role }}</figcaption>
    @if (! $case->quote_approved)<span class="draft">Draf, hanya terlihat di komputer lokal. Centang "Testimoni sudah disetujui" di backoffice agar tayang.</span>@endif
  </figure>
  @else
  <div class="quote-card no-quote reveal">
    <dl class="facts-light">
      @foreach (($case->facts ?? []) as [$label, $value])
        <div><dt>{{ $label }}</dt><dd>{{ $value }}</dd></div>
      @endforeach
    </dl>
  </div>
  @endif
</div>
