@extends('layouts.admin')
@section('content')

<div class="top">
  <h1>Enquiries</h1>
  <div class="sp">
    <a class="btn {{ request('status') ? 'btn-ghost' : 'btn-primary' }} btn-sm" href="{{ route('admin.enquiries.index') }}">All</a>
    @foreach(\App\Models\Enquiry::STATUSES as $k => $v)
      <a class="btn {{ request('status') === $k ? 'btn-primary' : 'btn-ghost' }} btn-sm"
         href="{{ route('admin.enquiries.index', ['status' => $k]) }}">{{ $v }}</a>
    @endforeach
  </div>
</div>

@if($enquiries->isEmpty())
  <div class="card empty">Is filter mein koi enquiry nahi hai.</div>
@else
  @foreach($enquiries as $e)
    <div class="card">
      <div class="top" style="margin-bottom:12px">
        <h2 style="margin:0">
          {{ $e->name }}
          @if(!$e->seen_at)<span class="pill pill-new">NEW</span>@endif
        </h2>
        <div class="sp">
          <span class="hint">{{ $e->created_at?->format('d M Y, g:i A') }}</span>
        </div>
      </div>

      <div class="row r3" style="margin-bottom:12px">
        @php
            /* Log number kaise bhi likhte hain: space ke saath, +91 ke
               saath, 0 se shuru. wa.me sirf saaf digits leta hai, isliye
               yahan seedha kar dete hain. */
            $digits = preg_replace('/\D/', '', (string) $e->phone);
            $digits = ltrim($digits, '0');
            $wa     = str_starts_with($digits, '91') ? $digits : '91' . $digits;
        @endphp
        <div>
          <div class="hint">Phone</div>
          <a href="tel:{{ $e->phone }}" style="font-size:16px;font-weight:600">{{ $e->phone }}</a>
          &nbsp;<a href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener">WhatsApp</a>
        </div>
        <div>
          <div class="hint">Email</div>
          {{ $e->email ? '' : '—' }}
          @if($e->email)<a href="mailto:{{ $e->email }}">{{ $e->email }}</a>@endif
        </div>
        <div>
          <div class="hint">Budget</div>
          {{ $e->budget ?: '—' }}
        </div>
      </div>

      @if($e->property_title)
        <div style="margin-bottom:12px">
          <div class="hint">Property</div>
          @if($e->property)
            <a href="{{ route('property', $e->property->slug) }}" target="_blank">{{ $e->property_title }} ↗</a>
          @else
            {{ $e->property_title }} <span class="hint">(ab site par nahi hai)</span>
          @endif
        </div>
      @endif

      @if($e->message)
        <div style="background:var(--soft);border-radius:9px;padding:13px 15px;margin-bottom:14px">
          {{ $e->message }}
        </div>
      @endif

      <form method="POST" action="{{ route('admin.enquiries.update', $e) }}"
            style="display:flex;gap:11px;align-items:end;flex-wrap:wrap">
        @csrf @method('PUT')

        <div style="min-width:170px">
          <label for="st{{ $e->id }}">Status</label>
          <select id="st{{ $e->id }}" name="status">
            @foreach(\App\Models\Enquiry::STATUSES as $k => $v)
              <option value="{{ $k }}" @selected($e->status === $k)>{{ $v }}</option>
            @endforeach
          </select>
        </div>

        <div style="flex:1;min-width:240px">
          <label for="nt{{ $e->id }}">Note (sirf aapke liye)</label>
          <input type="text" id="nt{{ $e->id }}" name="admin_note" value="{{ $e->admin_note }}"
                 placeholder="Call kiya, Sunday site visit…">
        </div>

        <button class="btn btn-primary" type="submit">Save</button>
      </form>

      <form method="POST" action="{{ route('admin.enquiries.destroy', $e) }}"
            onsubmit="return confirm('Ye enquiry hamesha ke liye hat jayegi. Pakka?')" style="margin-top:10px">
        @csrf @method('DELETE')
        <button class="btn btn-danger btn-sm" type="submit">Delete</button>
      </form>
    </div>
  @endforeach

  <div style="margin-top:18px">{{ $enquiries->links() }}</div>
@endif
@endsection
