@extends('layouts.site')

@section('style')
.bhead{background:var(--soft);border-bottom:1px solid var(--line);padding:46px 0 42px;text-align:center}
.bhead h1{font-size:clamp(27px,3.8vw,40px);margin-bottom:8px}

.bcats{display:flex;gap:9px;flex-wrap:wrap;justify-content:center;margin-top:22px}
.bcats a{background:#fff;border:1px solid var(--line);border-radius:99px;
  padding:8px 17px;font-size:14px;color:var(--ink);font-weight:500}
.bcats a:hover{border-color:var(--brand);color:var(--brand);text-decoration:none}
.bcats a.on{background:var(--brand);border-color:var(--brand);color:#fff}

.bsearch{max-width:460px;margin:20px auto 0;display:flex;gap:9px}
.bsearch input{flex:1;padding:11px 14px;border:1px solid var(--line);border-radius:9px;
  font-size:15px;font-family:inherit;background:#fff;color:var(--ink)}

.pcard{background:#fff;border:1px solid var(--line);border-radius:var(--radius);overflow:hidden;
  display:flex;flex-direction:column;transition:transform .18s,box-shadow .18s}
.pcard:hover{transform:translateY(-3px);box-shadow:var(--shadow)}
.pcard-img{aspect-ratio:16/9;overflow:hidden;background:var(--soft);position:relative}
.pcard-img img{width:100%;height:100%;object-fit:cover;transition:transform .4s}
.pcard:hover .pcard-img img{transform:scale(1.04)}
.pcard-cat{position:absolute;top:12px;left:12px;background:rgba(27,36,32,.86);color:#fff;
  padding:5px 11px;border-radius:7px;font-size:12px;font-weight:600}
.pcard-body{padding:18px 19px 20px;display:flex;flex-direction:column;flex:1}
.pcard h2{font-size:18px;line-height:1.4;margin:0 0 9px;font-family:Fraunces,serif}
.pcard h2 a{color:var(--ink)}
.pcard p{color:var(--muted);font-size:14.5px;line-height:1.7;margin:0 0 14px}
.pcard-meta{margin-top:auto;padding-top:13px;border-top:1px solid var(--line);
  display:flex;gap:14px;font-size:13px;color:var(--muted)}

.empty{text-align:center;padding:56px 20px;background:var(--soft);border-radius:var(--radius)}
@endsection

@section('content')
@php $s = config('site'); @endphp

<section class="bhead">
  <div class="wrap">
    <h1>Morni Property Guide</h1>
    <p class="lead">
      What we would tell you sitting in the office &mdash; about land, papers,
      prices and the parts of Morni a photograph does not show.
    </p>

    <div class="bcats">
      <a href="{{ route('blog') }}" class="{{ request('category') ? '' : 'on' }}">All</a>
      @foreach(\App\Models\Post::CATEGORIES as $k => $v)
        <a href="{{ route('blog', ['category' => $k]) }}" class="{{ request('category') === $k ? 'on' : '' }}">{{ $v }}</a>
      @endforeach
    </div>

    <form class="bsearch" method="GET" action="{{ route('blog') }}">
      @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
      <label for="bq" class="sr-only" style="position:absolute;left:-9999px">Search articles</label>
      <input type="text" id="bq" name="q" value="{{ request('q') }}" placeholder="Search articles…">
      <button class="btn btn-primary" type="submit">Search</button>
    </form>
  </div>
</section>

<section class="sec">
  <div class="wrap">
    @if($posts->isEmpty())
      <div class="empty">
        <h3>Nothing here yet</h3>
        <p class="lead" style="margin-bottom:20px">
          Articles are being written. In the meantime, call and ask us directly &mdash;
          that is where all of this comes from anyway.
        </p>
        <a class="btn btn-primary" href="tel:{{ $s['phone_link'] }}">📞 {{ $s['phone'] }}</a>
      </div>
    @else
      <div class="grid g3">
        @foreach($posts as $p)
          <article class="pcard">
            <a class="pcard-img" href="{{ route('post', $p->slug) }}">
              <img src="{{ $p->cover }}" alt="{{ $p->cover_alt ?: $p->title }}" loading="lazy">
              <span class="pcard-cat">{{ $p->category_label }}</span>
            </a>
            <div class="pcard-body">
              <h2><a href="{{ route('post', $p->slug) }}">{{ $p->title }}</a></h2>
              <p>{{ $p->summary }}</p>
              <div class="pcard-meta">
                <span>{{ $p->date_label }}</span>
                <span>{{ $p->reading_time }}</span>
              </div>
            </div>
          </article>
        @endforeach
      </div>

      <div class="pager" style="display:flex;justify-content:center;margin-top:38px">
        {{ $posts->onEachSide(1)->links() }}
      </div>
    @endif
  </div>
</section>

{{-- Sirf card wali list Google ke liye lagbhag khaali hoti hai. Ye
     hissa batata hai ki ye guide kis liye hai aur kis kram mein padha
     jaye -- naye padhne wale ke liye bhi kaam ka hai. --}}
<section class="sec sec-soft">
  <div class="wrap" style="max-width:880px">

    <h2>What this guide is for</h2>

    <p style="color:#3d4a44">
      We are asked the same questions on the phone every week &mdash; what land costs,
      which papers to check, whether farm land can be built on, whether Morni is a good
      investment. These pages are those answers, written down properly, so you can read
      them before you call rather than after you have paid a token amount.
    </p>

    <p style="color:#3d4a44">
      Some of it argues against buying here. Hill land resells slowly, agricultural land
      cannot be built on without permission, and half the beautiful plots have no road to
      them. We would rather write that down than have you find it out yourself.
    </p>

    <h3>Where to start</h3>

    <ul style="list-style:none;padding:0;margin:0 0 8px">
      <li style="position:relative;padding-left:26px;margin-bottom:11px;line-height:1.7">
        <span style="position:absolute;left:0;color:var(--brand);font-weight:700">1.</span>
        <a href="{{ route('post', 'property-in-morni-hills-what-a-buyer-should-know-before-paying-anything') }}">Property in Morni Hills</a>
        &mdash; start here if you are new to the area
      </li>
      <li style="position:relative;padding-left:26px;margin-bottom:11px;line-height:1.7">
        <span style="position:absolute;left:0;color:var(--brand);font-weight:700">2.</span>
        <a href="{{ route('post', 'how-to-check-land-papers-before-buying-in-morni-hills') }}">How to check land papers</a>
        &mdash; read this before you pay anything to anyone
      </li>
      <li style="position:relative;padding-left:26px;margin-bottom:11px;line-height:1.7">
        <span style="position:absolute;left:0;color:var(--brand);font-weight:700">3.</span>
        <a href="{{ route('post', 'where-to-buy-in-morni-tikkar-taal-bhoj-jabial-mandana-and-the-rest') }}">Where to buy in Morni</a>
        &mdash; the pockets, and what each one suits
      </li>
      <li style="position:relative;padding-left:26px;margin-bottom:11px;line-height:1.7">
        <span style="position:absolute;left:0;color:var(--brand);font-weight:700">4.</span>
        <a href="{{ route('post', 'is-property-in-morni-hills-a-good-investment-an-honest-look') }}">Is it a good investment?</a>
        &mdash; including the parts that cost us sales
      </li>
    </ul>

    <p style="color:#3d4a44;margin-bottom:0">
      Anything these pages do not answer, call
      <a href="tel:{{ $s['phone_link'] }}">{{ $s['phone'] }}</a> and ask us directly.
      That is where all of this came from anyway.
    </p>
  </div>
</section>
@endsection
