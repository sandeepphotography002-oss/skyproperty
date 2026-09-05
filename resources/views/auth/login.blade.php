<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title>Login — Sky Property Admin</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
:root{--ink:#1b2420;--muted:#6a7873;--line:#e3e8e4;--green:#2f6b4f;--green-d:#245740}
*{box-sizing:border-box}
body{margin:0;min-height:100vh;display:grid;place-items:center;padding:24px;
  background:linear-gradient(rgba(14,26,20,.72),rgba(14,26,20,.8)),
    url('https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=1600&q=65') center/cover fixed no-repeat;
  color:var(--ink);font:15px/1.6 Inter,system-ui,sans-serif}
.box{background:#fff;border-radius:16px;padding:34px 32px;width:100%;max-width:400px;
  box-shadow:0 18px 60px rgba(0,0,0,.32)}
.mark{width:48px;height:48px;border-radius:12px;background:linear-gradient(135deg,var(--green),#4b9a72);
  color:#fff;display:grid;place-items:center;font-size:23px;margin:0 auto 16px}
h1{font-size:21px;text-align:center;margin:0 0 4px}
.sub{text-align:center;color:var(--muted);font-size:14px;margin:0 0 24px}
label{display:block;font-size:13px;font-weight:600;margin-bottom:5px}
input[type=email],input[type=password]{width:100%;padding:11px 12px;border:1px solid var(--line);
  border-radius:9px;font-size:15px;font-family:inherit;color:var(--ink);margin-bottom:15px}
.btn{width:100%;border:0;cursor:pointer;background:var(--green);color:#fff;padding:12px;
  border-radius:9px;font-weight:600;font-size:15px;font-family:inherit}
.btn:hover{background:var(--green-d)}
.err{background:#fdeceb;color:#8f2c26;border:1px solid #f3c9c6;padding:11px 14px;
  border-radius:9px;margin-bottom:16px;font-size:14px}
.remember{display:flex;align-items:center;gap:8px;font-size:14px;font-weight:500;margin-bottom:18px}
.remember input{width:auto;margin:0}
.back{display:block;text-align:center;margin-top:18px;font-size:13.5px;color:var(--muted);text-decoration:none}
.back:hover{color:var(--green)}
</style>
</head>
<body>
<div class="box">
  <div class="mark">⛰</div>
  <h1>Sky Property</h1>
  <p class="sub">Admin panel</p>

  @if($errors->any())
    <div class="err">{{ $errors->first() }}</div>
  @endif

  <form method="POST" action="{{ route('login.post') }}">
    @csrf

    <label for="lEmail">Email</label>
    <input type="email" id="lEmail" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">

    <label for="lPass">Password</label>
    <input type="password" id="lPass" name="password" required autocomplete="current-password">

    <label class="remember">
      <input type="checkbox" name="remember" value="1"> Yaad rakho
    </label>

    <button class="btn" type="submit">Log in</button>
  </form>

  <a class="back" href="{{ url('/') }}">← Website par wapas</a>
</div>
</body>
</html>
