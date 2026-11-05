@extends('admin.layout')
@section('title', 'Ringkasan')

@section('content')
<div class="top"><h1>Ringkasan</h1><a class="btn btn-g" href="{{ route('home') }}" target="_blank" rel="noopener">Lihat website</a></div>
<div class="grid-stats">
  @foreach ($counts as $key => $c)
    <a class="card stat" href="{{ route('admin.resource.index', $key) }}" style="text-decoration:none;color:inherit"><b>{{ $c['count'] }}</b><span class="muted">{{ $c['label'] }}</span></a>
  @endforeach
</div>
<div class="card" style="margin-top:24px">
  <h3 style="margin-top:0">Tips singkat</h3>
  <ul class="muted" style="margin:0;padding-left:18px;line-height:1.8">
    <li>Teks banner, judul bagian, dan data perusahaan ada di menu <b>Pengaturan</b>.</li>
    <li>Beri <b>*bintang*</b> pada kata di judul untuk menampilkannya dengan warna gradasi.</li>
    <li>Terbitkan minimal satu artikel per minggu di <b>Artikel blog</b> untuk membantu SEO.</li>
    <li>Testimoni hanya tampil di website setelah opsi <b>Testimoni sudah disetujui</b> dicentang.</li>
  </ul>
</div>
@endsection
