@extends('layouts.site')

@section('style')
.phead{background:var(--soft);border-bottom:1px solid var(--line);padding:44px 0 40px}
.phead h1{font-size:clamp(26px,3.6vw,38px);margin-bottom:8px}
.phead p{color:var(--muted);margin:0}

.filters{background:#fff;border:1px solid var(--line);border-radius:var(--radius);
  padding:18px;margin:-28px 0 32px;box-shadow:var(--shadow);position:relative;
  display:grid;grid-template-columns:1.3fr .9fr .9fr .8fr .8fr .9fr auto;gap:11px;align-items:end}
.filters label{display:block;font-size:11.5px;font-weight:700;color:var(--muted);
  text-transform:uppercase;letter-spacing:.05em;margin-bottom:5px}
.filters input,.filters select{width:100%;padding:10px 11px;border:1px solid var(--line);
  border-radius:8px;font-size:14.5px;font-family:inherit;background:#fff;color:var(--ink)}

.result-bar{display:flex;justify-content:space-between;align-items:center;
  gap:14px;flex-wrap:wrap;margin-bottom:22px}
.result-bar b{font-weight:600}
.clear{font-size:14px}

.empty{text-align:center;padding:56px 20px;background:var(--soft);border-radius:var(--radius)}
.empty h3{margin-bottom:8px}

.pager{display:flex;justify-content:center;margin-top:38px}
.pager nav{display:flex;gap:6px;flex-wrap:wrap}
.pager a,.pager span{display:inline-block;padding:9px 14px;border:1px solid var(--line);
  border-radius:8px;background:#fff;font-size:14.5px;color:var(--ink)}
.pager a:hover{border-color:var(--brand);text-decoration:none}
.pager [aria-current]{background:var(--brand);color:#fff;border-color:var(--brand)}
.pager .hidden,.pager [aria-disabled="true"]{opacity:.42}
.pager svg{width:16px;height:16px}

.plist{max-width:880px}
.plist h2{margin:0 0 14px}
.plist h3{font-size:19px;margin:30px 0 10px}
.plist p{color:#3d4a44}
.plist-ul,.plist-ol{margin:0 0 18px;padding-left:0;list-style:none}
.plist-ul li,.plist-ol li{position:relative;padding-left:26px;margin-bottom:10px;line-height:1.75}
.plist-ul li:before{content:"—";position:absolute;left:0;color:var(--brand);font-weight:700}
.plist-ol{counter-reset:p}
.plist-ol li:before{counter-increment:p;content:counter(p) ".";position:absolute;left:0;
  color:var(--brand);font-weight:700}

@media(max-width:1080px){ .filters{grid-template-columns:1fr 1fr 1fr;margin-top:0} }
@media(max-width:620px){ .filters{grid-template-columns:1fr 1fr} }
@endsection

@section('content')
@php $s = config('site'); @endphp

<section class="phead">
  <div class="wrap">
    <h1>Properties in Morni Hills</h1>
    <p>Plots, land, farmhouses, cottages and stays across Morni and Panchkula.</p>
  </div>
</section>

<section style="padding-bottom:60px">
  <div class="wrap">

    {{-- Har filter apni maujooda value yaad rakhta hai, warna ek cheez
         badalne par baaki sab reset ho jaate. --}}
    <form class="filters" method="GET" action="{{ route('properties') }}">
      <div>
        <label for="fLoc">Location</label>
        <input type="text" id="fLoc" name="locality" value="{{ request('locality') }}" placeholder="Morni, Tikkar Taal…">
      </div>

      <div>
        <label for="fType">Type</label>
        <select id="fType" name="type">
          <option value="">Any</option>
          @foreach(\App\Models\Property::TYPES as $k => $v)
            <option value="{{ $k }}" @selected(request('type') === $k)>{{ $v }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label for="fList">Sale / Rent</label>
        <select id="fList" name="listing">
          <option value="">Both</option>
          @foreach(\App\Models\Property::LISTINGS as $k => $v)
            <option value="{{ $k }}" @selected(request('listing') === $k)>{{ $v }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label for="fMin">Min (₹ Lakh)</label>
        <input type="number" id="fMin" name="min" min="0" value="{{ request('min') }}" placeholder="0">
      </div>

      <div>
        <label for="fMax">Max (₹ Lakh)</label>
        <input type="number" id="fMax" name="max" min="0" value="{{ request('max') }}" placeholder="Any">
      </div>

      <div>
        <label for="fSort">Sort by</label>
        <select id="fSort" name="sort">
          <option value="">Newest</option>
          <option value="price_low"  @selected(request('sort') === 'price_low')>Price: low to high</option>
          <option value="price_high" @selected(request('sort') === 'price_high')>Price: high to low</option>
        </select>
      </div>

      <button class="btn btn-primary" type="submit">Filter</button>
    </form>

    <div class="result-bar">
      <span><b>{{ $properties->total() }}</b> {{ Str::plural('property', $properties->total()) }} found</span>
      @if(request()->hasAny(['locality', 'type', 'listing', 'min', 'max', 'sort']))
        <a class="clear" href="{{ route('properties') }}">✕ Clear all filters</a>
      @endif
    </div>

    @if($properties->isEmpty())
      <div class="empty">
        <h3>Nothing matches that just yet</h3>
        <p class="lead" style="margin-bottom:20px">
          Our listings change every week and plenty never make it online.
          Tell us what you are after and we will call you when it comes up.
        </p>
        <a class="btn btn-primary" href="tel:{{ $s['phone_link'] }}">📞 {{ $s['phone'] }}</a>
      </div>
    @else
      <div class="grid g3">
        @foreach($properties as $p)
          @include('site.partials.card', ['p' => $p])
        @endforeach
      </div>

      <div class="pager">{{ $properties->onEachSide(1)->links() }}</div>
    @endif

  </div>
</section>

{{-- Listing ke neeche likha hua hissa. Sirf card wala page Google ke
     liye lagbhag khaali hota hai -- na koi sawaal ka jawab, na koi
     sandarbh. Ye hissa listing badalne par bhi kaam ka rehta hai. --}}
<section class="sec sec-soft">
  <div class="wrap plist">

    <h2>Buying Property in Morni Hills</h2>

    <p class="lead" style="max-width:none">
      Everything above is in Morni and around Panchkula &mdash; residential plots,
      agricultural land, farmhouses, hill cottages, and stays that are already running.
      Listings change every week, and a good deal of what we handle never reaches this page.
      If nothing here fits, call and describe what you want.
    </p>

    <h3>What is on this page</h3>
    <ul class="plist-ul">
      <li><strong>Residential plots</strong> &mdash; 5 to 20 marla, the simplest thing to buy and build on</li>
      <li><strong>Agricultural and farm land</strong> &mdash; kanal and acre, cheaper, but a change of land use is needed before building</li>
      <li><strong>Farmhouses</strong> &mdash; built houses with land, often with an orchard</li>
      <li><strong>Hill cottages</strong> &mdash; smaller built homes, ready to use</li>
      <li><strong>Resorts and homestays</strong> &mdash; running businesses, sold as going concerns</li>
      <li><strong>Rentals</strong> &mdash; cottages let for longer stays</li>
    </ul>

    <h3>How to use the filters</h3>
    <p>
      Budget is entered in lakh rather than rupees, because nobody types 5000000.
      Every filter stays in the address bar, so a search can be sent to somebody as a link
      &mdash; useful when two people are deciding together.
    </p>

    <h3>Three things to check on any listing here</h3>
    <ol class="plist-ol">
      <li><strong>The approach road.</strong> It decides construction cost, how often you go, and what the plot is worth later. Walk it end to end.</li>
      <li><strong>The water source.</strong> A village line, a borewell, or a seasonal channel that is dry from January to June. Those are not the same thing.</li>
      <li><strong>The classification.</strong> Residential land can be built on. Agricultural land cannot, until the use is formally changed.</li>
    </ol>

    <p>
      Land records in Haryana are public. Look a plot up yourself at
      <a href="https://jamabandi.nic.in/" target="_blank" rel="noopener nofollow">jamabandi.nic.in</a>
      using the khasra number before your second visit. We would rather you did.
    </p>

    <p style="margin-bottom:0">
      More detail in our <a href="{{ route('blog') }}">Morni property guide</a> &mdash;
      <a href="{{ route('post', 'plots-and-land-for-sale-in-morni-hills-sizes-rates-and-what-to-check') }}">plots and land</a>,
      <a href="{{ route('post', 'farmhouses-and-farm-land-in-morni-hills-what-you-are-really-buying') }}">farmhouses</a>,
      and <a href="{{ route('post', 'how-to-check-land-papers-before-buying-in-morni-hills') }}">checking the papers</a>.
    </p>

    @include('site.partials.faq', [
        'faqTitle' => 'Questions About Buying Here',
        'faqs' => [
            ['q' => 'How often are new properties added?', 'a' => 'Most weeks. A good deal of what we handle never reaches the website at all, so call with what you want even if nothing listed fits today.'],
            ['q' => 'Are the prices shown negotiable?', 'a' => 'Usually there is some room, and how much depends on how long the property has been available and why the owner is selling. We will tell you what similar land nearby actually sold for, which is a more useful number than the asking price.'],
            ['q' => 'What does "Price on request" mean?', 'a' => 'That the owner has not fixed a figure, generally because it depends on how much land you take or what is included. Call and we will give you a range.'],
            ['q' => 'Can I see a property the same week?', 'a' => 'Usually yes. Call or WhatsApp +91 83073 77270 a day or two ahead so a route can be planned, and we will show you three or four in a day.'],
            ['q' => 'Do you charge for site visits?', 'a' => 'No. No charge, no booking amount and no obligation at that stage. Nobody should be asking you for money before you have seen the papers.'],
            ['q' => 'What area units are used here?', 'a' => 'Marla, kanal and acre. One marla is about 272 sq ft, twenty marla make a kanal, and eight kanal make an acre. Be careful with bigha, which varies locally &mdash; get the area written in kanal or acre.'],
            ['q' => 'Can someone from outside Haryana buy here?', 'a' => 'Residential plots in Morni can be bought by any Indian citizen. This is the practical difference from Kasauli and Solan, where Himachal restricts buyers from outside the state.'],
            ['q' => 'What documents will I need to check?', 'a' => 'Jamabandi, mutation, khasra number and map, non-encumbrance certificate, and the land use classification. Have your own advocate read them, not only us.'],
            ['q' => 'Do you help with registry and mutation?', 'a' => 'Yes, through the tehsil until the mutation is entered in your name. That last step is the one people leave half finished and it causes trouble at resale.'],
            ['q' => 'Are these properties available for rent?', 'a' => 'Some. Use the Sale / Rent filter above. Most of what we handle is for sale; rentals are mainly cottages let for longer stays.'],
            ['q' => 'Can I sell my property in Morni through you?', 'a' => 'Yes. Call with the khasra number and the papers, and we will tell you honestly what it is likely to fetch and roughly how long it may take.'],
            ['q' => 'Why do two similar plots cost very different amounts?', 'a' => 'The approach road, mostly, then water, slope and classification. The view has almost nothing to do with it, because nearly everything here has one.'],
        ],
    ])

  </div>
</section>
@endsection
