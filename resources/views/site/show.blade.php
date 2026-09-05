@extends('layouts.site')

@section('style')
.crumb{padding:16px 0;font-size:13.5px;color:var(--muted)}
.crumb a{color:var(--muted)}

.gal{display:grid;grid-template-columns:2fr 1fr;gap:10px;border-radius:var(--radius);overflow:hidden}
.gal-main{aspect-ratio:16/11;background:var(--soft)}
.gal-main img{width:100%;height:100%;object-fit:cover}
.gal-side{display:grid;grid-template-rows:1fr 1fr;gap:10px}
.gal-side div{overflow:hidden;background:var(--soft)}
.gal-side img{width:100%;height:100%;object-fit:cover;cursor:pointer;transition:opacity .2s}
.gal-side img:hover{opacity:.86}
.thumbs{display:flex;gap:9px;flex-wrap:wrap;margin-top:11px}
.thumbs img{width:88px;height:66px;object-fit:cover;border-radius:8px;cursor:pointer;
  border:2px solid transparent;transition:border-color .18s}
.thumbs img:hover,.thumbs img.on{border-color:var(--brand)}

.detail{display:grid;grid-template-columns:1fr 366px;gap:36px;align-items:start;padding:30px 0 66px}

.p-head{border-bottom:1px solid var(--line);padding-bottom:20px;margin-bottom:22px}
.p-badges{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:12px}
.badge{background:#e9f1e4;color:var(--brand);padding:5px 12px;border-radius:7px;font-size:12.5px;font-weight:700;letter-spacing:.02em}
.badge-warn{background:#fdeceb;color:#a63a33}
.p-price{font-family:Fraunces,serif;font-size:33px;font-weight:700;color:var(--brand);margin:10px 0 4px}
.p-loc{color:var(--muted);font-size:15px;margin:0}

.facts{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin:22px 0 28px}
.fact{background:var(--soft);border-radius:11px;padding:15px 16px}
.fact small{display:block;color:var(--muted);font-size:12px;text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px}
.fact b{font-size:16px;font-weight:600}

.p-body{line-height:1.85}
.p-body h2{font-size:22px;margin:30px 0 12px}
.feat{display:grid;grid-template-columns:1fr 1fr;gap:9px;list-style:none;padding:0;margin:0 0 8px}
.feat li{padding-left:26px;position:relative;font-size:15px}
.feat li:before{content:"✓";position:absolute;left:0;color:var(--brand);font-weight:700}

.spec{width:100%;border-collapse:collapse;font-size:15px;margin:6px 0 8px}
.spec th,.spec td{border:1px solid var(--line);padding:11px 14px;text-align:left}
.spec th{background:var(--soft);font-weight:600;width:42%}

/* form */
.side{position:sticky;top:92px}
.box{background:#fff;border:1px solid var(--line);border-radius:var(--radius);padding:24px;box-shadow:var(--shadow)}
.box h3{font-size:19px;margin-bottom:5px}
.box .sub{color:var(--muted);font-size:14px;margin-bottom:18px}
.fld{margin-bottom:13px}
.fld label{display:block;font-size:13px;font-weight:600;margin-bottom:5px}
.fld input,.fld textarea{width:100%;padding:11px 12px;border:1px solid var(--line);
  border-radius:9px;font-size:15px;font-family:inherit;color:var(--ink)}
.fld textarea{min-height:88px;resize:vertical}
.hp{position:absolute;left:-9999px;width:1px;height:1px;overflow:hidden}
.side-call{margin-top:14px;text-align:center;font-size:14px;color:var(--muted)}

@media(max-width:960px){
  .detail{grid-template-columns:1fr;gap:26px}
  .side{position:static}
  .facts{grid-template-columns:1fr 1fr}
  .gal{grid-template-columns:1fr}
  .gal-side{grid-template-rows:none;grid-template-columns:1fr 1fr}
  .feat{grid-template-columns:1fr}
}
@endsection

@section('content')
@php
    $s      = config('site');
    /* Cover hamesha pehli hai, baaki uske baad. array_unique isliye ki
       cover aksar gallery ki bhi ek photo hoti hai. */
    $images = array_values(array_filter(array_unique(
        array_merge([$property->cover], (array) $property->images)
    )));
@endphp

<div class="wrap crumb">
  <a href="{{ route('home') }}">Home</a> ›
  <a href="{{ route('properties') }}">Properties</a> ›
  <span>{{ $property->title }}</span>
</div>

<div class="wrap">
  <div class="gal">
    <div class="gal-main"><img id="galMain" src="{{ $images[0] }}" alt="{{ $property->title }}"></div>
    <div class="gal-side">
      <div><img src="{{ $images[1] ?? $images[0] }}" alt="" data-full="{{ $images[1] ?? $images[0] }}"></div>
      <div><img src="{{ $images[2] ?? $images[0] }}" alt="" data-full="{{ $images[2] ?? $images[0] }}"></div>
    </div>
  </div>

  @if(count($images) > 1)
    <div class="thumbs" id="thumbs">
      @foreach($images as $i => $img)
        <img src="{{ $img }}" alt="Photo {{ $i + 1 }}" data-full="{{ $img }}" class="{{ $i === 0 ? 'on' : '' }}">
      @endforeach
    </div>
  @endif
</div>

<div class="wrap detail">

  <div>
    <div class="p-head">
      <div class="p-badges">
        <span class="badge">{{ $property->type_label }}</span>
        <span class="badge">{{ $property->listing_label }}</span>
        @if($property->status === 'sold')<span class="badge badge-warn">Sold</span>@endif
        @if($property->status === 'rented')<span class="badge badge-warn">Rented</span>@endif
      </div>

      <h1 style="font-size:clamp(24px,3.2vw,34px)">{{ $property->title }}</h1>
      <div class="p-price">{{ $property->price_label }}</div>
      <p class="p-loc">📍 {{ $property->full_location }} &mdash; {{ $property->pincode }}</p>
    </div>

    <div class="facts">
      @if($property->area_label)<div class="fact"><small>Area</small><b>{{ $property->area_label }}</b></div>@endif
      @if($property->bedrooms)<div class="fact"><small>Bedrooms</small><b>{{ $property->bedrooms }}</b></div>@endif
      @if($property->bathrooms)<div class="fact"><small>Bathrooms</small><b>{{ $property->bathrooms }}</b></div>@endif
      @if($property->ownership)<div class="fact"><small>Ownership</small><b>{{ $property->ownership }}</b></div>@endif
      @if($property->facing)<div class="fact"><small>Facing</small><b>{{ $property->facing }}</b></div>@endif
      @if($property->approach_road)<div class="fact"><small>Approach</small><b>{{ $property->approach_road }}</b></div>@endif
    </div>

    <div class="p-body">
      @if($property->short_description)
        <p style="font-size:17px">{{ $property->short_description }}</p>
      @endif

      @if($property->description)
        <h2>About this property</h2>
        {!! nl2br(e($property->description)) !!}
      @endif

      @if(!empty($property->features))
        <h2>Features</h2>
        <ul class="feat">
          @foreach($property->features as $f)<li>{{ $f }}</li>@endforeach
        </ul>
      @endif

      <h2>Property details</h2>
      <table class="spec"><tbody>
        <tr><th>Type</th><td>{{ $property->type_label }}</td></tr>
        <tr><th>Listed for</th><td>{{ $property->listing_label }}</td></tr>
        <tr><th>Price</th><td>{{ $property->price_label }}</td></tr>
        @if($property->area_label)<tr><th>Plot area</th><td>{{ $property->area_label }}</td></tr>@endif
        <tr><th>Location</th><td>{{ $property->full_location }}</td></tr>
        <tr><th>Pincode</th><td>{{ $property->pincode }}</td></tr>
        @if($property->ownership)<tr><th>Ownership</th><td>{{ $property->ownership }}</td></tr>@endif
        @if($property->approach_road)<tr><th>Approach road</th><td>{{ $property->approach_road }}</td></tr>@endif
        <tr><th>Reference</th><td>SKY-{{ str_pad($property->id, 4, '0', STR_PAD_LEFT) }}</td></tr>
      </tbody></table>

      @if($property->map_embed)
        <h2>Location on map</h2>
        <div style="border-radius:var(--radius);overflow:hidden;border:1px solid var(--line)">
          {!! $property->map_embed !!}
        </div>
      @endif
    </div>
  </div>

  {{-- ── enquiry form ── --}}
  <aside class="side">
    <div class="box">
      <h3>Interested in this?</h3>
      <p class="sub">Leave your number. We will call and arrange a site visit &mdash; no charge, no pressure.</p>

      @if(session('ok'))
        <div class="alert alert-ok">{{ session('ok') }}</div>
      @endif
      @if($errors->any())
        <div class="alert alert-err">{{ $errors->first() }}</div>
      @endif

      <form method="POST" action="{{ route('enquiry') }}">
        @csrf
        <input type="hidden" name="property_id" value="{{ $property->id }}">
        <input type="hidden" name="source_page" value="{{ url()->current() }}">

        {{-- Honeypot. aria-hidden aur tabindex isliye ki ye keyboard aur
             screen reader dono ke raste se bilkul bahar rahe. --}}
        <div class="hp" aria-hidden="true">
          <label for="pWebsite">Website</label>
          <input type="text" id="pWebsite" name="website" tabindex="-1" autocomplete="off">
        </div>

        <div class="fld">
          <label for="pName">Your name</label>
          <input type="text" id="pName" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="fld">
          <label for="pPhone">Phone number</label>
          <input type="tel" id="pPhone" name="phone" value="{{ old('phone') }}" required>
        </div>

        <div class="fld">
          <label for="pEmail">Email <span style="font-weight:400;color:var(--muted)">(optional)</span></label>
          <input type="email" id="pEmail" name="email" value="{{ old('email') }}">
        </div>

        <div class="fld">
          <label for="pMsg">Message</label>
          <textarea id="pMsg" name="message">{{ old('message') }}</textarea>
        </div>

        <button class="btn btn-primary btn-block" type="submit">Request a Call Back</button>
      </form>

      <p class="side-call">
        Or call now &mdash; <a href="tel:{{ $s['phone_link'] }}"><strong>{{ $s['phone'] }}</strong></a>
      </p>

      <a class="btn btn-ghost btn-block" style="margin-top:11px"
         href="https://wa.me/{{ $s['whatsapp'] }}?text={{ urlencode('Hello, I am interested in: ' . $property->title . ' — ' . url()->current()) }}"
         target="_blank" rel="noopener">💬 Ask on WhatsApp</a>
    </div>
  </aside>
</div>

@if($similar->isNotEmpty())
<section class="sec sec-soft">
  <div class="wrap">
    <h2 style="margin-bottom:26px">You may also like</h2>
    <div class="grid g3">
      @foreach($similar as $sp)
        @include('site.partials.card', ['p' => $sp])
      @endforeach
    </div>
  </div>
</section>
@endif
@endsection

@section('script')
<script>
  /* Thumbnail par click se badi photo badalti hai. Poora gallery
     plugin lagane ki zaroorat nahi -- ek src badalna hai bas. */
  (function () {
    var main = document.getElementById('galMain');
    if (!main) return;

    function swap(e) {
      var src = e.currentTarget.getAttribute('data-full');
      if (!src) return;
      main.src = src;
      document.querySelectorAll('#thumbs img').forEach(function (t) {
        t.classList.toggle('on', t.getAttribute('data-full') === src);
      });
    }

    document.querySelectorAll('#thumbs img, .gal-side img').forEach(function (t) {
      t.addEventListener('click', swap);
    });
  })();
</script>
@endsection
