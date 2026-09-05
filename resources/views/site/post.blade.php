@extends('layouts.site', [
    'title'       => $post->meta_title ?: $post->title,
    'description' => $post->meta_description ?: $post->summary,
])

@section('style')
.crumb{padding:16px 0;font-size:13.5px;color:var(--muted)}
.crumb a{color:var(--muted)}

/* Lekh ke saath ek patti -- logo, phone aur andar ke link.
   Lambe lekh mein padhne wala aakhir tak pahunchte-pahunchte bhool
   jaata hai ki wo kiski site par hai; ye patti saath chalti rehti hai
   aur call ka rasta hamesha saamne rakhti hai. */
.artwrap{display:grid;grid-template-columns:minmax(0,820px) 300px;gap:44px;
  justify-content:center;align-items:start;padding-bottom:60px}
.art{min-width:0;padding:0 0 20px}

.aside{position:sticky;top:96px;display:grid;gap:16px}
.abox{background:var(--card);border:1px solid var(--line);border-radius:var(--radius);
  padding:22px 20px;box-shadow:var(--shadow-s);text-align:center}
.abox img.alogo{width:130px;height:auto;margin:0 auto 12px}
.abox .aname{font-family:Fraunces,Georgia,serif;font-weight:700;font-size:17px;margin:0 0 3px}
.abox .aloc{color:var(--muted);font-size:13px;margin:0 0 16px}
.abox .btn{width:100%;justify-content:center;margin-bottom:9px;padding:12px 14px;font-size:14px}
.abox .btn:last-child{margin-bottom:0}

.alist{background:var(--card);border:1px solid var(--line);border-radius:var(--radius);padding:20px}
.alist h4{font-family:Inter,sans-serif;font-size:12px;text-transform:uppercase;
  letter-spacing:.09em;color:var(--muted);margin:0 0 13px}
.alist ul{list-style:none;padding:0;margin:0}
.alist li{margin-bottom:10px;line-height:1.45}
.alist a{font-size:14.5px;color:var(--ink)}
.alist a:hover{color:var(--brand)}

@media(max-width:1080px){
  /* Do column ke liye jagah nahi bachi -- patti lekh ke neeche chali
     jaati hai, aur wahan chipakti nahi. */
  .artwrap{grid-template-columns:minmax(0,820px);gap:32px}
  .aside{position:static;grid-template-columns:1fr 1fr;display:grid;gap:16px}
}
@media(max-width:640px){
  .aside{grid-template-columns:1fr}
}
.art-cat{display:inline-block;background:#e9f1e4;color:var(--brand);padding:5px 13px;
  border-radius:7px;font-size:12.5px;font-weight:700;margin-bottom:14px}
.art h1{font-size:clamp(27px,4vw,42px);margin-bottom:14px}
.art-meta{display:flex;gap:16px;flex-wrap:wrap;color:var(--muted);font-size:14px;
  padding-bottom:20px;border-bottom:1px solid var(--line);margin-bottom:26px}
.art-cover{border-radius:var(--radius);overflow:hidden;margin-bottom:28px}
.art-cover img{width:100%;aspect-ratio:16/9;object-fit:cover}
.art-lede{font-size:18px;line-height:1.8;color:#3d4a44;margin-bottom:24px}

.art-body{font-size:16.5px;line-height:1.85;color:#33403a}
.art-body h2{font-size:25px;margin:36px 0 13px}
.art-body h3{font-size:20px;margin:28px 0 10px}
.art-body p{margin:0 0 17px}
.art-body ul,.art-body ol{padding-left:22px;margin:0 0 18px}
.art-body li{margin-bottom:9px}
.art-body table{width:100%;border-collapse:collapse;margin:18px 0;font-size:15px}
.art-body th,.art-body td{border:1px solid var(--line);padding:11px 14px;text-align:left}
.art-body th{background:var(--soft);font-weight:600}
.art-body blockquote{border-left:4px solid var(--brand);background:var(--soft);
  margin:20px 0;padding:16px 20px;border-radius:0 10px 10px 0}
.art-body blockquote p:last-child{margin:0}
.art-body img{border-radius:12px;margin:18px 0}
.art-body a{text-decoration:underline}

.art-more{border-top:1px solid var(--line);margin-top:36px;padding-top:26px}
.art-more h2{font-size:22px;margin-bottom:14px}
.art-more ul{list-style:none;padding:0;margin:0 0 18px}
.art-more li{position:relative;padding-left:24px;margin-bottom:9px;line-height:1.65}
.art-more li:before{content:"→";position:absolute;left:0;color:var(--brand);font-weight:700}
.art-more p{color:var(--muted);font-size:14.5px;line-height:1.75}

.author{display:flex;gap:16px;background:var(--soft);border-radius:var(--radius);
  padding:22px 24px;margin:34px 0 0}
.author-ic{width:52px;height:52px;flex:0 0 52px;border-radius:50%;
  background:linear-gradient(140deg,var(--brand),#6da354);color:#fff;
  display:grid;place-items:center;font-size:23px}
.author h3{font-size:16px;margin:0 0 4px;font-family:Inter,sans-serif}
.author p{margin:0;color:var(--muted);font-size:14.5px;line-height:1.7}

.art-cta{background:var(--brand);color:#fff;border-radius:16px;padding:30px 32px;margin:32px 0 0;
  display:flex;align-items:center;justify-content:space-between;gap:24px;flex-wrap:wrap}
.art-cta h3{color:#fff;margin:0 0 4px}
.art-cta p{color:#d3e7dc;margin:0;font-size:15px}
.art-cta .btn{background:#fff;color:var(--brand)}
.art-cta .btn-ghost{background:rgba(255,255,255,.12);color:#fff;border-color:rgba(255,255,255,.34)}

@media(max-width:640px){
  .art-body{font-size:16px}
  .art-body h2{font-size:22px}
  .fq-a{padding:0 16px 15px 16px}
  .art-cta{padding:24px 20px}
}
@endsection

@section('content')
@php
    $s        = config('site');
    $author   = $post->author_name ?: $s['name'] . ' team';
    $published= ($post->published_at ?? $post->created_at);
@endphp

{{-- BlogPosting schema. dateModified alag se de rahe hain -- Google
     purane lekh ko neeche rakhta hai, aur sudhaar ke baad usse batana
     zaroori hai ki content abhi taaza hai. --}}
<script type="application/ld+json">
{!! json_encode(array_filter([
    '@context'         => 'https://schema.org',
    '@type'            => 'BlogPosting',
    'headline'         => $post->title,
    'description'      => $post->summary,
    'image'            => $post->cover,
    'datePublished'    => $published?->toAtomString(),
    'dateModified'     => $post->updated_at?->toAtomString(),
    'author'           => ['@type' => 'Organization', 'name' => $author, 'url' => url('/')],
    'publisher'        => [
        '@type' => 'Organization',
        'name'  => $s['name'],
        'url'   => url('/'),
    ],
    'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => url()->current()],
    'articleSection'   => $post->category_label,
]), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>

{{-- Schema sirf tab jab sawaal is lekh ke apne hon. Ek hi FAQ set
     ka schema kai page se bhejna Google ko batata hai ki wo page
     ek doosre ki nakal hain. --}}
@if(!empty($post->faq) && !$post->faq_shared)
<script type="application/ld+json">
{!! json_encode([
    '@context'   => 'https://schema.org',
    '@type'      => 'FAQPage',
    'mainEntity' => array_map(fn ($f) => [
        '@type'          => 'Question',
        'name'           => $f['q'] ?? '',
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => strip_tags($f['a'] ?? '')],
    ], $post->faq),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
@endif

<div class="wrap crumb">
  <a href="{{ route('home') }}">Home</a> ›
  <a href="{{ route('blog') }}">Guide</a> ›
  <span>{{ $post->title }}</span>
</div>

<div class="wrap artwrap">
  <article class="art">
    <span class="art-cat">{{ $post->category_label }}</span>

    <h1>{{ $post->title }}</h1>

    <div class="art-meta">
      <span>✍ {{ $author }}</span>
      <span>📅 {{ $post->date_label }}</span>
      <span>⏱ {{ $post->reading_time }}</span>
      @if($post->updated_at && $published && $post->updated_at->gt($published->addDay()))
        <span>🔄 Updated {{ $post->updated_at->format('d M Y') }}</span>
      @endif
    </div>

    @if($post->cover_image)
      <div class="art-cover">
        <img src="{{ $post->cover }}" alt="{{ $post->cover_alt ?: $post->title }}">
      </div>
    @endif

    @if(filled($post->excerpt))
      <p class="art-lede">{{ $post->excerpt }}</p>
    @endif

    {{-- Content maalik likhta hai aur usmein headings, list aur table
         hote hain, isliye HTML ke roop mein chhap raha hai. Ye admin
         panel ke peeche hai -- bahar se koi yahan kuch nahi daal sakta. --}}
    <div class="art-body">{!! $post->content !!}</div>

    @if(!empty($post->faq))
      <div class="faqbox">
        <h2>Questions People Ask</h2>
        @foreach($post->faq as $f)
          <details class="fq">
            <summary><span class="fq-plus">+</span><span>{{ $f['q'] ?? '' }}</span></summary>
            <div class="fq-a">{{ $f['a'] ?? '' }}</div>
          </details>
        @endforeach
      </div>
    @endif

    {{-- Har lekh ke aakhir mein ek hi jagah se aane wala hissa: andar ke
         link, sarkari record ke link, aur doosre dhandhe ka link. View
         mein hai, har post ki file mein nahi -- warna badalna ho to har
         file kholni padti. --}}
    <div class="art-more">
      <h2>Read next</h2>
      <ul>
        <li><a href="{{ route('properties') }}">All property in Morni Hills</a> &mdash; plots, land, farmhouses and cottages</li>
        <li><a href="{{ route('properties', ['type' => 'plot']) }}">Residential plots for sale</a></li>
        <li><a href="{{ route('properties', ['type' => 'farmhouse']) }}">Farmhouses in Morni Hills</a></li>
        <li><a href="{{ route('blog') }}">The full Morni property guide</a></li>
      </ul>

      <p>
        Land records for Haryana are public &mdash; look any plot up yourself at
        <a href="https://jamabandi.nic.in/" target="_blank" rel="noopener nofollow">jamabandi.nic.in</a>,
        and district information is at
        <a href="https://panchkula.gov.in/" target="_blank" rel="noopener nofollow">panchkula.gov.in</a>.
      </p>

      <p style="margin-bottom:0">
        <strong>Also from us:</strong>
        <a href="https://www.sandeepphotography.com/" target="_blank" rel="noopener">Sandeep Photography</a>
        &mdash; wedding, pre-wedding and event photography across Chandigarh, Panchkula and
        Mohali. Most people mark a new house with a griha pravesh, and later a wedding.
      </p>
    </div>

    <div class="author">
      <img class="author-ic" src="{{ asset('brand/mark.png') }}" alt="" style="object-fit:contain;background:#fff;padding:7px">
      <div>
        <h3>{{ $author }}</h3>
        <p>
          {{ $post->author_bio
             ?: 'Based in Morni, Panchkula. We buy, sell and arrange land in these hills, and we still live among the people we sell to. Call ' . $s['phone'] . ' with any question this article did not answer.' }}
        </p>
      </div>
    </div>

    <div class="art-cta">
      <div>
        <h3>Looking for land in Morni?</h3>
        <p>Tell us the budget and the area. Site visits are free, with no obligation.</p>
      </div>
      <div style="display:flex;gap:11px;flex-wrap:wrap">
        <a class="btn" href="tel:{{ $s['phone_link'] }}">📞 {{ $s['phone'] }}</a>
        <a class="btn btn-ghost" href="{{ route('properties') }}">See Properties</a>
      </div>
    </div>
  </article>

  {{-- Saath chalti patti. Logo yahan isliye ki lambe lekh mein padhne
       wala bhool jaata hai ki wo kiski site par hai. --}}
  <aside class="aside">
    <div class="abox">
      <img class="alogo" src="{{ asset('brand/logo.png') }}" alt="{{ $s['name'] }}"
           width="640" height="770">
      <p class="aname">{{ $s['short_name'] }}</p>
      <p class="aloc">{{ $s['address_line'] }}</p>

      <a class="btn btn-primary" href="tel:{{ $s['phone_link'] }}">📞 {{ $s['phone'] }}</a>
      <a class="btn btn-ghost" href="https://wa.me/{{ $s['whatsapp'] }}" target="_blank" rel="noopener">💬 WhatsApp</a>
    </div>

    <div class="alist">
      <h4>Browse</h4>
      <ul>
        <li><a href="{{ route('properties', ['type' => 'plot']) }}">Plots in Morni Hills</a></li>
        <li><a href="{{ route('properties', ['type' => 'land']) }}">Agricultural land</a></li>
        <li><a href="{{ route('properties', ['type' => 'farmhouse']) }}">Farmhouses</a></li>
        <li><a href="{{ route('properties', ['type' => 'cottage']) }}">Hill cottages</a></li>
        <li><a href="{{ route('properties') }}">All properties</a></li>
        <li><a href="{{ route('blog') }}">More guides</a></li>
      </ul>
    </div>

    <div class="alist">
      <h4>Also from us</h4>
      <ul>
        <li>
          <a href="https://www.sandeepphotography.com/" target="_blank" rel="noopener">
            Sandeep Photography &nearr;
          </a>
          <div style="color:var(--muted);font-size:13px;margin-top:3px;line-height:1.5">
            Wedding and event photography across Chandigarh, Panchkula and Mohali.
          </div>
        </li>
      </ul>
    </div>
  </aside>
</div>

@if($more->isNotEmpty())
<section class="sec sec-soft">
  <div class="wrap">
    <h2 style="margin-bottom:24px">Read next</h2>
    <div class="grid g3">
      @foreach($more as $m)
        <article class="card">
          <a class="card-img" href="{{ route('post', $m->slug) }}">
            <img src="{{ $m->cover }}" alt="{{ $m->cover_alt ?: $m->title }}" loading="lazy">
            <span class="card-tag">{{ $m->category_label }}</span>
          </a>
          <div class="card-body">
            <h3 class="card-title"><a href="{{ route('post', $m->slug) }}">{{ $m->title }}</a></h3>
            <p class="card-loc">{{ $m->date_label }} &middot; {{ $m->reading_time }}</p>
          </div>
        </article>
      @endforeach
    </div>
  </div>
</section>
@endif
@endsection
