@extends('layouts.admin')
@section('content')

<div class="top">
  <h1>Properties</h1>
  <div class="sp">
    <a class="btn btn-primary" href="{{ route('admin.properties.create') }}">➕ Add Property</a>
  </div>
</div>

<div class="card">
  <form method="GET" style="display:flex;gap:11px;flex-wrap:wrap;align-items:end;margin:0">
    <div style="flex:1;min-width:200px">
      <label for="aq">Search</label>
      <input type="text" id="aq" name="q" value="{{ request('q') }}" placeholder="Title ya locality…">
    </div>
    <div style="min-width:180px">
      <label for="atype">Type</label>
      <select id="atype" name="type">
        <option value="">All types</option>
        @foreach(\App\Models\Property::TYPES as $k => $v)
          <option value="{{ $k }}" @selected(request('type') === $k)>{{ $v }}</option>
        @endforeach
      </select>
    </div>
    <button class="btn btn-primary" type="submit">Filter</button>
    @if(request()->hasAny(['q', 'type']))
      <a class="btn btn-ghost" href="{{ route('admin.properties.index') }}">Clear</a>
    @endif
  </form>
</div>

@if($properties->isEmpty())
  <div class="card empty">
    Kuch nahi mila.
    <div style="margin-top:14px"><a class="btn btn-primary" href="{{ route('admin.properties.create') }}">Property add karo</a></div>
  </div>
@else
  <div class="tbl-wrap">
    <table>
      <thead>
        <tr><th style="width:74px">Photo</th><th>Title</th><th>Type</th><th>Price</th><th>Area</th><th>Status</th><th style="width:190px"></th></tr>
      </thead>
      <tbody>
        @foreach($properties as $p)
          <tr>
            <td><img src="{{ $p->cover }}" alt="" style="width:60px;height:46px;object-fit:cover;border-radius:7px"></td>
            <td>
              <strong>{{ $p->title }}</strong>
              @if($p->is_featured)<span class="pill pill-warn">★ Featured</span>@endif
              <div class="hint">{{ $p->full_location }}</div>
            </td>
            <td>{{ $p->type_label }}<div class="hint">{{ $p->listing_label }}</div></td>
            <td>{{ $p->price_label }}</td>
            <td>{{ $p->area_label ?: '—' }}</td>
            <td>
              <span class="pill {{ $p->status === 'available' ? 'pill-ok' : ($p->status === 'hidden' ? 'pill-off' : 'pill-warn') }}">
                {{ ucfirst($p->status) }}
              </span>
            </td>
            <td>
              <div style="display:flex;gap:6px;flex-wrap:wrap">
                <a class="btn btn-ghost btn-sm" href="{{ route('property', $p->slug) }}" target="_blank">View</a>
                <a class="btn btn-primary btn-sm" href="{{ route('admin.properties.edit', $p) }}">Edit</a>
                <form method="POST" action="{{ route('admin.properties.destroy', $p) }}"
                      onsubmit="return confirm('Ye property aur uski saari photo hamesha ke liye hat jaayengi. Pakka?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                </form>
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div style="margin-top:18px">{{ $properties->links() }}</div>
@endif
@endsection
