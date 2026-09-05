<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use App\Models\Post;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'total'      => Property::count(),
            'available'  => Property::where('status', 'available')->count(),
            'sold'       => Property::whereIn('status', ['sold', 'rented'])->count(),
            'enquiries'  => Enquiry::count(),
            'unseen'     => Enquiry::unseen()->count(),
            'latest'     => Enquiry::latest('id')->take(5)->get(),
            'recent'     => Property::latest('id')->take(5)->get(),
            'posts'      => Post::count(),
            'postsLive'  => Post::where('status', 'published')->count(),
            'postsDraft' => Post::where('status', 'draft')->count(),
            'recentPost' => Post::latest('id')->take(5)->get(),
        ]);
    }

    public function index(Request $request)
    {
        $q = Property::query();

        if ($s = trim((string) $request->query('q'))) {
            $q->where(fn ($w) => $w->where('title', 'like', "%{$s}%")
                                   ->orWhere('locality', 'like', "%{$s}%"));
        }
        if ($t = $request->query('type')) {
            $q->where('type', $t);
        }

        $properties = $q->orderBy('sort_order')->latest('id')->paginate(15)->withQueryString();

        return view('admin.properties.index', compact('properties'));
    }

    public function create()
    {
        return view('admin.properties.form', ['property' => new Property()]);
    }

    public function store(Request $request)
    {
        $p = Property::create($this->clean($request));

        return redirect()->route('admin.properties.edit', $p)
            ->with('ok', 'Property add ho gayi. Ab photo lagao.');
    }

    public function edit(Property $property)
    {
        return view('admin.properties.form', compact('property'));
    }

    public function update(Request $request, Property $property)
    {
        $property->update($this->clean($request, $property));

        return back()->with('ok', 'Save ho gaya.');
    }

    public function destroy(Property $property)
    {
        /* Uploaded files bhi hata rahe hain. Property delete karke
           images chhod dete to disk bharta rehta aur kabhi pata nahi
           chalta ki kis file ka koi maalik nahi raha. */
        foreach ((array) $property->images as $img) {
            $this->deleteUpload($img);
        }
        $this->deleteUpload($property->cover_image);

        $property->delete();

        return redirect()->route('admin.properties.index')->with('ok', 'Property hata di.');
    }

    /* ── photo ───────────────────────────────────────────────── */

    public function uploadImages(Request $request, Property $property)
    {
        $request->validate([
            'images'   => ['required', 'array'],
            'images.*' => ['image', 'max:6144'],   // 6 MB
        ]);

        $imgs = (array) $property->images;

        foreach ($request->file('images') as $file) {
            $path   = $file->store('properties', 'public');
            $imgs[] = Storage::url($path);
        }

        /* Pehli photo apne aap cover ban jaati hai. Warna nayi property
           placeholder ke saath dikhti rehti hai aur maalik ko samajh
           nahi aata kyun. */
        $property->update([
            'images'      => array_values(array_unique($imgs)),
            'cover_image' => $property->cover_image ?: ($imgs[0] ?? null),
        ]);

        return back()->with('ok', count($request->file('images')) . ' photo lag gayi.');
    }

    public function deleteImage(Request $request, Property $property)
    {
        $url  = (string) $request->input('url');
        $imgs = array_values(array_filter((array) $property->images, fn ($i) => $i !== $url));

        $this->deleteUpload($url);

        $property->update([
            'images'      => $imgs,
            'cover_image' => $property->cover_image === $url ? ($imgs[0] ?? null) : $property->cover_image,
        ]);

        return back()->with('ok', 'Photo hata di.');
    }

    public function setCover(Request $request, Property $property)
    {
        $property->update(['cover_image' => (string) $request->input('url')]);

        return back()->with('ok', 'Cover photo badal gayi.');
    }

    /* ── andar ki cheezein ───────────────────────────────────── */

    private function clean(Request $request, ?Property $existing = null): array
    {
        $data = $request->validate([
            'title'             => ['required', 'string', 'max:190'],
            'type'              => ['required', 'string', 'max:30'],
            'listing'           => ['required', 'string', 'max:10'],
            'price'             => ['nullable', 'numeric', 'min:0'],
            'price_note'        => ['nullable', 'string', 'max:60'],
            'area'              => ['nullable', 'numeric', 'min:0'],
            'area_unit'         => ['nullable', 'string', 'max:20'],
            'bedrooms'          => ['nullable', 'integer', 'min:0', 'max:60'],
            'bathrooms'         => ['nullable', 'integer', 'min:0', 'max:60'],
            'locality'          => ['nullable', 'string', 'max:120'],
            'city'              => ['nullable', 'string', 'max:120'],
            'district'          => ['nullable', 'string', 'max:120'],
            'state'             => ['nullable', 'string', 'max:120'],
            'pincode'           => ['nullable', 'string', 'max:12'],
            'short_description' => ['nullable', 'string', 'max:400'],
            'description'       => ['nullable', 'string'],
            'ownership'         => ['nullable', 'string', 'max:120'],
            'facing'            => ['nullable', 'string', 'max:60'],
            'approach_road'     => ['nullable', 'string', 'max:120'],
            'map_embed'         => ['nullable', 'string', 'max:2000'],
            'status'            => ['required', 'string', 'max:20'],
            'sort_order'        => ['nullable', 'integer', 'min:0'],
            'meta_title'        => ['nullable', 'string', 'max:190'],
            'meta_description'  => ['nullable', 'string', 'max:400'],
            'features_text'     => ['nullable', 'string'],
        ]);

        /* Features textarea mein ek line par ek likhe jaate hain. Ye
           JSON se aasan hai -- maalik ko bracket aur comma se matlab
           nahi rakhna padta. */
        $data['features'] = collect(preg_split('~\R~', (string) $request->input('features_text')))
            ->map(fn ($l) => trim($l))
            ->filter()
            ->values()
            ->all();

        unset($data['features_text']);

        $data['price']       = (int) ($data['price'] ?? 0);
        $data['is_featured'] = $request->boolean('is_featured');

        /* Title badla to slug bhi badalna chahiye -- par sirf tab jab
           maalik ne khud slug na likha ho. Live URL ko bina kahe
           badalna theek nahi. */
        if ($slug = trim((string) $request->input('slug'))) {
            $data['slug'] = Property::uniqueSlug($slug, $existing?->id);
        } elseif (!$existing) {
            $data['slug'] = Property::uniqueSlug($data['title']);
        }

        return $data;
    }

    /** Sirf apni upload ki hui file hatate hain, bahar ke URL nahi. */
    private function deleteUpload(?string $url): void
    {
        if (!$url || !str_starts_with($url, '/storage/')) {
            return;
        }

        Storage::disk('public')->delete(substr($url, strlen('/storage/')));
    }
}
