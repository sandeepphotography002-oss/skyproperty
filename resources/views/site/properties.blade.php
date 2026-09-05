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
@endsection
