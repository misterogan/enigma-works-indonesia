@if ($set('logo'))
  <img src="{{ \App\Support\Media::url($set('logo')) }}" alt="{{ $set('company_name') }}" class="brand-logo"
       style="--logo-h: {{ (int) $set('logo_height', 52) }}px">
@else
  <svg viewBox="0 0 40 40" aria-hidden="true"><rect width="40" height="40" rx="12" fill="url(#lg)"/><path d="M9 21h6l3-7 4 13 3-6h6" fill="none" stroke="#fff" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
@endif
