@extends('admin.layout')
@section('title', $item->exists ? 'Ubah '.$config['singular'] : 'Tambah '.$config['singular'])

@section('content')
<div class="top">
  <h1>{{ $item->exists ? 'Ubah '.$config['singular'] : 'Tambah '.$config['singular'] }}</h1>
  <a class="btn btn-g" href="{{ route('admin.resource.index', $config['key']) }}">Kembali ke daftar</a>
</div>

<form method="POST" enctype="multipart/form-data" class="card"
      action="{{ $item->exists ? route('admin.resource.update', [$config['key'], $item->id]) : route('admin.resource.store', $config['key']) }}">
  @csrf
  @if ($item->exists) @method('PUT') @endif
  @foreach ($config['fields'] as $field)
    @include('admin.partials.field', ['field' => $field, 'value' => $item->{$field['name']}])
  @endforeach
  <div class="actions"><button type="submit" class="btn btn-p">Simpan</button></div>
</form>

@if ($item->exists)
<form method="POST" action="{{ route('admin.resource.destroy', [$config['key'], $item->id]) }}" onsubmit="return confirm('Hapus {{ $config['singular'] }} ini? Tindakan ini tidak dapat dibatalkan.')" style="margin-top:16px">
  @csrf @method('DELETE')
  <button type="submit" class="btn btn-d">Hapus {{ $config['singular'] }}</button>
</form>
@endif
@endsection
