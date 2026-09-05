@extends('layouts.admin')
@section('content')
@php
    $new = !$post->exists;

    /* FAQ textarea ka roop: sawaal, agli line jawab, phir khaali line.
       JSON dikhana maalik ke liye theek nahi -- ek bracket chhoot jaye
       to poora FAQ chala jaata hai. */
    $faqText = collect((array) $post->faq)
        ->map(fn ($f) => trim(($f['q'] ?? '') . "\n" . ($f['a'] ?? '')))
        ->filter()->implode("\n\n");
@endphp

<div class="top">
  <h1>{{ $new ? 'Add Blog Post' : 'Edit Blog Post' }}</h1>
  <div class="sp">
    @if(!$new && $post->status === 'published')
      <a class="btn btn-ghost" href="{{ route('post', $post->slug) }}" target="_blank">View on site ↗</a>
    @endif
    <a class="btn btn-ghost" href="{{ route('admin.posts.index') }}">← Back</a>
  </div>
</div>

<form method="POST" action="{{ $new ? route('admin.posts.store') : route('admin.posts.update', $post) }}">
  @csrf
  @unless($new) @method('PUT') @endunless

  <div class="card">
    <h2>Post</h2>

    <div class="row">
      <div>
        <label for="fTitle">Title *</label>
        <input type="text" id="fTitle" name="title" value="{{ old('title', $post->title) }}" required
               placeholder="How to Check Land Records Before Buying in Morni">
        <div class="hint">Sawaal jaisa title achha chalta hai — log Google par waise hi likhte hain.</div>
      </div>
    </div>

    <div class="row r3">
      <div>
        <label for="fCat">Category *</label>
        <select id="fCat" name="category" required>
          @foreach(\App\Models\Post::CATEGORIES as $k => $v)
            <option value="{{ $k }}" @selected(old('category', $post->category ?: 'guide') === $k)>{{ $v }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label for="fStatus">Status *</label>
        <select id="fStatus" name="status" required>
          <option value="draft"     @selected(old('status', $post->status ?: 'draft') === 'draft')>Draft — site par nahi dikhega</option>
          <option value="published" @selected(old('status', $post->status) === 'published')>Published — live</option>
        </select>
      </div>
      <div>
        <label for="fDate">Publish date</label>
        <input type="date" id="fDate" name="published_at"
               value="{{ old('published_at', optional($post->published_at)->format('Y-m-d')) }}">
        <div class="hint">Aage ki tareekh daalo to us din apne aap chhapega.</div>
      </div>
    </div>

    <div class="row">
      <div>
        <label for="fExc">Short summary</label>
        <textarea id="fExc" name="excerpt" style="min-height:70px" maxlength="400">{{ old('excerpt', $post->excerpt) }}</textarea>
        <div class="hint">Do line. Blog list par aur Google mein yahi dikhta hai. Khaali chhodo to content se apne aap ban jayega.</div>
      </div>
    </div>

    <div class="row">
      <div>
        <label for="fContent">Content</label>
        <textarea id="fContent" name="content" style="min-height:400px;font-family:ui-monospace,Consolas,monospace;font-size:13.5px">{{ old('content', $post->content) }}</textarea>
        <div class="hint">
          HTML likh sakte ho: <code>&lt;h2&gt;Heading&lt;/h2&gt;</code>,
          <code>&lt;p&gt;paragraph&lt;/p&gt;</code>,
          <code>&lt;ul&gt;&lt;li&gt;point&lt;/li&gt;&lt;/ul&gt;</code>,
          <code>&lt;table&gt;</code>. H1 mat lagana — wo title se apne aap aata hai.
        </div>
      </div>
    </div>

    <label style="display:flex;align-items:center;gap:9px;font-weight:600;margin-top:6px">
      <input type="checkbox" name="is_featured" value="1" style="width:auto"
             @checked(old('is_featured', $post->is_featured))>
      Blog list mein sabse upar rakho
    </label>
  </div>

  <div class="card">
    <h2>FAQ <span style="font-weight:400;font-size:13px;color:var(--muted)">(Google ko inhi se sawaal-jawab dikhte hain)</span></h2>
    <div class="row">
      <div>
        <label for="fFaq">Ek sawaal, agli line par jawab, phir khaali line</label>
        <textarea id="fFaq" name="faq_text" style="min-height:200px" placeholder="Can outsiders buy land in Morni?
Yes. Residential plots in Morni can be bought by any Indian citizen, unlike Himachal.

How long does registry take?
Usually three to six weeks if the papers are clean.">{{ old('faq_text', $faqText) }}</textarea>
        <div class="hint">Jitne chaho utne. Page par accordion banega aur FAQPage schema bhi.</div>
      </div>
    </div>
  </div>

  <div class="card">
    <h2>Author</h2>
    <div class="row r2">
      <div>
        <label for="fAuth">Author name</label>
        <input type="text" id="fAuth" name="author_name" value="{{ old('author_name', $post->author_name) }}"
               placeholder="Sandeep — Sky Property">
        <div class="hint">Khaali chhodo to "Sky Property team" likha aayega.</div>
      </div>
      <div>
        <label for="fBio">Author bio</label>
        <textarea id="fBio" name="author_bio" style="min-height:70px" maxlength="600">{{ old('author_bio', $post->author_bio) }}</textarea>
        <div class="hint">Kitne saal se ye kaam kar rahe ho — Google ise "experience" maanta hai.</div>
      </div>
    </div>
  </div>

  <div class="card">
    <h2>SEO <span style="font-weight:400;font-size:13px;color:var(--muted)">(khaali chhodo to apne aap ban jayega)</span></h2>
    <div class="row r2">
      <div>
        <label for="fSlug">URL slug</label>
        <input type="text" id="fSlug" name="slug" value="{{ old('slug', $post->slug) }}"
               placeholder="{{ $new ? 'title se apne aap banega' : $post->slug }}">
        <div class="hint">⚠ Live post ka slug badalne se purana link toot jaata hai.</div>
      </div>
      <div>
        <label for="fMeta">Meta title</label>
        <input type="text" id="fMeta" name="meta_title" value="{{ old('meta_title', $post->meta_title) }}">
      </div>
    </div>
    <div class="row">
      <div>
        <label for="fMetaD">Meta description</label>
        <textarea id="fMetaD" name="meta_description" style="min-height:60px" maxlength="400">{{ old('meta_description', $post->meta_description) }}</textarea>
      </div>
    </div>
    <div class="row r2">
      <div>
        <label for="fKw">Keywords</label>
        <input type="text" id="fKw" name="keywords" value="{{ old('keywords', $post->keywords) }}"
               placeholder="land in morni, morni plot rate, morni property">
      </div>
      <div>
        <label for="fSort">Sort order</label>
        <input type="number" id="fSort" name="sort_order" min="0" value="{{ old('sort_order', $post->sort_order ?? 0) }}">
      </div>
    </div>
    <div class="row">
      <div>
        <label for="fAlt">Cover photo ka alt text</label>
        <input type="text" id="fAlt" name="cover_alt" value="{{ old('cover_alt', $post->cover_alt) }}"
               placeholder="Terraced farm land in Morni Hills with valley view">
        <div class="hint">
          Photo mein kya dikh raha hai, ek line mein. Screen reader aur Google image
          search dono isi ko padhte hain. Khaali chhodo to title lag jayega.
        </div>
      </div>
    </div>
  </div>

  <button class="btn btn-primary" type="submit" style="padding:13px 30px">
    {{ $new ? 'Save & Add Cover Photo' : 'Save Changes' }}
  </button>
</form>

@unless($new)
  <div class="card" style="margin-top:22px">
    <h2>Cover photo</h2>

    <form method="POST" action="{{ route('admin.posts.cover', $post) }}" enctype="multipart/form-data"
          style="display:flex;gap:11px;align-items:end;flex-wrap:wrap;margin-bottom:18px">
      @csrf
      <div style="flex:1;min-width:240px">
        <label for="fCover">Photo chuno</label>
        <input type="file" id="fCover" name="cover" accept="image/*" required>
        <div class="hint">6 MB tak. Chaudi photo achhi lagti hai (16:9).</div>
      </div>
      <button class="btn btn-primary" type="submit">Upload</button>
    </form>

    <img src="{{ $post->cover }}" alt="{{ $post->cover_alt }}"
         style="max-width:420px;width:100%;border-radius:11px;border:1px solid var(--line)">

    @unless($post->cover_image)
      <div class="hint" style="margin-top:9px">
        Abhi apni photo nahi lagi — filhaal ek default photo dikh rahi hai.
      </div>
    @endunless
  </div>
@endunless
@endsection
