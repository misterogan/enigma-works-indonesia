<nav aria-label="Breadcrumb">
  <ol class="crumbs">
    @foreach ($items as [$label, $url])
      <li>@if ($url)<a href="{{ $url }}">{{ $label }}</a>@else<span aria-current="page">{{ $label }}</span>@endif</li>
    @endforeach
  </ol>
</nav>
