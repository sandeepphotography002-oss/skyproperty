{{-- Ek property ka card. Homepage, listing aur "similar" teeno yahi
     istemaal karte hain, taaki teen jagah ka design kabhi alag na ho. --}}
<article class="card">
  <a class="card-img" href="{{ route('property', $p->slug) }}">
    <img src="{{ $p->cover }}" alt="{{ $p->title }}" loading="lazy">
    <span class="card-tag">{{ $p->type_label }}</span>

    @if($p->status === 'sold')
      <span class="card-status st-sold">SOLD</span>
    @elseif($p->status === 'rented')
      <span class="card-status st-rented">RENTED</span>
    @elseif($p->listing === 'rent')
      <span class="card-status" style="background:var(--green)">FOR RENT</span>
    @endif
  </a>

  <div class="card-body">
    <div class="card-price">{{ $p->price_label }}</div>

    <h3 class="card-title"><a href="{{ route('property', $p->slug) }}">{{ $p->title }}</a></h3>

    <p class="card-loc">📍 {{ $p->full_location }}</p>

    <div class="card-meta">
      @if($p->area_label)<span class="chip">📐 {{ $p->area_label }}</span>@endif
      @if($p->bedrooms)<span class="chip">🛏 {{ $p->bedrooms }} BHK</span>@endif
      @if($p->bathrooms)<span class="chip">🚿 {{ $p->bathrooms }}</span>@endif
      @if($p->ownership)<span class="chip">📄 {{ $p->ownership }}</span>@endif
    </div>
  </div>
</article>
