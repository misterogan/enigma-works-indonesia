@extends('admin.layout')
@section('title', $config['label'])

@section('content')
<div class="top">
  <h1>{{ $config['label'] }}</h1>
  <div style="display:flex;gap:10px;flex-wrap:wrap">
    <form class="search" method="GET"><input type="search" name="q" value="{{ request('q') }}" placeholder="Cari…"><button class="btn btn-g" type="submit">Cari</button></form>
    <a class="btn btn-p" href="{{ route('admin.resource.create', $config['key']) }}">Tambah {{ $config['singular'] }}</a>
  </div>
</div>
<div class="card table-wrap">
  <table>
    <thead><tr>@foreach ($config['columns'] as $label)<th>{{ $label }}</th>@endforeach<th></th></tr></thead>
    <tbody>
      @forelse ($items as $item)
        <tr>
          @foreach ($config['columns'] as $col => $label)
            @php $v = $item->{$col}; @endphp
            <td>
              @if (is_bool($v))
                <span class="{{ $v ? 'yes' : 'no' }}">{{ $v ? 'Ya' : 'Tidak' }}</span>
              @elseif ($v instanceof \DateTimeInterface)
                {{ $v->translatedFormat('j M Y') }}
              @elseif ($loop->first)
                <a href="{{ route('admin.resource.edit', [$config['key'], $item->id]) }}"><b>{{ \Illuminate\Support\Str::limit((string) $v, 70) }}</b></a>
              @else
                {{ \Illuminate\Support\Str::limit(is_array($v) ? implode(', ', $v) : (string) $v, 50) }}
              @endif
            </td>
          @endforeach
          <td style="text-align:right;white-space:nowrap">
            <a class="btn btn-g" href="{{ route('admin.resource.edit', [$config['key'], $item->id]) }}">Ubah</a>
          </td>
        </tr>
      @empty
        <tr><td colspan="{{ count($config['columns']) + 1 }}" class="muted">Belum ada data.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
<div style="margin-top:16px">{{ $items->links('admin.partials.pagination') }}</div>
@endsection
