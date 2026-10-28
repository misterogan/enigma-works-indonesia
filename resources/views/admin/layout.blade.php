<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title>@yield('title', 'Backoffice') | {{ $set('company_name', 'Enigma Works Indonesia') }}</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
:root{--bg:#F4F6FA;--card:#fff;--ink:#0B1324;--ink2:#5B6880;--line:#E2E7F0;--accent:#0FB5A3;--accent2:#0A8F81;--night:#081B3A;--danger:#DC3545;color-scheme:light}
*{box-sizing:border-box}
body{margin:0;font-family:Inter,"Segoe UI",system-ui,sans-serif;background:var(--bg);color:var(--ink);font-size:15px;line-height:1.5}
a{color:var(--accent2)}
.shell{display:grid;grid-template-columns:250px 1fr;min-height:100vh}
.side{background:var(--night);color:#C9D6EE;padding:24px 16px;position:sticky;top:0;height:100vh;overflow:auto}
.side .brand{display:block;color:#fff;font-weight:700;font-size:17px;text-decoration:none;padding:0 10px 20px;border-bottom:1px solid #1C3360;margin-bottom:16px}
.side .brand small{display:block;font-weight:500;font-size:12px;color:#7FB0E8;margin-top:2px}
.side h6{font-size:11px;letter-spacing:.14em;text-transform:uppercase;color:#6F88B3;margin:20px 10px 8px}
.side a.nav{display:block;padding:9px 12px;border-radius:10px;color:#C9D6EE;text-decoration:none;font-weight:500}
.side a.nav:hover{background:#10284F;color:#fff}
.side a.nav.on{background:#13305E;color:#fff}
.side form{margin-top:24px;padding:0 10px}
.side button{background:none;border:1px solid #2A4374;color:#C9D6EE;border-radius:10px;padding:8px 12px;cursor:pointer;width:100%}
.main{padding:32px clamp(16px,3vw,40px);min-width:0}
.top{display:flex;justify-content:space-between;align-items:center;gap:16px;flex-wrap:wrap;margin-bottom:24px}
.top h1{font-size:24px;margin:0;letter-spacing:-0.02em}
.card{background:var(--card);border:1px solid var(--line);border-radius:16px;padding:24px}
.btn{display:inline-flex;align-items:center;gap:8px;padding:10px 18px;border-radius:10px;border:1px solid transparent;font:600 14px Inter,sans-serif;text-decoration:none;cursor:pointer}
.btn-p{background:var(--accent);color:#04241F}
.btn-p:hover{background:#2BD3C0}
.btn-g{background:#fff;border-color:var(--line);color:var(--ink)}
.btn-d{background:#fff;border-color:#F3C2C7;color:var(--danger)}
.flash{background:#E6F8F5;border:1px solid #A8E6DD;color:#065F55;padding:12px 16px;border-radius:12px;margin-bottom:20px}
.errors{background:#FDECEE;border:1px solid #F3C2C7;color:#8A1C27;padding:12px 16px;border-radius:12px;margin-bottom:20px}
.errors ul{margin:6px 0 0;padding-left:18px}
table{width:100%;border-collapse:collapse}
th,td{text-align:left;padding:12px 10px;border-bottom:1px solid var(--line);vertical-align:middle}
th{font-size:12px;text-transform:uppercase;letter-spacing:.06em;color:var(--ink2)}
.table-wrap{overflow-x:auto}
.yes{color:var(--accent2);font-weight:600}.no{color:var(--ink2)}
.tabs{display:flex;flex-wrap:wrap;gap:6px;margin-bottom:20px}
.tabs a{padding:8px 14px;border-radius:999px;border:1px solid var(--line);background:#fff;text-decoration:none;color:var(--ink2);font-weight:600;font-size:14px}
.tabs a.on{background:var(--ink);color:#fff;border-color:var(--ink)}
.field{display:grid;gap:6px;margin-bottom:20px}
.field label{font-weight:600;font-size:14px}
.field .help{font-size:13px;color:var(--ink2)}
.field input[type=text],.field input[type=number],.field input[type=datetime-local],.field input[type=email],.field input[type=password],.field select,.field textarea{width:100%;font:inherit;padding:11px 12px;border:1.5px solid var(--line);border-radius:10px;background:#FAFBFD;color:var(--ink)}
.field input:focus,.field select:focus,.field textarea:focus{outline:none;border-color:var(--accent);background:#fff}
.field textarea{min-height:110px;resize:vertical}
.field textarea.md{min-height:420px;font-family:ui-monospace,Menlo,Consolas,monospace;font-size:14px}
.check{display:flex;align-items:center;gap:10px;font-weight:600}
.check input{width:18px;height:18px;accent-color:var(--accent)}
.thumb{max-width:220px;border-radius:10px;border:1px solid var(--line)}
.actions{display:flex;gap:10px;flex-wrap:wrap;position:sticky;bottom:0;background:var(--bg);padding:16px 0}
.grid-stats{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:16px}
.stat b{display:block;font-size:30px}
.muted{color:var(--ink2)}
.search{display:flex;gap:8px}
.search input{padding:9px 12px;border:1px solid var(--line);border-radius:10px;font:inherit}
@media (max-width:860px){.shell{grid-template-columns:1fr}.side{position:static;height:auto}}
</style>
</head>
<body>
<div class="shell">
  <aside class="side">
    <a href="{{ route('admin.dashboard') }}" class="brand">{{ $set('company_name') }}<small>Backoffice website</small></a>
    <a class="nav {{ request()->routeIs('admin.dashboard') ? 'on' : '' }}" href="{{ route('admin.dashboard') }}">Ringkasan</a>
    <h6>Konten</h6>
    @foreach (config('admin.resources') as $key => $r)
      <a class="nav {{ request()->route('resource') === $key ? 'on' : '' }}" href="{{ route('admin.resource.index', $key) }}">{{ $r['label'] }}</a>
    @endforeach
    <h6>Pengaturan</h6>
    @foreach (config('admin.settings') as $key => $g)
      <a class="nav {{ request()->route('group') === $key ? 'on' : '' }}" href="{{ route('admin.settings.edit', $key) }}">{{ $g['label'] }}</a>
    @endforeach
    <h6>Website</h6>
    <a class="nav" href="{{ route('home') }}" target="_blank" rel="noopener">Lihat website</a>
    <form method="POST" action="{{ route('admin.logout') }}">@csrf<button type="submit">Keluar</button></form>
  </aside>
  <main class="main">
    @if (session('status'))<div class="flash">{{ session('status') }}</div>@endif
    @if ($errors->any())
      <div class="errors">Mohon periksa kembali isian berikut:<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif
    @yield('content')
  </main>
</div>
</body>
</html>
