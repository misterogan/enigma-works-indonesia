<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title>Masuk Backoffice</title>
<style>
body{margin:0;min-height:100vh;display:grid;place-items:center;background:#081B3A;font-family:Inter,"Segoe UI",system-ui,sans-serif;color:#0B1324;padding:20px}
.box{background:#fff;border-radius:20px;padding:36px;width:100%;max-width:400px;box-shadow:0 30px 60px -20px rgba(0,0,0,.5)}
h1{font-size:22px;margin:0 0 6px}
p{color:#5B6880;margin:0 0 24px;font-size:14px}
label{display:block;font-weight:600;font-size:14px;margin:0 0 6px}
input[type=email],input[type=password]{width:100%;padding:12px;border:1.5px solid #E2E7F0;border-radius:10px;font:inherit;margin-bottom:16px;box-sizing:border-box}
input:focus{outline:none;border-color:#0FB5A3}
.check{display:flex;gap:8px;align-items:center;font-size:14px;margin-bottom:20px}
button{width:100%;padding:13px;border:none;border-radius:10px;background:#0FB5A3;color:#04241F;font-weight:700;font-size:15px;cursor:pointer}
.err{background:#FDECEE;color:#8A1C27;padding:10px 12px;border-radius:10px;font-size:14px;margin-bottom:16px}
</style>
</head>
<body>
<form class="box" method="POST" action="{{ route('admin.login') }}">
  @csrf
  <h1>Masuk backoffice</h1>
  <p>{{ $set('company_name', 'Enigma Works Indonesia') }}</p>
  @if ($errors->any())<div class="err">{{ $errors->first() }}</div>@endif
  <label for="email">Email</label>
  <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
  <label for="password">Password</label>
  <input id="password" type="password" name="password" required autocomplete="current-password">
  <label class="check"><input type="checkbox" name="remember" value="1"> Ingat saya</label>
  <button type="submit">Masuk</button>
</form>
</body>
</html>
