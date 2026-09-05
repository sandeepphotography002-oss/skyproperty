@extends('layouts.admin')
@section('content')

<div class="top">
  <h1>Dashboard</h1>
  <div class="sp">
    <a class="btn btn-primary" href="{{ route('admin.properties.create') }}">➕ Add Property</a>
  </div>
</div>

<div class="tiles">
  <div class="tile"><b>{{ $total }}</b><span>Total properties</span></div>
  <div class="tile"><b>{{ $available }}</b><span>Available</span></div>
  <div class="tile"><b>{{ $sold }}</b><span>Sold / rented</span></div>
  <div class="tile {{ $unseen ? 'hot' : '' }}">
    <b>{{ $enquiries }}</b>
    <span>{{ $unseen ? $unseen . ' new, not seen yet' : 'Enquiries' }}</span>
  </div>
</div>

<div class="tiles">
  <div class="tile"><b>{{ $posts }}</b><span>Blog posts</span></div>
  <div class="tile"><b>{{ $postsLive }}</b><span>Published</span></div>
  <div class="tile"><b>{{ $postsDraft }}</b><span>Draft</span></div>
  <div class="tile" style="display:flex;align-items:center">
    <a class="btn btn-primary" href="{{ route('admin.posts.create') }}" style="width:100%;justify-content:center">📝 Write a Post</a>
  </div>
</div>

<div class="card">
  <div class="top" style="margin-bottom:14px">
    <h2>Latest enquiries</h2>
    <div class="sp"><a href="{{ route('admin.enquiries.index') }}">See all →</a></div>
  </div>

  @if($latest->isEmpty())
    <div class="empty">Abhi koi enquiry nahi aayi.</div>
  @else
    <div class="tbl-wrap">
      <table>
        <thead><tr><th>Name</th><th>Phone</th><th>Property</th><th>Status</th><th>When</th></tr></thead>
        <tbody>
          @foreach($latest as $e)
            <tr>
              <td><strong>{{ $e->name }}</strong>@if(!$e->seen_at) <span class="pill pill-new">NEW</span>@endif</td>
              <td><a href="tel:{{ $e->phone }}">{{ $e->phone }}</a></td>
              <td>{{ $e->property_title ?: '—' }}</td>
              <td><span class="pill pill-off">{{ $e->status_label }}</span></td>
              <td>{{ $e->created_at?->diffForHumans() }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>

<div class="card">
  <div class="top" style="margin-bottom:14px">
    <h2>Latest blog posts</h2>
    <div class="sp"><a href="{{ route('admin.posts.index') }}">See all →</a></div>
  </div>

  @if($recentPost->isEmpty())
    <div class="empty">
      Abhi koi blog post nahi hai.
      <div style="margin-top:14px"><a class="btn btn-primary" href="{{ route('admin.posts.create') }}">Pehla post likho</a></div>
    </div>
  @else
    <div class="tbl-wrap">
      <table>
        <thead><tr><th>Title</th><th>Category</th><th>Date</th><th>Views</th><th>Status</th><th></th></tr></thead>
        <tbody>
          @foreach($recentPost as $p)
            <tr>
              <td><strong>{{ $p->title }}</strong><div class="hint">{{ $p->reading_time }}</div></td>
              <td>{{ $p->category_label }}</td>
              <td>{{ $p->date_label ?: '—' }}</td>
              <td>{{ number_format($p->views) }}</td>
              <td><span class="pill {{ $p->status === 'published' ? 'pill-ok' : 'pill-off' }}">{{ ucfirst($p->status) }}</span></td>
              <td><a class="btn btn-ghost btn-sm" href="{{ route('admin.posts.edit', $p) }}">Edit</a></td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>

<div class="card">
  <div class="top" style="margin-bottom:14px">
    <h2>Recently added</h2>
    <div class="sp"><a href="{{ route('admin.properties.index') }}">See all →</a></div>
  </div>

  @if($recent->isEmpty())
    <div class="empty">
      Abhi koi property nahi hai.
      <div style="margin-top:14px"><a class="btn btn-primary" href="{{ route('admin.properties.create') }}">Pehli property add karo</a></div>
    </div>
  @else
    <div class="tbl-wrap">
      <table>
        <thead><tr><th>Title</th><th>Type</th><th>Price</th><th>Status</th><th></th></tr></thead>
        <tbody>
          @foreach($recent as $p)
            <tr>
              <td><strong>{{ $p->title }}</strong><div class="hint">{{ $p->full_location }}</div></td>
              <td>{{ $p->type_label }}</td>
              <td>{{ $p->price_label }}</td>
              <td>
                <span class="pill {{ $p->status === 'available' ? 'pill-ok' : ($p->status === 'hidden' ? 'pill-off' : 'pill-warn') }}">
                  {{ ucfirst($p->status) }}
                </span>
              </td>
              <td><a class="btn btn-ghost btn-sm" href="{{ route('admin.properties.edit', $p) }}">Edit</a></td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>
@endsection
