@extends('admin.layout')
@section('title', 'Pengaturan')

@section('content')
<div class="top"><h1>Pengaturan: {{ $groups[$group]['label'] }}</h1></div>
<nav class="tabs">
  @foreach ($groups as $key => $g)
    <a href="{{ route('admin.settings.edit', $key) }}" class="{{ $key === $group ? 'on' : '' }}">{{ $g['label'] }}</a>
  @endforeach
</nav>
<form method="POST" action="{{ route('admin.settings.update', $group) }}" enctype="multipart/form-data" class="card">
  @csrf @method('PUT')
  @foreach ($fields as $field)
    @include('admin.partials.field', ['field' => $field, 'value' => $values[$field['name']] ?? ($field['default'] ?? null)])
  @endforeach
  <div class="actions"><button type="submit" class="btn btn-p">Simpan pengaturan</button></div>
</form>
@endsection
