@extends('layouts.admin')
@section('content')

<div class="top">
  <h1>Blog — All Posts</h1>
  <div class="sp">
    <a class="btn btn-primary" href="{{ route('admin.posts.create') }}">➕ Add Post</a>
  </div>
</div>

{{-- Upar ke box. Wahi shakl jo tent wale panel mein hai, taaki dono
     jagah kaam ek jaisa lage. --}}
<div class="tiles">
  <div class="tile"><b>{{ $stats['total'] }}</b><span>Total posts</span></div>
  <div class="tile"><b>{{ $stats['published'] }}</b><span>Published (live)</span></div>
  <div class="tile {{ $stats['draft'] ? 'hot' : '' }}"><b>{{ $stats['draft'] }}</b><span>Draft (site par nahi)</span></div>
  <div class="tile"><b>{{ number_format($stats['views']) }}</b><span>Total views</span></div>
</div>

<div class="card">
  <form method="GET" style="display:flex;gap:11px;flex-wrap:wrap;align-items:end;margin:0">
    <div style="flex:1;min-width:200px">
      <label for="pq">Search</label>
      <input type="text" id="pq" name="q" value="{{ request('q') }}" placeholder="Title ya excerpt…">
    </div>
    <div style="min-width:170px">
      <label for="pcat">Category</label>
      <select id="pcat" name="category">
        <option value="">All</option>
        @foreach(\App\Models\Post::CATEGORIES as $k => $v)
          <option value="{{ $k }}" @selected(request('category') === $k)>{{ $v }}</option>
        @endforeach
      </select>
    </div>
    <div style="min-width:150px">
      <label for="pst">Status</label>
      <select id="pst" name="status">
        <option value="">All</option>
        <option value="published" @selected(request('status') === 'published')>Published</option>
        <option value="draft"     @selected(request('status') === 'draft')>Draft</option>
      </select>
    </div>
    <button class="btn btn-primary" type="submit">Filter</button>
    @if(request()->hasAny(['q', 'category', 'status']))
      <a class="btn btn-ghost" href="{{ route('admin.posts.index') }}">Clear</a>
    @endif
  </form>
</div>

@if($posts->isEmpty())
  <div class="card empty">
    Abhi koi post nahi hai.
    <div style="margin-top:14px"><a class="btn btn-primary" href="{{ route('admin.posts.create') }}">Pehla post likho</a></div>
  </div>
@else
  <div class="tbl-wrap">
    <table>
      <thead>
        <tr>
          <th style="width:74px">Cover</th><th>Title</th><th>Category</th>
          <th>Date</th><th>Views</th><th>Status</th><th style="width:190px"></th>
        </tr>
      </thead>
      <tbody>
        @foreach($posts as $p)
          <tr>
            <td><img src="{{ $p->cover }}" alt="" style="width:60px;height:44px;object-fit:cover;border-radius:7px"></td>
            <td>
              <strong>{{ $p->title }}</strong>
              @if($p->is_featured)<span class="pill pill-warn">★ Featured</span>@endif
              <div class="hint">/blog/{{ $p->slug }}</div>
            </td>
            <td>{{ $p->category_label }}</td>
            <td>{{ $p->date_label ?: '—' }}<div class="hint">{{ $p->reading_time }}</div></td>
            <td>{{ number_format($p->views) }}</td>
            <td>
              <span class="pill {{ $p->status === 'published' ? 'pill-ok' : 'pill-off' }}">
                {{ ucfirst($p->status) }}
              </span>
            </td>
            <td>
              <div style="display:flex;gap:6px;flex-wrap:wrap">
                @if($p->status === 'published')
                  <a class="btn btn-ghost btn-sm" href="{{ route('post', $p->slug) }}" target="_blank">View</a>
                @endif
                <a class="btn btn-primary btn-sm" href="{{ route('admin.posts.edit', $p) }}">Edit</a>
                <form method="POST" action="{{ route('admin.posts.destroy', $p) }}"
                      onsubmit="return confirm('Ye post hamesha ke liye hat jayega. Pakka?')">
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

  <div style="margin-top:18px">{{ $posts->links() }}</div>
@endif
@endsection
