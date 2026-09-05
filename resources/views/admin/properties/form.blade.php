@extends('layouts.admin')
@section('content')
@php $new = !$property->exists; @endphp

<div class="top">
  <h1>{{ $new ? 'Add Property' : 'Edit Property' }}</h1>
  <div class="sp">
    @unless($new)
      <a class="btn btn-ghost" href="{{ route('property', $property->slug) }}" target="_blank">View on site ↗</a>
    @endunless
    <a class="btn btn-ghost" href="{{ route('admin.properties.index') }}">← Back</a>
  </div>
</div>

<form method="POST"
      action="{{ $new ? route('admin.properties.store') : route('admin.properties.update', $property) }}">
  @csrf
  @unless($new) @method('PUT') @endunless

  <div class="card">
    <h2>Basic</h2>

    <div class="row">
      <div>
        <label for="fTitle">Title *</label>
        <input type="text" id="fTitle" name="title" value="{{ old('title', $property->title) }}" required
               placeholder="4 Kanal Plot with Valley View in Morni">
        <div class="hint">Jo customer ko dikhega. Size, cheez aur jagah likho — Google isi se dhoondhta hai.</div>
      </div>
    </div>

    <div class="row r3">
      <div>
        <label for="fType">Type *</label>
        <select id="fType" name="type" required>
          @foreach(\App\Models\Property::TYPES as $k => $v)
            <option value="{{ $k }}" @selected(old('type', $property->type) === $k)>{{ $v }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label for="fListing">Sale or Rent *</label>
        <select id="fListing" name="listing" required>
          @foreach(\App\Models\Property::LISTINGS as $k => $v)
            <option value="{{ $k }}" @selected(old('listing', $property->listing) === $k)>{{ $v }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label for="fStatus">Status *</label>
        <select id="fStatus" name="status" required>
          @foreach(['available' => 'Available', 'sold' => 'Sold', 'rented' => 'Rented', 'hidden' => 'Hidden (site par nahi dikhegi)'] as $k => $v)
            <option value="{{ $k }}" @selected(old('status', $property->status ?: 'available') === $k)>{{ $v }}</option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="row r3">
      <div>
        <label for="fPrice">Price (₹)</label>
        <input type="number" id="fPrice" name="price" min="0" step="1" value="{{ old('price', $property->price) }}">
        <div class="hint">Poora number: 4500000. Khaali ya 0 chhodo to "Price on request" dikhega.</div>
      </div>
      <div>
        <label for="fPriceNote">Price note</label>
        <input type="text" id="fPriceNote" name="price_note" value="{{ old('price_note', $property->price_note) }}"
               placeholder="per marla / monthly">
      </div>
      <div>
        <label for="fSort">Sort order</label>
        <input type="number" id="fSort" name="sort_order" min="0" value="{{ old('sort_order', $property->sort_order ?? 0) }}">
        <div class="hint">Chhota number pehle aata hai.</div>
      </div>
    </div>

    <div class="row r4">
      <div>
        <label for="fArea">Area</label>
        <input type="number" id="fArea" name="area" step="0.01" min="0" value="{{ old('area', $property->area) }}">
      </div>
      <div>
        <label for="fUnit">Unit</label>
        <select id="fUnit" name="area_unit">
          @foreach(\App\Models\Property::AREA_UNITS as $u)
            <option value="{{ $u }}" @selected(old('area_unit', $property->area_unit ?: 'marla') === $u)>{{ $u }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label for="fBed">Bedrooms</label>
        <input type="number" id="fBed" name="bedrooms" min="0" value="{{ old('bedrooms', $property->bedrooms) }}">
        <div class="hint">Plot hai to khaali chhodo.</div>
      </div>
      <div>
        <label for="fBath">Bathrooms</label>
        <input type="number" id="fBath" name="bathrooms" min="0" value="{{ old('bathrooms', $property->bathrooms) }}">
      </div>
    </div>

    <label style="display:flex;align-items:center;gap:9px;font-weight:600;margin-top:6px">
      <input type="checkbox" name="is_featured" value="1" style="width:auto"
             @checked(old('is_featured', $property->is_featured))>
      Homepage par "Featured" mein dikhao
    </label>
  </div>

  <div class="card">
    <h2>Location</h2>
    <div class="row r4">
      <div>
        <label for="fLocality">Locality</label>
        <input type="text" id="fLocality" name="locality" value="{{ old('locality', $property->locality) }}" placeholder="Tikkar Taal">
      </div>
      <div>
        <label for="fCity">City / Village</label>
        <input type="text" id="fCity" name="city" value="{{ old('city', $property->city ?: 'Morni') }}">
      </div>
      <div>
        <label for="fDistrict">District</label>
        <input type="text" id="fDistrict" name="district" value="{{ old('district', $property->district ?: 'Panchkula') }}">
      </div>
      <div>
        <label for="fPin">Pincode</label>
        <input type="text" id="fPin" name="pincode" value="{{ old('pincode', $property->pincode ?: '134205') }}">
      </div>
    </div>

    <div class="row r3">
      <div>
        <label for="fOwn">Ownership</label>
        <input type="text" id="fOwn" name="ownership" value="{{ old('ownership', $property->ownership) }}"
               placeholder="Freehold / Registry">
      </div>
      <div>
        <label for="fFace">Facing</label>
        <input type="text" id="fFace" name="facing" value="{{ old('facing', $property->facing) }}" placeholder="South-East">
      </div>
      <div>
        <label for="fRoad">Approach road</label>
        <input type="text" id="fRoad" name="approach_road" value="{{ old('approach_road', $property->approach_road) }}"
               placeholder="20 ft, tar road">
      </div>
    </div>

    <div class="row">
      <div>
        <label for="fMap">Google Map embed code</label>
        <textarea id="fMap" name="map_embed" style="min-height:70px">{{ old('map_embed', $property->map_embed) }}</textarea>
        <div class="hint">Google Maps → Share → Embed a map → poora &lt;iframe&gt; yahan paste karo. Khaali bhi chhod sakte ho.</div>
      </div>
    </div>
  </div>

  <div class="card">
    <h2>Description</h2>

    <div class="row">
      <div>
        <label for="fShort">Short description</label>
        <textarea id="fShort" name="short_description" style="min-height:70px" maxlength="400">{{ old('short_description', $property->short_description) }}</textarea>
        <div class="hint">Ek-do line. Page par sabse upar aati hai.</div>
      </div>
    </div>

    <div class="row">
      <div>
        <label for="fDesc">Full description</label>
        <textarea id="fDesc" name="description" style="min-height:180px">{{ old('description', $property->description) }}</textarea>
      </div>
    </div>

    <div class="row">
      <div>
        <label for="fFeat">Features — ek line par ek</label>
        <textarea id="fFeat" name="features_text" style="min-height:140px" placeholder="Road touch
Water connection available
Valley view
Electricity pole at site">{{ old('features_text', implode("\n", (array) $property->features)) }}</textarea>
        <div class="hint">Har line ek tick mark ban jaati hai. Comma ya bracket ki zaroorat nahi.</div>
      </div>
    </div>
  </div>

  <div class="card">
    <h2>SEO <span style="font-weight:400;font-size:13px;color:var(--muted)">(khaali chhodo to apne aap ban jayega)</span></h2>
    <div class="row r2">
      <div>
        <label for="fSlug">URL slug</label>
        <input type="text" id="fSlug" name="slug" value="{{ old('slug', $property->slug) }}"
               placeholder="{{ $new ? 'title se apne aap banega' : $property->slug }}">
        <div class="hint">⚠ Live property ka slug badalne se uska purana link toot jaata hai.</div>
      </div>
      <div>
        <label for="fMeta">Meta title</label>
        <input type="text" id="fMeta" name="meta_title" value="{{ old('meta_title', $property->meta_title) }}">
      </div>
    </div>
    <div class="row">
      <div>
        <label for="fMetaD">Meta description</label>
        <textarea id="fMetaD" name="meta_description" style="min-height:60px" maxlength="400">{{ old('meta_description', $property->meta_description) }}</textarea>
      </div>
    </div>
  </div>

  <button class="btn btn-primary" type="submit" style="padding:13px 30px">
    {{ $new ? 'Save & Add Photos' : 'Save Changes' }}
  </button>
</form>

@unless($new)
  {{-- Photo upload alag form hai. Ek hi form mein rakhte to har baar
       photo add karne par poora page save karna padta. --}}
  <div class="card" style="margin-top:22px">
    <h2>Photos</h2>

    <form method="POST" action="{{ route('admin.properties.images', $property) }}" enctype="multipart/form-data"
          style="display:flex;gap:11px;align-items:end;flex-wrap:wrap;margin-bottom:18px">
      @csrf
      <div style="flex:1;min-width:240px">
        <label for="fImgs">Nayi photo chuno (ek saath kai chun sakte ho)</label>
        <input type="file" id="fImgs" name="images[]" accept="image/*" multiple required>
        <div class="hint">Har photo 6 MB tak. Pehli photo apne aap cover ban jaati hai.</div>
      </div>
      <button class="btn btn-primary" type="submit">Upload</button>
    </form>

    @if(empty($property->images))
      <div class="empty">Abhi koi photo nahi hai.</div>
    @else
      <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:14px">
        @foreach($property->images as $img)
          <div style="border:2px solid {{ $property->cover_image === $img ? 'var(--green)' : 'var(--line)' }};
                      border-radius:11px;overflow:hidden;background:#fff">
            <img src="{{ $img }}" alt="" style="width:100%;aspect-ratio:4/3;object-fit:cover;display:block">
            <div style="padding:9px;display:flex;gap:6px;justify-content:space-between;align-items:center">
              @if($property->cover_image === $img)
                <span class="pill pill-ok">Cover</span>
              @else
                <form method="POST" action="{{ route('admin.properties.cover', $property) }}">
                  @csrf
                  <input type="hidden" name="url" value="{{ $img }}">
                  <button class="btn btn-ghost btn-sm" type="submit">Make cover</button>
                </form>
              @endif

              <form method="POST" action="{{ route('admin.properties.images.delete', $property) }}"
                    onsubmit="return confirm('Ye photo hata dein?')">
                @csrf @method('DELETE')
                <input type="hidden" name="url" value="{{ $img }}">
                <button class="btn btn-danger btn-sm" type="submit">✕</button>
              </form>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
@endunless
@endsection
