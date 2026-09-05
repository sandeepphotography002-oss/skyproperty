@php
    $s      = config('site');
    /* Badge har admin page par dikhta hai, isliye layout mein hai.
       try/catch isliye ki migration se pehle bhi panel khul jaye. */
    $unseen = 0;
    try { $unseen = \App\Models\Enquiry::unseen()->count(); } catch (\Throwable $e) {}
@endphp
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title>{{ $title ?? 'Dashboard' }} — Sky Property Admin</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
/* Rang logo se -- navy mukhya, green uchhaal ke liye. */
:root{--ink:#1c2419;--muted:#616b5c;--line:#e0e4da;--soft:#eef2e8;
  --brand:#51873f;--brand-d:#416e33;--brand-deep:#1e3a17;
  --navy:#093b65;--gold:#b8802a}
*{box-sizing:border-box}
body{margin:0;background:#f2f5f3;color:var(--ink);font:15px/1.6 Inter,system-ui,sans-serif}
a{color:var(--brand);text-decoration:none}
a:hover{text-decoration:underline}
h1,h2,h3{margin:0 0 12px;line-height:1.25}
h1{font-size:24px}h2{font-size:19px}h3{font-size:16px}

.shell{display:grid;grid-template-columns:238px 1fr;min-height:100vh}

.side{background:var(--brand-deep);color:#c6d2bd;padding:20px 0}
.side-brand{padding:0 20px 18px;border-bottom:1px solid rgba(255,255,255,.14);margin-bottom:14px}
.side-brand b{display:block;color:#fff;font-size:16px}
.side-brand span{font-size:11.5px;color:#93a58b;letter-spacing:.05em;text-transform:uppercase}
.side a.item{display:flex;align-items:center;gap:11px;padding:11px 20px;color:#c6d2bd;font-size:14.5px}
.side a.item:hover{background:rgba(255,255,255,.09);color:#fff;text-decoration:none}
.side a.item.on{background:var(--brand);color:#fff;font-weight:600}
.side .grp{padding:16px 20px 6px;font-size:11px;color:#7f9077;text-transform:uppercase;letter-spacing:.08em}
.badge{margin-left:auto;background:#d64545;color:#fff;border-radius:99px;
  padding:1px 8px;font-size:11.5px;font-weight:700;min-width:20px;text-align:center}
@keyframes blip{0%,100%{opacity:1}50%{opacity:.45}}
.badge.live{animation:blip 1.3s ease-in-out infinite}

.main{padding:24px 28px 60px;min-width:0}
.top{display:flex;align-items:center;gap:14px;flex-wrap:wrap;margin-bottom:22px}
.top .sp{margin-left:auto;display:flex;gap:9px;align-items:center}

.btn{display:inline-flex;align-items:center;gap:8px;border:0;cursor:pointer;padding:10px 17px;
  border-radius:9px;font-weight:600;font-size:14px;font-family:inherit;transition:background .15s}
.btn:hover{text-decoration:none}
.btn-primary{background:var(--brand);color:#fff}
.btn-primary:hover{background:var(--brand-d)}
.btn-ghost{background:#fff;color:var(--ink);border:1px solid var(--line)}
.btn-danger{background:#d64545;color:#fff}
.btn-sm{padding:6px 12px;font-size:13px}

.card{background:#fff;border:1px solid var(--line);border-radius:12px;padding:20px 22px;margin-bottom:20px}
.tiles{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:22px}
.tile{background:#fff;border:1px solid var(--line);border-radius:12px;padding:18px 20px}
.tile b{display:block;font-size:29px;line-height:1.15}
.tile span{color:var(--muted);font-size:13.5px}
.tile.hot{border-color:#f0c9c9;background:#fff7f7}
.tile.hot b{color:#c0392b}

table{width:100%;border-collapse:collapse;font-size:14.5px}
th,td{border-bottom:1px solid var(--line);padding:11px 12px;text-align:left;vertical-align:middle}
th{background:var(--soft);font-weight:600;font-size:13px;text-transform:uppercase;letter-spacing:.03em;color:var(--muted)}
tr:hover td{background:#fafcfb}
.tbl-wrap{overflow-x:auto;background:#fff;border:1px solid var(--line);border-radius:12px}

.pill{display:inline-block;padding:3px 10px;border-radius:99px;font-size:12px;font-weight:600}
.pill-ok{background:#e8f5ee;color:#1d5b3d}
.pill-warn{background:#fdf3e3;color:#8a6320}
.pill-off{background:#eef1ef;color:#67736e}
.pill-new{background:#fdeceb;color:#a63a33}

.alert{padding:12px 16px;border-radius:10px;margin-bottom:18px;font-size:14.5px}
.alert-ok{background:#e8f5ee;color:#1d5b3d;border:1px solid #bfe0cd}
.alert-err{background:#fdeceb;color:#8f2c26;border:1px solid #f3c9c6}

label{display:block;font-size:13px;font-weight:600;margin-bottom:5px}
input[type=text],input[type=number],input[type=email],input[type=password],input[type=tel],select,textarea{
  width:100%;padding:10px 12px;border:1px solid var(--line);border-radius:9px;
  font-size:14.5px;font-family:inherit;color:var(--ink);background:#fff}
textarea{resize:vertical;min-height:90px}
.row{display:grid;gap:14px;margin-bottom:14px}
.r2{grid-template-columns:1fr 1fr}
.r3{grid-template-columns:1fr 1fr 1fr}
.r4{grid-template-columns:1fr 1fr 1fr 1fr}
.hint{font-size:12.5px;color:var(--muted);margin-top:4px}

.empty{padding:40px 20px;text-align:center;color:var(--muted)}

@media(max-width:900px){
  .shell{grid-template-columns:1fr}
  .side{display:flex;overflow-x:auto;padding:10px;gap:6px;align-items:center}
  .side-brand,.side .grp{display:none}
  .side a.item{white-space:nowrap;border-radius:8px;padding:9px 14px}
  .tiles{grid-template-columns:1fr 1fr}
  .r2,.r3,.r4{grid-template-columns:1fr}
  .main{padding:18px 16px 50px}
}
</style>
</head>
<body>
<div class="shell">

  <nav class="side">
    <div class="side-brand">
      <b>Sky Property</b>
      <span>Admin Panel</span>
    </div>

    <div class="grp">Manage</div>
    <a class="item {{ request()->routeIs('admin.dashboard') ? 'on' : '' }}" href="{{ route('admin.dashboard') }}">📊 Dashboard</a>
    <a class="item {{ request()->routeIs('admin.properties.*') ? 'on' : '' }}" href="{{ route('admin.properties.index') }}">🏡 Properties</a>
    <a class="item {{ request()->routeIs('admin.enquiries.*') ? 'on' : '' }}" href="{{ route('admin.enquiries.index') }}">
      📩 Enquiries
      @if($unseen)<span class="badge live">{{ $unseen }}</span>@endif
    </a>
    <a class="item" href="{{ route('admin.properties.create') }}">➕ Add Property</a>
    <a class="item {{ request()->routeIs('admin.posts.*') ? 'on' : '' }}" href="{{ route('admin.posts.index') }}">📝 Blog</a>

    <div class="grp">Site</div>
    <a class="item" href="{{ route('home') }}" target="_blank">🌐 View Website</a>

    <form method="POST" action="{{ route('logout') }}" style="padding:6px 12px;margin-top:8px">
      @csrf
      <button class="btn btn-ghost btn-sm" style="width:100%;justify-content:center">Log out</button>
    </form>
  </nav>

  <main class="main">
    @if(session('ok'))<div class="alert alert-ok">{{ session('ok') }}</div>@endif
    @if($errors->any())
      <div class="alert alert-err">
        @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
      </div>
    @endif

    @yield('content')
  </main>
</div>
</body>
</html>
