@extends('layouts.site')

@section('style')
/* Hero ka andhera ek taraf se doosri taraf jaata hai, har jagah barabar
   nahi. Baayen taraf gehra hai jahan likha hai, daayen halka jahan
   pahaad dikhna chahiye -- tab photo aur text dono bachte hain. */
.hero{position:relative;min-height:min(92vh,780px);display:flex;align-items:center;
  color:#fff;padding:96px 0 84px;overflow:hidden;
  background:
    linear-gradient(100deg, rgba(12,24,17,.90) 0%, rgba(12,24,17,.70) 42%, rgba(12,24,17,.44) 100%),
    linear-gradient(to top, rgba(12,24,17,.72) 0%, rgba(12,24,17,0) 46%),
    url('https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=1900&q=72') center/cover no-repeat;
  background-attachment:scroll, scroll, fixed}
/* Phone par fixed background lag karta hai aur kai jagah chalta hi
   nahi -- wahan normal kar dete hain. */
@media(max-width:900px){ .hero{background-attachment:scroll,scroll,scroll} }
.hero .wrap{position:relative;z-index:2}
.hero h1{color:#fff;max-width:14ch;text-shadow:0 2px 24px rgba(0,0,0,.34)}
.hero p{color:#e2ebe5;font-size:18.5px;max-width:54ch;margin-bottom:28px;line-height:1.75}
.hero-eyebrow{display:inline-flex;align-items:center;gap:9px;
  background:rgba(255,255,255,.10);backdrop-filter:blur(8px);
  border:1px solid rgba(255,255,255,.26);padding:8px 17px;border-radius:99px;font-size:13px;
  font-weight:600;letter-spacing:.07em;text-transform:uppercase;margin-bottom:22px}
.hero-btns{display:flex;gap:13px;flex-wrap:wrap}
.hero .btn-ghost{background:rgba(255,255,255,.10);color:#fff;border-color:rgba(255,255,255,.32);
  backdrop-filter:blur(8px);box-shadow:none}
.hero .btn-ghost:hover{background:rgba(255,255,255,.20);border-color:rgba(255,255,255,.5);color:#fff}

/* search bar */
.finder{background:var(--card);border-radius:18px;box-shadow:var(--shadow-l);
  padding:20px;margin-top:42px;display:grid;grid-template-columns:1.4fr 1fr 1fr auto;gap:13px;align-items:end}
.finder label{display:block;font-size:11.5px;font-weight:700;color:var(--muted);
  text-transform:uppercase;letter-spacing:.07em;margin-bottom:7px}
.finder input,.finder select{width:100%;padding:12px 13px;border:1px solid var(--line);
  border-radius:10px;font-size:15px;font-family:inherit;color:var(--ink);background:var(--bg);
  transition:border-color .18s, box-shadow .18s}
.finder input:focus,.finder select:focus{outline:0;border-color:var(--green);
  box-shadow:0 0 0 3px rgba(43,99,71,.14);background:#fff}

.stats{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;margin-top:46px}
.stat{background:rgba(255,255,255,.09);border:1px solid rgba(255,255,255,.18);
  backdrop-filter:blur(10px);border-radius:14px;padding:20px 22px;
  transition:background .22s, transform .22s}
.stat:hover{background:rgba(255,255,255,.15);transform:translateY(-2px)}
.stat b{display:block;font-family:Fraunces,serif;font-size:34px;color:#fff;line-height:1.05;
  letter-spacing:-.02em}
.stat span{font-size:13px;color:#c9d6cf;letter-spacing:.02em}

/* categories */
.cats{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}
.cat{position:relative;border-radius:var(--radius);overflow:hidden;aspect-ratio:16/10;display:block;
  box-shadow:var(--shadow-s);transition:transform .28s cubic-bezier(.22,.61,.36,1), box-shadow .28s}
.cat:hover{text-decoration:none;transform:translateY(-4px);box-shadow:var(--shadow)}
.cat img{width:100%;height:100%;object-fit:cover;transition:transform .65s cubic-bezier(.22,.61,.36,1)}
.cat:hover img{transform:scale(1.08)}
.cat span{position:absolute;inset:auto 0 0 0;padding:52px 20px 18px;color:#fff;font-weight:700;
  font-size:17.5px;letter-spacing:-.01em;
  background:linear-gradient(transparent,rgba(10,20,14,.88));
  display:flex;align-items:center;justify-content:space-between;gap:10px}
.cat span:after{content:"→";font-size:19px;opacity:0;transform:translateX(-6px);
  transition:opacity .25s, transform .25s}
.cat:hover span:after{opacity:1;transform:none}

/* why */
.why{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
.why-item{background:var(--card);border:1px solid var(--line);border-radius:var(--radius);
  padding:28px 26px;box-shadow:var(--shadow-s);
  transition:transform .24s cubic-bezier(.22,.61,.36,1), box-shadow .24s, border-color .24s}
.why-item:hover{transform:translateY(-4px);box-shadow:var(--shadow);border-color:#d8cbb4}
.why-ico{width:50px;height:50px;border-radius:13px;
  background:linear-gradient(140deg,#eaf3ee,#dcebe2);color:var(--green);
  display:grid;place-items:center;font-size:23px;margin-bottom:16px;
  box-shadow:inset 0 0 0 1px rgba(43,99,71,.08)}
.why-item h3{font-size:18.5px;margin-bottom:8px}
.why-item p{color:var(--muted);font-size:14.5px;margin:0;line-height:1.75}

/* cta band */
.band{background:linear-gradient(135deg,var(--green),var(--green-d));color:#fff;
  border-radius:20px;padding:48px 44px;box-shadow:0 18px 50px rgba(43,99,71,.28);
  display:flex;align-items:center;justify-content:space-between;gap:28px;flex-wrap:wrap;
  position:relative;overflow:hidden}
/* Kone mein halka sa ujaala -- flat hare dabbe se behtar lagta hai. */
.band:before{content:"";position:absolute;top:-40%;right:-8%;width:420px;height:420px;
  border-radius:50%;background:radial-gradient(circle,rgba(255,255,255,.10),transparent 68%);
  pointer-events:none}
.band h2{color:#fff;margin-bottom:6px}
.band p{color:#d3e7dc;margin:0}
.band .btn{background:#fff;color:var(--green)}

/* ── guide (lamba SEO wala hissa) ── */
.gd{max-width:880px}
.gd h2{margin:44px 0 14px;scroll-margin-top:88px}
.gd h2:first-child{margin-top:0}
.gd h3{font-size:19px;margin:30px 0 10px}
.gd p{color:#3d4a44}
.gd-answer{background:#f2f8f4;border:1px solid #cfe4d8;border-left:4px solid var(--green);
  border-radius:12px;padding:20px 22px;font-size:16.5px;line-height:1.8}
.gd-list{padding-left:0;list-style:none;margin:0 0 18px}
.gd-list li{position:relative;padding-left:26px;margin-bottom:11px;line-height:1.75}
.gd-list li:before{content:"—";position:absolute;left:0;color:var(--green);font-weight:700}
.gd-check{padding-left:0;list-style:none;margin:0 0 18px;
  display:grid;grid-template-columns:1fr 1fr;gap:10px 24px}
.gd-check li{position:relative;padding-left:28px;font-size:15px;line-height:1.6}
.gd-check li:before{content:"☐";position:absolute;left:0;color:var(--green);font-size:17px;line-height:1.3}
.gd-tbl{overflow-x:auto;margin:16px 0 18px;border:1px solid var(--line);border-radius:12px}
.gd-tbl table{width:100%;border-collapse:collapse;font-size:15px;min-width:520px}
.gd-tbl th,.gd-tbl td{border-bottom:1px solid var(--line);padding:12px 15px;text-align:left}
.gd-tbl thead th{background:var(--soft);font-weight:600;font-size:13.5px;
  text-transform:uppercase;letter-spacing:.03em;color:var(--muted)}
.gd-tbl tbody th{background:var(--soft);font-weight:600;width:26%}
.gd-tbl tr:last-child td,.gd-tbl tr:last-child th{border-bottom:0}
.gd-note{background:#fffaf0;border:1px solid #f0e0bd;border-radius:11px;
  padding:15px 18px;font-size:14.5px;color:#6b5a37}
.gd-note a{color:#8a6520;text-decoration:underline}
.gd-steps{display:grid;gap:12px;margin:18px 0 20px}
.gd-step{display:flex;gap:15px;background:#fff;border:1px solid var(--line);border-radius:12px;padding:17px 19px}
.gd-step b{flex:0 0 32px;width:32px;height:32px;border-radius:50%;background:var(--green);
  color:#fff;display:grid;place-items:center;font-size:14px}
.gd-step strong{display:block;margin-bottom:3px}
.gd-step p{margin:0;color:var(--muted);font-size:14.5px;line-height:1.7}
.gd-faq{margin:18px 0 8px}
.gd-q{background:#fff;border:1px solid var(--line);border-radius:12px;margin-bottom:11px;overflow:hidden}
.gd-q[open]{border-color:#cfe4d8;box-shadow:0 5px 20px rgba(20,40,30,.06)}
.gd-q summary{list-style:none;cursor:pointer;display:flex;gap:12px;align-items:flex-start;
  padding:15px 18px;font-weight:600;font-size:16px;line-height:1.5}
.gd-q summary::-webkit-details-marker{display:none}
.gd-q summary:hover{background:#fafcfb}
.gd-plus{flex:0 0 22px;width:22px;height:22px;border-radius:50%;background:var(--green);
  color:#fff;display:grid;place-items:center;font-size:15px;font-weight:700;
  margin-top:1px;transition:transform .22s;line-height:1}
.gd-q[open] .gd-plus{transform:rotate(45deg)}
.gd-a{padding:0 18px 17px 52px;color:#5c6a64;font-size:15px;line-height:1.8}
.gd-cta{background:var(--green);color:#fff;border-radius:16px;padding:30px 32px;margin:34px 0 26px;
  display:flex;align-items:center;justify-content:space-between;gap:24px;flex-wrap:wrap}
.gd-cta h3{color:#fff;margin:0 0 4px}
.gd-cta p{color:#d3e7dc;margin:0;font-size:15px}
.gd-cta .btn-ghost{background:rgba(255,255,255,.12);color:#fff;border-color:rgba(255,255,255,.34)}
.gd-updated{font-size:13.5px;color:var(--muted);border-top:1px solid var(--line);padding-top:18px;margin:0}

.areas-row{display:flex;flex-wrap:wrap;gap:10px;justify-content:center;margin-top:28px}
.areas-row a{background:var(--card);border:1px solid var(--line);border-radius:99px;
  padding:10px 19px;font-size:14px;color:var(--ink);font-weight:500;box-shadow:var(--shadow-s);
  transition:border-color .18s, color .18s, transform .18s}
.areas-row a:hover{border-color:var(--green);color:var(--green);text-decoration:none;transform:translateY(-2px)}

@media(max-width:900px){
  .finder{grid-template-columns:1fr 1fr;gap:11px}
  .stats{grid-template-columns:1fr 1fr}
  .cats{grid-template-columns:1fr 1fr}
  .why{grid-template-columns:1fr}
}
@media(max-width:700px){
  .gd-check{grid-template-columns:1fr}
}
@media(max-width:600px){
  .finder{grid-template-columns:1fr}
  .cats{grid-template-columns:1fr}
  .band{padding:32px 24px}
  .gd h2{font-size:22px;margin:34px 0 12px}
  .gd-answer{padding:17px 18px;font-size:15.5px}
  .gd-a{padding:0 16px 15px 16px}
  .gd-q summary{font-size:15px;padding:13px 15px}
  .gd-cta{padding:24px 20px}
}
@endsection

@section('content')
@php $s = config('site'); @endphp

<section class="hero">
  <div class="wrap">
    <span class="hero-eyebrow">⛰ Morni Hills · Panchkula · Haryana</span>

    <h1>Own a piece of the Morni hills</h1>

    <p>
      Plots, farmhouses, cottages and farm land in Morni and around Panchkula.
      We walk the ground with you, show you the papers before the price,
      and tell you plainly when a deal is not worth it.
    </p>

    <div class="hero-btns">
      <a class="btn btn-gold" href="{{ route('properties') }}">Browse Properties</a>
      <a class="btn btn-ghost" href="tel:{{ $s['phone_link'] }}">📞 {{ $s['phone'] }}</a>
    </div>

    {{-- Ye form GET se properties page par jaata hai. Sab kuch query
         string mein rehta hai, isliye result ka link bheja ja sakta hai. --}}
    <form class="finder" method="GET" action="{{ route('properties') }}">
      <div>
        <label for="fLoc">Location</label>
        <input type="text" id="fLoc" name="locality" placeholder="Morni, Tikkar Taal…">
      </div>
      <div>
        <label for="fType">Property Type</label>
        <select id="fType" name="type">
          <option value="">Any type</option>
          @foreach(\App\Models\Property::TYPES as $k => $v)
            <option value="{{ $k }}">{{ $v }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label for="fMax">Budget up to</label>
        <select id="fMax" name="max">
          <option value="">Any budget</option>
          <option value="10">₹10 Lakh</option>
          <option value="25">₹25 Lakh</option>
          <option value="50">₹50 Lakh</option>
          <option value="100">₹1 Crore</option>
          <option value="300">₹3 Crore</option>
        </select>
      </div>
      <button class="btn btn-primary" type="submit">Search</button>
    </form>

    <div class="stats">
      <div class="stat"><b>{{ $counts['total'] }}</b><span>Listings live</span></div>
      <div class="stat"><b>{{ $counts['plot'] }}</b><span>Plots &amp; land</span></div>
      <div class="stat"><b>{{ $counts['house'] }}</b><span>Farmhouses &amp; cottages</span></div>
      <div class="stat"><b>{{ $counts['stay'] }}</b><span>Resorts &amp; homestays</span></div>
    </div>
  </div>
</section>

{{-- ── featured ── --}}
<section class="sec">
  <div class="wrap">
    <div class="center" style="margin-bottom:36px">
      <h2>Featured Properties</h2>
      <p class="lead">Hand-picked plots and homes in Morni Hills &mdash; each one we have stood on ourselves.</p>
    </div>

    @if($featured->isEmpty())
      <p class="center lead">Listings are being added. Call {{ $s['phone'] }} and we will tell you what is available today.</p>
    @else
      <div class="grid g3">
        @foreach($featured as $p)
          @include('site.partials.card', ['p' => $p])
        @endforeach
      </div>

      <div class="center" style="margin-top:34px">
        <a class="btn btn-primary" href="{{ route('properties') }}">View All Properties</a>
      </div>
    @endif
  </div>
</section>

{{-- ── categories ── --}}
<section class="sec sec-soft">
  <div class="wrap">
    <div class="center" style="margin-bottom:34px">
      <h2>What are you looking for?</h2>
      <p class="lead">From a small plot to a working resort &mdash; Morni has all of it, at very different prices.</p>
    </div>

    <div class="cats">
      <a class="cat" href="{{ route('properties', ['type' => 'plot']) }}">
        <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=900&q=70" alt="Residential plots in Morni Hills">
        <span>Residential Plots</span>
      </a>
      <a class="cat" href="{{ route('properties', ['type' => 'land']) }}">
        <img src="https://images.unsplash.com/photo-1444858291040-58f756a3bdd6?w=900&q=70" alt="Agricultural and farm land in Morni">
        <span>Agricultural Land</span>
      </a>
      <a class="cat" href="{{ route('properties', ['type' => 'farmhouse']) }}">
        <img src="https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=900&q=70" alt="Farmhouses in Morni Hills">
        <span>Farmhouses</span>
      </a>
      <a class="cat" href="{{ route('properties', ['type' => 'cottage']) }}">
        <img src="https://images.unsplash.com/photo-1449158743715-0a90ebb6d2d8?w=900&q=70" alt="Hill cottages in Morni">
        <span>Hill Cottages</span>
      </a>
      <a class="cat" href="{{ route('properties', ['type' => 'resort']) }}">
        <img src="https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?w=900&q=70" alt="Resorts for sale in Morni Hills">
        <span>Resorts</span>
      </a>
      <a class="cat" href="{{ route('properties', ['listing' => 'rent']) }}">
        <img src="https://images.unsplash.com/photo-1502005229762-cf1b2da7c5d6?w=900&q=70" alt="Cottages on rent in Morni">
        <span>On Rent</span>
      </a>
    </div>
  </div>
</section>

{{-- ── why us ── --}}
<section class="sec">
  <div class="wrap">
    <div class="center" style="margin-bottom:36px">
      <h2>Why buy through us</h2>
      <p class="lead">Hill land is not city land. What goes wrong here goes wrong in ways a city buyer never sees coming.</p>
    </div>

    <div class="why">
      <div class="why-item">
        <div class="why-ico">📄</div>
        <h3>Papers first, price second</h3>
        <p>You see the registry, the mutation and the land record before we talk money. If a title is unclear, we say so and walk away from it.</p>
      </div>
      <div class="why-item">
        <div class="why-ico">🛣</div>
        <h3>We tell you about the approach</h3>
        <p>A beautiful plot with no road to it is worth far less than the photo suggests. We show you how a truck would actually reach the site.</p>
      </div>
      <div class="why-item">
        <div class="why-ico">🏔</div>
        <h3>We are from here</h3>
        <p>Morni, Tikkar Taal, Bhoj Jabial, Mandana. We know which slopes hold water, which stretches lose the sun early, and who the real owner is.</p>
      </div>
      <div class="why-item">
        <div class="why-ico">🚗</div>
        <h3>Site visits, no pressure</h3>
        <p>Come and see three properties in a day. No booking amount, no signature, no rush. Decide after you have walked the ground.</p>
      </div>
      <div class="why-item">
        <div class="why-ico">⚖️</div>
        <h3>Help with the paperwork</h3>
        <p>Registry, stamp duty, mutation, NOC. We stay with you through the tehsil work rather than disappearing after the deal.</p>
      </div>
      <div class="why-item">
        <div class="why-ico">💬</div>
        <h3>Straight answers</h3>
        <p>If a property is overpriced, or the season is wrong, or you should wait &mdash; we will tell you. A bad sale costs us more than a lost one.</p>
      </div>
    </div>
  </div>
</section>

{{-- ── guide: poora likha hua hissa, FAQ ke saath ── --}}
@include('site.partials.guide')

{{-- ── areas ── --}}
<section class="sec sec-soft">
  <div class="wrap center">
    <h2>Where we work</h2>
    <p class="lead">Morni Hills and the belt around Panchkula, up to Kalka and Raipur Rani.</p>

    <div class="areas-row">
      @foreach($s['areas'] as $a)
        <a href="{{ route('properties', ['locality' => $a]) }}">{{ $a }}</a>
      @endforeach
    </div>
  </div>
</section>

{{-- ── cta ── --}}
<section class="sec">
  <div class="wrap">
    <div class="band">
      <div>
        <h2>Looking for something specific?</h2>
        <p>Tell us the budget and the area. If we do not have it today, we will find it and call you back.</p>
      </div>
      <div style="display:flex;gap:12px;flex-wrap:wrap">
        <a class="btn" href="tel:{{ $s['phone_link'] }}">📞 {{ $s['phone'] }}</a>
        <a class="btn btn-gold" href="{{ route('contact') }}">Send an Enquiry</a>
      </div>
    </div>
  </div>
</section>
@endsection
