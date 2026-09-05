<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $q = Post::query();

        if ($s = trim((string) $request->query('q'))) {
            $q->where(fn ($w) => $w->where('title', 'like', "%{$s}%")
                                   ->orWhere('excerpt', 'like', "%{$s}%"));
        }
        if ($c = $request->query('category')) {
            $q->where('category', $c);
        }
        if ($st = $request->query('status')) {
            $q->where('status', $st);
        }

        $posts = $q->orderBy('sort_order')->latest('id')->paginate(15)->withQueryString();

        $stats = [
            'total'     => Post::count(),
            'published' => Post::where('status', 'published')->count(),
            'draft'     => Post::where('status', 'draft')->count(),
            'views'     => (int) Post::sum('views'),
        ];

        return view('admin.posts.index', compact('posts', 'stats'));
    }

    public function create()
    {
        return view('admin.posts.form', ['post' => new Post()]);
    }

    public function store(Request $request)
    {
        $post = Post::create($this->clean($request));

        return redirect()->route('admin.posts.edit', $post)->with('ok', 'Blog post ban gaya.');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.form', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $post->update($this->clean($request, $post));

        return back()->with('ok', 'Save ho gaya.');
    }

    public function destroy(Post $post)
    {
        $this->deleteUpload($post->cover_image);
        $post->delete();

        return redirect()->route('admin.posts.index')->with('ok', 'Post hata diya.');
    }

    public function uploadCover(Request $request, Post $post)
    {
        $request->validate(['cover' => ['required', 'image', 'max:6144']]);

        /* Purani cover hata rahe hain. Nayi lagakar purani chhod dete to
           disk bharti rehti aur kabhi pata nahi chalta ki wo file ab
           kisi kaam ki nahi. */
        $this->deleteUpload($post->cover_image);

        $path = $request->file('cover')->store('posts', 'public');

        $post->update(['cover_image' => Storage::url($path)]);

        return back()->with('ok', 'Cover photo lag gayi.');
    }

    private function clean(Request $request, ?Post $existing = null): array
    {
        $data = $request->validate([
            'title'            => ['required', 'string', 'max:190'],
            'category'         => ['required', 'string', 'max:30'],
            'excerpt'          => ['nullable', 'string', 'max:400'],
            'content'          => ['nullable', 'string'],
            'cover_alt'        => ['nullable', 'string', 'max:190'],
            'author_name'      => ['nullable', 'string', 'max:120'],
            'author_bio'       => ['nullable', 'string', 'max:600'],
            'meta_title'       => ['nullable', 'string', 'max:190'],
            'meta_description' => ['nullable', 'string', 'max:400'],
            'keywords'         => ['nullable', 'string', 'max:1000'],
            'status'           => ['required', 'string', 'max:20'],
            'sort_order'       => ['nullable', 'integer', 'min:0'],
            'published_at'     => ['nullable', 'date'],
            'faq_text'         => ['nullable', 'string'],
        ]);

        /* FAQ ek textarea mein likhe jaate hain:
             sawaal
             jawab
             (khaali line)
           JSON likhwana maalik se theek nahi -- ek bracket chhoot jaye
           to poora FAQ gayab ho jaata hai. */
        $faq = [];
        foreach (preg_split('~\R{2,}~', (string) $request->input('faq_text')) as $block) {
            $lines = array_values(array_filter(array_map('trim', preg_split('~\R~', $block))));
            if (count($lines) >= 2) {
                $faq[] = ['q' => array_shift($lines), 'a' => implode(' ', $lines)];
            }
        }
        $data['faq'] = $faq;
        unset($data['faq_text']);

        $data['is_featured'] = $request->boolean('is_featured');

        /* Publish karte waqt tareekh na di ho to abhi ki daal dete hain,
           warna lekh live to ho jaata hai par sitemap aur page dono
           bina tareekh ke dikhte hain. */
        if ($data['status'] === 'published' && blank($data['published_at'] ?? null)) {
            $data['published_at'] = $existing?->published_at ?? now();
        }

        if ($slug = trim((string) $request->input('slug'))) {
            $data['slug'] = Post::uniqueSlug($slug, $existing?->id);
        } elseif (!$existing) {
            $data['slug'] = Post::uniqueSlug($data['title']);
        }

        return $data;
    }

    private function deleteUpload(?string $url): void
    {
        if (!$url || !str_starts_with($url, '/storage/')) {
            return;
        }

        Storage::disk('public')->delete(substr($url, strlen('/storage/')));
    }
}
