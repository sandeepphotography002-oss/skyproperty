@php
    $s        = config('site');
    $pageTitle = trim($title ?? '') !== '' ? $title . ' | ' . $s['short_name'] : $s['name'] . ' — ' . $s['tagline'];
    $pageDesc  = trim($description ?? '') !== '' ? $description
        : 'Plots, farmhouses, cottages and land for sale in Morni Hills, Panchkula. Clear paperwork, honest rates, site visits arranged. Call ' . $s['phone'] . '.';
@endphp
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ $pageTitle }}</title>
<meta name="description" content="{{ $pageDesc }}">
<link rel="canonical" href="{{ url()->current() }}">
<meta name="robots" content="index, follow">

@if($v = config('site.google_verification'))
  <meta name="google-site-verification" content="{{ $v }}">
@endif

<link rel="sitemap" type="application/xml" href="{{ url('/sitemap.xml') }}">

<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ $pageDesc }}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

{{-- LocalBusiness schema. RealEstateAgent hi sahi type hai -- Google
     ko "ye dukaan hai" kehne se behtar hai "ye property dalal hai",
     kyunki local search wahi dikhata hai. --}}
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type'    => 'RealEstateAgent',
    '@id'      => url('/') . '/#business',
    'name'     => $s['name'],
    'url'      => url('/'),
    'telephone'=> $s['phone'],
    'email'    => $s['email'],
    'image'    => url('/') . '/og-cover.jpg',
    'address'  => [
        '@type'           => 'PostalAddress',
        'streetAddress'   => $s['address']['street'],
        'addressLocality' => $s['address']['city'],
        'addressRegion'   => $s['address']['state'],
        'postalCode'      => $s['address']['pincode'],
        'addressCountry'  => $s['address']['country'],
    ],
    'geo' => ['@type' => 'GeoCoordinates', 'latitude' => $s['geo']['lat'], 'longitude' => $s['geo']['lng']],
    'areaServed' => array_map(fn ($a) => ['@type' => 'Place', 'name' => $a], $s['areas']),
    'openingHours' => 'Mo-Su 09:00-19:00',
    'priceRange'   => '₹₹',
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>

<style>
:root{
  --ink:#1b2420; --muted:#5f6d66; --line:#e3e8e4; --bg:#ffffff; --soft:#f6f8f6;
  --green:#2f6b4f; --green-d:#245740; --gold:#c08a2e; --shadow:0 6px 28px rgba(20,40,30,.08);
  --radius:14px;
}
*{box-sizing:border-box}
body{margin:0;background:var(--bg);color:var(--ink);font:16px/1.7 Inter,system-ui,-apple-system,"Segoe UI",sans-serif;-webkit-font-smoothing:antialiased}
h1,h2,h3,h4{font-family:Fraunces,Georgia,serif;line-height:1.22;margin:0 0 14px;letter-spacing:-.01em}
h1{font-size:clamp(30px,4.6vw,50px)}
h2{font-size:clamp(24px,3.2vw,34px)}
h3{font-size:20px}
p{margin:0 0 15px}
a{color:var(--green);text-decoration:none}
a:hover{text-decoration:underline}
img{max-width:100%;display:block}
.wrap{max-width:1200px;margin:0 auto;padding:0 20px}
.sec{padding:62px 0}
.sec-soft{background:var(--soft)}
.center{text-align:center}
.lead{color:var(--muted);font-size:17px;max-width:660px}
.center .lead{margin-left:auto;margin-right:auto}

/* ── buttons ── */
.btn{display:inline-flex;align-items:center;gap:9px;border:0;cursor:pointer;
  padding:13px 24px;border-radius:10px;font-weight:600;font-size:15px;font-family:inherit;
  transition:transform .15s, box-shadow .15s, background .15s}
.btn:hover{text-decoration:none;transform:translateY(-1px)}
.btn-primary{background:var(--green);color:#fff;box-shadow:0 4px 16px rgba(47,107,79,.28)}
.btn-primary:hover{background:var(--green-d)}
.btn-gold{background:var(--gold);color:#fff}
.btn-ghost{background:#fff;color:var(--ink);border:1px solid var(--line)}
.btn-block{width:100%;justify-content:center}

/* ── header ── */
.hdr{position:sticky;top:0;z-index:60;background:rgba(255,255,255,.96);backdrop-filter:blur(8px);border-bottom:1px solid var(--line)}
.hdr-in{display:flex;align-items:center;gap:22px;height:70px}
.brand{display:flex;align-items:center;gap:11px;font-family:Fraunces,serif;font-weight:700;font-size:20px;color:var(--ink)}
.brand:hover{text-decoration:none}
.brand-mark{width:36px;height:36px;border-radius:9px;background:linear-gradient(135deg,var(--green),#4b9a72);
  color:#fff;display:grid;place-items:center;font-size:17px;flex:0 0 36px}
.brand small{display:block;font-family:Inter,sans-serif;font-size:11px;font-weight:500;color:var(--muted);letter-spacing:.04em;text-transform:uppercase}
.nav{margin-left:auto;display:flex;align-items:center;gap:26px}
.nav a{color:var(--ink);font-size:15px;font-weight:500}
.nav a.on{color:var(--green);font-weight:600}
.hdr-call{display:inline-flex;align-items:center;gap:8px;background:var(--green);color:#fff;
  padding:10px 18px;border-radius:9px;font-weight:600;font-size:14.5px}
.hdr-call:hover{background:var(--green-d);text-decoration:none}
.burger{display:none;margin-left:auto;background:none;border:0;font-size:26px;cursor:pointer;color:var(--ink);line-height:1;padding:4px 8px}

/* ── cards ── */
.grid{display:grid;gap:24px}
.g3{grid-template-columns:repeat(3,1fr)}
.g4{grid-template-columns:repeat(4,1fr)}
.card{background:#fff;border:1px solid var(--line);border-radius:var(--radius);overflow:hidden;
  display:flex;flex-direction:column;transition:transform .18s, box-shadow .18s}
.card:hover{transform:translateY(-3px);box-shadow:var(--shadow)}
.card-img{position:relative;aspect-ratio:4/3;overflow:hidden;background:var(--soft)}
.card-img img{width:100%;height:100%;object-fit:cover;transition:transform .4s}
.card:hover .card-img img{transform:scale(1.04)}
.card-tag{position:absolute;top:12px;left:12px;background:rgba(27,36,32,.86);color:#fff;
  padding:5px 11px;border-radius:7px;font-size:12px;font-weight:600;letter-spacing:.02em}
.card-status{position:absolute;top:12px;right:12px;padding:5px 11px;border-radius:7px;font-size:12px;font-weight:700;color:#fff}
.st-sold{background:#b23b3b}.st-rented{background:#8a6d1f}
.card-body{padding:17px 18px 19px;display:flex;flex-direction:column;flex:1}
.card-price{font-family:Fraunces,serif;font-size:21px;font-weight:700;color:var(--green);margin-bottom:5px}
.card-title{font-size:16px;font-weight:600;margin:0 0 7px;line-height:1.4}
.card-title a{color:var(--ink)}
.card-loc{color:var(--muted);font-size:13.5px;margin:0 0 13px}
.card-meta{display:flex;flex-wrap:wrap;gap:7px;margin-top:auto;padding-top:13px;border-top:1px solid var(--line)}
.chip{background:var(--soft);border-radius:7px;padding:5px 10px;font-size:12.5px;color:var(--muted);font-weight:500}

/* ── footer ── */
.ftr{background:#182420;color:#c8d3cd;padding:56px 0 26px;margin-top:70px}
.ftr h4{color:#fff;font-family:Inter,sans-serif;font-size:14px;text-transform:uppercase;letter-spacing:.07em;margin-bottom:16px}
.ftr a{color:#c8d3cd;font-size:14.5px}
.ftr a:hover{color:#fff}
.ftr-grid{display:grid;grid-template-columns:1.6fr 1fr 1fr 1.3fr;gap:36px}
.ftr ul{list-style:none;padding:0;margin:0}
.ftr li{margin-bottom:9px}
.ftr-bottom{border-top:1px solid #2a3a34;margin-top:36px;padding-top:20px;
  display:flex;justify-content:space-between;gap:14px;flex-wrap:wrap;font-size:13.5px;color:#8fa199}

.alert{padding:13px 17px;border-radius:10px;margin-bottom:18px;font-size:14.5px}
.alert-ok{background:#e8f5ee;color:#1d5b3d;border:1px solid #bfe0cd}
.alert-err{background:#fdeceb;color:#8f2c26;border:1px solid #f3c9c6}

/* ── whatsapp ── */
.wa{position:fixed;right:18px;bottom:18px;z-index:70;width:54px;height:54px;border-radius:50%;
  background:#25d366;display:grid;place-items:center;box-shadow:0 6px 20px rgba(0,0,0,.22)}
.wa:hover{text-decoration:none;transform:scale(1.06)}
.wa svg{width:29px;height:29px;fill:#fff}

@media(max-width:980px){
  .g4{grid-template-columns:repeat(2,1fr)}
  .g3{grid-template-columns:repeat(2,1fr)}
  .ftr-grid{grid-template-columns:1fr 1fr;gap:28px}
}
@media(max-width:640px){
  .sec{padding:44px 0}
  .g3,.g4{grid-template-columns:1fr}
  .ftr-grid{grid-template-columns:1fr}
  .burger{display:block}
  .nav{position:absolute;top:70px;left:0;right:0;background:#fff;border-bottom:1px solid var(--line);
    flex-direction:column;align-items:stretch;gap:0;padding:6px 20px 16px;display:none;box-shadow:var(--shadow)}
  .nav.open{display:flex}
  .nav a{padding:12px 0;border-bottom:1px solid var(--line)}
  .nav .hdr-call{margin-top:12px;justify-content:center;border:0}
}
@yield('style')
</style>
</head>
<body>

<header class="hdr">
  <div class="wrap hdr-in">
    <a class="brand" href="{{ route('home') }}">
      <span class="brand-mark">⛰</span>
      <span>Sky Property<small>Morni Hills</small></span>
    </a>

    <button class="burger" id="burger" aria-label="Menu" aria-expanded="false" aria-controls="nav">☰</button>

    <nav class="nav" id="nav">
      <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'on' : '' }}">Home</a>
      <a href="{{ route('properties') }}" class="{{ request()->routeIs('properties') ? 'on' : '' }}">Properties</a>
      <a href="{{ route('blog') }}" class="{{ request()->routeIs('blog', 'post') ? 'on' : '' }}">Guide</a>
      <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'on' : '' }}">About</a>
      <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'on' : '' }}">Contact</a>
      <a class="hdr-call" href="tel:{{ $s['phone_link'] }}">📞 {{ $s['phone'] }}</a>
    </nav>
  </div>
</header>

@yield('content')

<footer class="ftr">
  <div class="wrap">
    <div class="ftr-grid">
      <div>
        <h4>{{ $s['name'] }}</h4>
        <p style="font-size:14.5px;line-height:1.75">
          Plots, farmhouses, cottages and land in Morni Hills and around Panchkula.
          We show you the ground, the papers and the honest rate &mdash; in that order.
        </p>
      </div>

      <div>
        <h4>Explore</h4>
        <ul>
          <li><a href="{{ route('properties') }}">All Properties</a></li>
          <li><a href="{{ route('properties', ['type' => 'plot']) }}">Plots</a></li>
          <li><a href="{{ route('properties', ['type' => 'land']) }}">Agricultural Land</a></li>
          <li><a href="{{ route('properties', ['type' => 'farmhouse']) }}">Farmhouses</a></li>
          <li><a href="{{ route('properties', ['type' => 'cottage']) }}">Cottages</a></li>
          <li><a href="{{ route('properties', ['listing' => 'rent']) }}">For Rent</a></li>
        </ul>
      </div>

      <div>
        <h4>Company</h4>
        <ul>
          <li><a href="{{ route('blog') }}">Morni Property Guide</a></li>
          <li><a href="{{ route('about') }}">About Us</a></li>
          <li><a href="{{ route('contact') }}">Contact</a></li>
          <li><a href="{{ route('properties', ['type' => 'resort']) }}">Resorts</a></li>
          <li><a href="{{ route('properties', ['type' => 'homestay']) }}">Homestays</a></li>
        </ul>
      </div>

      <div>
        <h4>Reach Us</h4>
        <ul>
          <li><a href="tel:{{ $s['phone_link'] }}">📞 {{ $s['phone'] }}</a></li>
          <li><a href="mailto:{{ $s['email'] }}">✉ {{ $s['email'] }}</a></li>
          <li>📍 {{ $s['address_line'] }}</li>
          <li>🕘 {{ $s['hours'] }}</li>
        </ul>
      </div>
    </div>

    <div class="ftr-bottom">
      <span>&copy; {{ date('Y') }} {{ $s['name'] }}. All rights reserved.</span>
      <span>Serving {{ implode(' · ', array_slice($s['areas'], 0, 5)) }}</span>
    </div>
  </div>
</footer>

<a class="wa" href="https://wa.me/{{ $s['whatsapp'] }}?text={{ urlencode('Hello, I am interested in a property in Morni Hills.') }}"
   target="_blank" rel="noopener" aria-label="WhatsApp par baat karein">
  <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M17.47 14.38c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15s-.77.97-.94 1.17c-.17.2-.35.22-.65.07-.3-.15-1.25-.46-2.39-1.47-.88-.79-1.48-1.76-1.65-2.06-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.08-.15-.67-1.61-.92-2.21-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.48s1.06 2.88 1.21 3.08c.15.2 2.1 3.2 5.08 4.49.71.31 1.26.49 1.69.63.71.23 1.36.19 1.87.12.57-.09 1.76-.72 2.01-1.41.25-.7.25-1.29.17-1.42-.07-.13-.27-.2-.57-.35M12.05 21.8h-.02c-1.74 0-3.45-.47-4.94-1.35l-.35-.21-3.67.96.98-3.58-.23-.37a9.86 9.86 0 0 1-1.51-5.26c0-5.45 4.44-9.88 9.9-9.88 2.64 0 5.13 1.03 7 2.9a9.82 9.82 0 0 1 2.9 6.99c0 5.45-4.44 9.89-9.9 9.89M20.52 3.45A11.78 11.78 0 0 0 12.05 0C5.5 0 .17 5.33.17 11.88c0 2.09.55 4.14 1.59 5.94L.07 24l6.33-1.66a11.83 11.83 0 0 0 5.65 1.44h.01c6.54 0 11.87-5.33 11.88-11.88 0-3.17-1.24-6.15-3.48-8.4"/></svg>
</a>

<script>
  /* Mobile menu. Ek button, ek class -- library ki zaroorat nahi. */
  (function () {
    var b = document.getElementById('burger'), n = document.getElementById('nav');
    if (!b || !n) return;
    b.addEventListener('click', function () {
      var open = n.classList.toggle('open');
      b.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  })();
</script>
@yield('script')
</body>
</html>
