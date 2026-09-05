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

{{-- Favicon ke liye sirf pahaad wala nishaan. Poora logo 16px par
     kaali lakeeron ka gucchha ban jaata hai -- naam padha hi nahi
     jaata, aur tab ki pehchaan chali jaati hai. --}}
<link rel="icon" type="image/png" href="{{ asset('brand/mark.png') }}">
<link rel="apple-touch-icon" href="{{ asset('brand/logo.png') }}">
<meta property="og:image" content="{{ asset('brand/logo.png') }}">

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
    'image'    => asset('brand/logo.png'),
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
/* Ground safed nahi, halka cream hai. Flat #fff par photo aur card
   dono chipke hue lagte hain; cream par unke kinaare dikhte hain aur
   poora page mehnga lagta hai. Ye ek badlaav sabse zyada farak dalta
   hai, aur baaki sab uske aas-paas tay hua hai. */
/* Rang logo se aaye hain, meri pasand se nahi. Navy #093b65 aur green
   #51873f seedha logo ki file se naape gaye hain, taaki site aur logo
   ek hi cheez lagein -- do alag hare rang aamne-saamne hamesha bure
   lagte hain. Navy mukhya hai (logo mein wahi bhaari hai), green
   uchhaal ke liye. */
:root{
  --ink:#16202b; --muted:#5c6a76; --line:#dfe4e9;
  --bg:#f9fafb; --soft:#eef2f6; --card:#ffffff;
  /* --brand hi mukhya rang hai. Naam "navy" nahi rakha kyunki agar
     kabhi brand ka rang badla, to naam jhooth bolne lagta. */
  --brand:#093b65; --brand-d:#062a4a; --brand-deep:#041d34;
  --leaf:#51873f; --leaf-d:#3f6d31;
  --gold:#b8802a; --gold-l:#d9a24a;
  --shadow-s:0 2px 10px rgba(30,45,35,.06);
  --shadow:0 10px 34px rgba(30,45,35,.10);
  --shadow-l:0 26px 70px rgba(20,35,25,.20);
  --radius:16px;
}
*{box-sizing:border-box}
body{margin:0;background:var(--bg);color:var(--ink);
  font:16px/1.72 Inter,system-ui,-apple-system,"Segoe UI",sans-serif;
  -webkit-font-smoothing:antialiased;text-rendering:optimizeLegibility}
h1,h2,h3,h4{font-family:Fraunces,Georgia,serif;line-height:1.16;margin:0 0 14px;letter-spacing:-.018em}
h1{font-size:clamp(32px,5vw,56px);letter-spacing:-.028em}
h2{font-size:clamp(25px,3.4vw,38px)}
h3{font-size:20px;letter-spacing:-.01em}
p{margin:0 0 15px}
a{color:var(--brand);text-decoration:none}
a:hover{text-decoration:underline}
img{max-width:100%;display:block}
.wrap{max-width:1200px;margin:0 auto;padding:0 20px}
.sec{padding:72px 0}
.sec-soft{background:var(--soft)}

/* Har bade section ke upar ek patli sunehri lakeer. Ye chhoti cheez
   page ko hisson mein baant deti hai bina ek aur border ke. */
.sec-soft{border-top:1px solid var(--line);border-bottom:1px solid var(--line)}

/* Scroll par halka sa upar aana. Bahut dheema rakha hai -- design ko
   sajaana nahi, sirf itna ki page zinda lage. Jinhone system mein
   animation band ki hui hai unke liye ye poori tarah band ho jaata
   hai; unke liye ye chakkar aane ki wajah banta hai. */
[data-rise]{opacity:0;transform:translateY(18px);
  transition:opacity .6s cubic-bezier(.22,.61,.36,1),transform .6s cubic-bezier(.22,.61,.36,1)}
[data-rise].in{opacity:1;transform:none}
@media(prefers-reduced-motion:reduce){
  [data-rise]{opacity:1;transform:none;transition:none}
  *{animation-duration:.001ms !important;transition-duration:.001ms !important}
}
.center{text-align:center}
.lead{color:var(--muted);font-size:17px;max-width:660px}
.center .lead{margin-left:auto;margin-right:auto}

/* ── buttons ── */
.btn{display:inline-flex;align-items:center;gap:9px;border:0;cursor:pointer;
  padding:14px 26px;border-radius:11px;font-weight:600;font-size:15px;font-family:inherit;
  letter-spacing:.005em;
  transition:transform .18s cubic-bezier(.22,.61,.36,1), box-shadow .18s, background .18s}
.btn:hover{text-decoration:none;transform:translateY(-2px)}
.btn:active{transform:translateY(0)}
.btn-primary{background:var(--brand);color:#fff;box-shadow:0 6px 18px rgba(43,99,71,.26)}
.btn-primary:hover{background:var(--brand-d);box-shadow:0 10px 26px rgba(43,99,71,.32)}
.btn-gold{background:linear-gradient(135deg,var(--gold-l),var(--gold));color:#fff;
  box-shadow:0 6px 18px rgba(184,128,42,.30)}
.btn-gold:hover{box-shadow:0 10px 26px rgba(184,128,42,.38)}
.btn-ghost{background:var(--card);color:var(--ink);border:1px solid var(--line);box-shadow:var(--shadow-s)}
.btn-ghost:hover{border-color:var(--brand);color:var(--brand)}
.btn-block{width:100%;justify-content:center}

/* ── header ── */
.hdr{position:sticky;top:0;z-index:60;background:rgba(251,248,242,.88);
  backdrop-filter:saturate(160%) blur(14px);-webkit-backdrop-filter:saturate(160%) blur(14px);
  border-bottom:1px solid transparent;transition:border-color .25s, box-shadow .25s, background .25s}
/* Scroll karte hi header ko kinaara aur halki chhaya mil jaati hai --
   tabhi jab uske neeche kuch ho. Shuru se lagi rehti to hero se juda
   hua lagta. */
.hdr.stuck{border-bottom-color:var(--line);box-shadow:0 4px 20px rgba(30,45,35,.07);background:rgba(251,248,242,.96)}
.hdr-in{display:flex;align-items:center;gap:22px;height:74px}
.brand{display:flex;align-items:center;gap:11px;font-family:Fraunces,serif;font-weight:700;font-size:20px;color:var(--ink)}
.brand:hover{text-decoration:none}
.brand-mark{width:auto;height:42px;flex:0 0 auto;display:block}
.brand small{display:block;font-family:Inter,sans-serif;font-size:11px;font-weight:500;color:var(--muted);letter-spacing:.04em;text-transform:uppercase}
.nav{margin-left:auto;display:flex;align-items:center;gap:26px}
.nav a{color:var(--ink);font-size:15px;font-weight:500}
.nav a.on{color:var(--brand);font-weight:600}
.hdr-call{display:inline-flex;align-items:center;gap:8px;background:var(--brand);color:#fff;
  padding:10px 18px;border-radius:9px;font-weight:600;font-size:14.5px}
.hdr-call:hover{background:var(--brand-d);text-decoration:none}
.burger{display:none;margin-left:auto;background:none;border:0;font-size:26px;cursor:pointer;color:var(--ink);line-height:1;padding:4px 8px}

/* ── cards ── */
.grid{display:grid;gap:24px}
.g3{grid-template-columns:repeat(3,1fr)}
.g4{grid-template-columns:repeat(4,1fr)}
.card{background:var(--card);border:1px solid var(--line);border-radius:var(--radius);overflow:hidden;
  display:flex;flex-direction:column;box-shadow:var(--shadow-s);
  transition:transform .26s cubic-bezier(.22,.61,.36,1), box-shadow .26s, border-color .26s}
.card:hover{transform:translateY(-5px);box-shadow:var(--shadow);border-color:#d8cbb4}
.card-img{position:relative;aspect-ratio:4/3;overflow:hidden;background:var(--soft)}
.card-img img{width:100%;height:100%;object-fit:cover;transition:transform .6s cubic-bezier(.22,.61,.36,1)}
.card:hover .card-img img{transform:scale(1.06)}
/* Photo ke neeche halka andhera, taaki uspar rakhe tag hamesha padhe
   ja sakein -- chahe photo halki ho ya gehri. */
.card-img:after{content:"";position:absolute;inset:0;pointer-events:none;
  background:linear-gradient(180deg,rgba(15,25,18,.28) 0%,rgba(15,25,18,0) 38%)}
.card-tag{position:absolute;top:12px;left:12px;z-index:2;
  background:rgba(20,38,28,.82);backdrop-filter:blur(6px);color:#fff;
  padding:6px 12px;border-radius:8px;font-size:12px;font-weight:600;letter-spacing:.03em}
.card-status{position:absolute;top:12px;right:12px;z-index:2;padding:6px 12px;border-radius:8px;
  font-size:12px;font-weight:700;color:#fff;letter-spacing:.03em}
.st-sold{background:#a83a3a}.st-rented{background:#8a6d1f}
.card-body{padding:18px 19px 20px;display:flex;flex-direction:column;flex:1}
.card-price{font-family:Fraunces,serif;font-size:23px;font-weight:700;color:var(--brand);
  margin-bottom:6px;letter-spacing:-.02em}
.card-title{font-size:16.5px;font-weight:600;margin:0 0 7px;line-height:1.4}
.card-title a{color:var(--ink)}
.card-title a:hover{color:var(--brand);text-decoration:none}
.card-loc{color:var(--muted);font-size:13.5px;margin:0 0 13px}
.card-meta{display:flex;flex-wrap:wrap;gap:7px;margin-top:auto;padding-top:14px;border-top:1px solid var(--line)}
.chip{background:var(--soft);border:1px solid #ece4d5;border-radius:8px;padding:5px 11px;
  font-size:12.5px;color:#6a7269;font-weight:500}

/* ── footer ── */
.ftr{background:var(--brand-deep);color:#c3cfc7;padding:62px 0 26px;margin-top:76px;
  border-top:3px solid var(--gold)}
.ftr h4{color:#fff;font-family:Inter,sans-serif;font-size:13px;text-transform:uppercase;
  letter-spacing:.10em;margin-bottom:16px}
.ftr a{color:#c3cfc7;font-size:14.5px;transition:color .18s}
.ftr a:hover{color:var(--gold-l)}
.ftr-grid{display:grid;grid-template-columns:1.6fr 1fr 1fr 1.3fr;gap:36px}
.ftr ul{list-style:none;padding:0;margin:0}
.ftr li{margin-bottom:9px}
.ftr-bottom{border-top:1px solid #2a3a34;margin-top:36px;padding-top:20px;
  display:flex;justify-content:space-between;gap:14px;flex-wrap:wrap;font-size:13.5px;color:#8fa199}

.alert{padding:13px 17px;border-radius:10px;margin-bottom:18px;font-size:14.5px}
.alert-ok{background:#e8f5ee;color:#1d5b3d;border:1px solid #bfe0cd}
.alert-err{background:#fdeceb;color:#8f2c26;border:1px solid #f3c9c6}

/* ── whatsapp ── */
.wa{position:fixed;right:18px;bottom:18px;z-index:70;width:56px;height:56px;border-radius:50%;
  background:#25d366;display:grid;place-items:center;box-shadow:0 8px 26px rgba(37,211,102,.42);
  transition:transform .22s cubic-bezier(.22,.61,.36,1), box-shadow .22s}
.wa:hover{text-decoration:none;transform:scale(1.08);box-shadow:0 12px 34px rgba(37,211,102,.55)}
.wa svg{width:30px;height:30px;fill:#fff}
/* Dhadkan sirf ek baar, page khulne ke baad. Lagataar hilta button
   dhyaan kheenchta hai par thoda der baad chidhaane lagta hai. */
@keyframes waPulse{0%{box-shadow:0 8px 26px rgba(37,211,102,.42),0 0 0 0 rgba(37,211,102,.55)}
  70%{box-shadow:0 8px 26px rgba(37,211,102,.42),0 0 0 16px rgba(37,211,102,0)}
  100%{box-shadow:0 8px 26px rgba(37,211,102,.42),0 0 0 0 rgba(37,211,102,0)}}
.wa{animation:waPulse 2.2s ease-out 1.4s 3}

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
      <img class="brand-mark" src="{{ asset("brand/mark.png") }}"
           alt="Sky Property Morni Hills" width="320" height="177">
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
        <img src="{{ asset('brand/logo.png') }}" alt="{{ $s['name'] }}"
             style="width:132px;height:auto;margin-bottom:16px;filter:brightness(0) invert(1);opacity:.94">
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

  /* Header ko kinaara tab milta hai jab page thoda scroll ho chuka ho. */
  (function () {
    var h = document.querySelector('.hdr');
    if (!h) return;
    var tick = function () { h.classList.toggle('stuck', window.scrollY > 12); };
    tick();
    window.addEventListener('scroll', tick, { passive: true });
  })();

  /* Scroll par section ka halka sa upar aana.
     IntersectionObserver isliye ki scroll par har baar hisaab lagana
     phone par lag karta hai -- browser khud batata hai ki kya dikha.
     Jinke system mein animation band hai unke liye ye chalta hi nahi. */
  (function () {
    var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var els = document.querySelectorAll('.sec > .wrap, .card, .gd-step, .crow');

    if (reduce || !('IntersectionObserver' in window)) return;

    els.forEach(function (el, i) {
      el.setAttribute('data-rise', '');
      /* Ek row ke card ek ke baad ek aayein, saath nahi -- nazar unpar
         baayen se daayen chalti hai. */
      el.style.transitionDelay = ((i % 3) * 70) + 'ms';
    });

    var io = new IntersectionObserver(function (rows) {
      rows.forEach(function (r) {
        if (r.isIntersecting) { r.target.classList.add('in'); io.unobserve(r.target); }
      });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.06 });

    els.forEach(function (el) { io.observe(el); });
  })();
</script>
@yield('script')
</body>
</html>
