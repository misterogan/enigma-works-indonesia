@switch($name ?? 'pulse')
  @case('plus')<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 3v18M3 12h18" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/></svg>@break
  @case('monitor')<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="3" y="4" width="18" height="12" rx="2" stroke="currentColor" stroke-width="2"/><path d="M8 20h8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>@break
  @case('server')<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="4" y="3" width="16" height="7" rx="2" stroke="currentColor" stroke-width="2"/><rect x="4" y="14" width="16" height="7" rx="2" stroke="currentColor" stroke-width="2"/></svg>@break
  @case('shield')<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 3l8 3v6c0 4.5-3.4 8-8 9-4.6-1-8-4.5-8-9V6l8-3z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>@break
  @case('clock')<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="12" cy="12" r="8" stroke="currentColor" stroke-width="2"/><path d="M12 8v4l3 2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>@break
  @case('building')<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 18V8l8-4 8 4v10" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="M9 18v-5h6v5" stroke="currentColor" stroke-width="2"/></svg>@break
  @case('arrow')<svg viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>@break
  @case('check')<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="12" cy="12" r="10" fill="currentColor" opacity=".15"/><path d="M7.5 12.5l3 3 6-6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>@break
  @case('star')<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2l3 6.5 7 .8-5.2 4.8 1.4 7L12 17.6 5.8 21l1.4-7L2 9.3l7-.8z" fill="currentColor"/></svg>@break
  @default<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M3 12h4l2-5 3 10 2-5h7" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
@endswitch
