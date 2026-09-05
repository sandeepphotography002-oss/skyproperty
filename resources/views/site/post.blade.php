@extends('layouts.site', [
    'title'       => $post->meta_title ?: $post->title,
    'description' => $post->meta_description ?: $post->summary,
])

@section('style')
.crumb{padding:16px 0;font-size:13.5px;color:var(--muted)}
.crumb a{color:var(--muted)}

.art{max-width:820px;margin:0 auto;padding:0 0 60px}
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

.faqbox{margin:38px 0 8px}
.faqbox h2{font-size:24px;margin-bottom:16px}
.fq{background:#fff;border:1px solid var(--line);border-radius:12px;margin-bottom:11px;overflow:hidden}
.fq[open]{border-color:#cfe0c4;box-shadow:0 5px 20px rgba(35,50,28,.07)}
.fq summary{list-style:none;cursor:pointer;display:flex;gap:12px;align-items:flex-start;
  padding:15px 18px;font-weight:600;font-size:16px;line-height:1.5}
.fq summary::-webkit-details-marker{display:none}
.fq summary:hover{background:#fafcfb}
.fq-plus{flex:0 0 22px;width:22px;height:22px;border-radius:50%;background:var(--brand);
  color:#fff;display:grid;place-items:center;font-size:15px;font-weight:700;
  margin-top:1px;transition:transform .22s;line-height:1}
.fq[open] .fq-plus{transform:rotate(45deg)}
.fq-a{padding:0 18px 17px 52px;color:#5c6a64;font-size:15px;line-height:1.8}

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

@if(!empty($post->faq))
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

<div class="wrap">
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
