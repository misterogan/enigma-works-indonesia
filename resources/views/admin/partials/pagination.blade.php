@if ($paginator->hasPages())
<nav aria-label="Halaman" style="display:flex;gap:8px;align-items:center;flex-wrap:wrap">
  @if ($paginator->onFirstPage())
    <span class="btn btn-g" style="opacity:.45;cursor:default">Sebelumnya</span>
  @else
    <a class="btn btn-g" href="{{ $paginator->previousPageUrl() }}" rel="prev">Sebelumnya</a>
  @endif
  <span class="muted">Halaman {{ $paginator->currentPage() }} dari {{ $paginator->lastPage() }}</span>
  @if ($paginator->hasMorePages())
    <a class="btn btn-g" href="{{ $paginator->nextPageUrl() }}" rel="next">Berikutnya</a>
  @else
    <span class="btn btn-g" style="opacity:.45;cursor:default">Berikutnya</span>
  @endif
</nav>
@endif
 
