<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\Post;
use App\Models\Property;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function home()
    {
        $featured = Property::visible()->where('is_featured', true)
            ->orderBy('sort_order')->latest('id')->take(6)->get();

        /* Chhe se kam featured hon to baaki nayi property se bhar dete
           hain. Teen card ki adhoori row homepage ko khaali dikhati hai,
           aur shuruaat mein to koi featured hoti hi nahi. */
        if ($featured->count() < 6) {
            $featured = $featured->concat(
                Property::visible()
                    ->whereNotIn('id', $featured->pluck('id'))
                    ->orderBy('sort_order')->latest('id')
                    ->take(6 - $featured->count())->get()
            );
        }

        $counts = [
            'total' => Property::visible()->count(),
            'plot'  => Property::visible()->whereIn('type', ['plot', 'land'])->count(),
            'house' => Property::visible()->whereIn('type', ['farmhouse', 'cottage'])->count(),
            'stay'  => Property::visible()->whereIn('type', ['resort', 'homestay'])->count(),
        ];

        /* Homepage ka price table asli listings se banta hai, likha hua
           nahi. Ek haath se likhi price guide us din purani ho jaati hai
           jis din rate badalte hain, aur phir wo jhooth bolti rehti hai.
           Isse jo dikhega wo hamesha wahi hoga jo sach mein bik raha hai. */
        $priceGuide = Property::visible()
            ->where('listing', 'sale')->where('price', '>', 0)
            ->selectRaw('type, COUNT(*) AS n, MIN(price) AS lo, MAX(price) AS hi')
            ->groupBy('type')->get()
            ->sortBy(fn ($r) => array_search($r->type, array_keys(Property::TYPES)));

        return view('site.home', compact('featured', 'counts', 'priceGuide'));
    }

    /**
     * Listing, filter ke saath.
     *
     * Filter query string mein rehte hain taaki link bheja ja sake --
     * "Morni ke 2 kanal wale plot dekho" ek URL mein aa jaata hai.
     */
    public function properties(Request $request)
    {
        $q = Property::visible();

        if ($t = $request->query('type')) {
            $q->where('type', $t);
        }

        if ($l = $request->query('listing')) {
            $q->where('listing', $l);
        }

        if ($loc = trim((string) $request->query('locality'))) {
            $q->where(function ($w) use ($loc) {
                $w->where('locality', 'like', "%{$loc}%")
                  ->orWhere('city', 'like', "%{$loc}%")
                  ->orWhere('title', 'like', "%{$loc}%");
            });
        }

        /* Budget lakh mein aata hai, database mein rupaye hain. Form
           par "50 lakh" likhna aasan hai, "5000000" nahi. */
        if (($min = (int) $request->query('min')) > 0) {
            $q->where('price', '>=', $min * 100000);
        }
        if (($max = (int) $request->query('max')) > 0) {
            $q->where('price', '<=', $max * 100000);
        }

        match ($request->query('sort')) {
            'price_low'  => $q->orderByRaw('price = 0, price asc'),
            'price_high' => $q->orderBy('price', 'desc'),
            default      => $q->orderBy('sort_order')->latest('id'),
        };

        $properties = $q->paginate(9)->withQueryString();

        return view('site.properties', compact('properties'));
    }

    public function show(string $slug)
    {
        $property = Property::visible()->where('slug', $slug)->firstOrFail();

        $similar = Property::visible()
            ->where('id', '!=', $property->id)
            ->where('type', $property->type)
            ->latest('id')->take(3)->get();

        /* Ek hi type ki teen na milein to kuch aur dikha dete hain --
           page ke aakhir mein khaali jagah chhodne se behtar hai. */
        if ($similar->count() < 3) {
            $similar = $similar->concat(
                Property::visible()
                    ->where('id', '!=', $property->id)
                    ->whereNotIn('id', $similar->pluck('id'))
                    ->latest('id')->take(3 - $similar->count())->get()
            );
        }

        return view('site.show', compact('property', 'similar'));
    }

    public function blog(Request $request)
    {
        $q = Post::live();

        if ($c = $request->query('category')) {
            $q->where('category', $c);
        }
        if ($s = trim((string) $request->query('q'))) {
            $q->where(fn ($w) => $w->where('title', 'like', "%{$s}%")
                                   ->orWhere('excerpt', 'like', "%{$s}%")
                                   ->orWhere('content', 'like', "%{$s}%"));
        }

        $posts = $q->orderByDesc('is_featured')
                   ->orderByDesc('published_at')->latest('id')
                   ->paginate(9)->withQueryString();

        return view('site.blog', compact('posts'));
    }

    public function post(string $slug)
    {
        $post = Post::live()->where('slug', $slug)->firstOrFail();

        /* Ginti seedha badha rahe hain, model event se nahi -- warna
           har save par bhi badh jaati. Ye asli analytics nahi hai, bas
           maalik ko andaaza dene ke liye ki kaunsa lekh chal raha hai. */
        Post::whereKey($post->id)->increment('views');

        $more = Post::live()->where('id', '!=', $post->id)
            ->orderByRaw('category = ? desc', [$post->category])
            ->orderByDesc('published_at')->take(3)->get();

        return view('site.post', compact('post', 'more'));
    }

    public function about()
    {
        return view('site.about');
    }

    public function contact()
    {
        return view('site.contact');
    }

    /**
     * sitemap.xml -- database se banta hai, file se nahi.
     *
     * Ek likhi hui file har nayi property par haath se badalni padti,
     * aur ek din wo bhoolna hi tha. Yahan property add karte hi wo
     * sitemap mein aa jaati hai.
     *
     * Sirf `visible` aati hain. Hidden property ka link Google ko dena
     * uska waqt kharab karna hai -- wahan pahunch kar use 404 milta.
     */
    public function sitemap()
    {
        $urls = [
            ['loc' => route('home'),       'pri' => '1.0', 'freq' => 'daily'],
            ['loc' => route('properties'), 'pri' => '0.9', 'freq' => 'daily'],
            ['loc' => route('about'),      'pri' => '0.6', 'freq' => 'monthly'],
            ['loc' => route('contact'),    'pri' => '0.7', 'freq' => 'monthly'],
        ];

        /* Type wale filter page bhi bhej rahe hain -- "farmhouse in
           Morni" jaisi search inhi par utarti hai, aur ye asli alag
           page hain, ek jaise nahi. */
        foreach (array_keys(Property::TYPES) as $type) {
            if (Property::visible()->where('type', $type)->exists()) {
                $urls[] = ['loc' => route('properties', ['type' => $type]), 'pri' => '0.7', 'freq' => 'weekly'];
            }
        }

        $urls[] = ["loc" => route("blog"), "pri" => "0.8", "freq" => "weekly"];

        foreach (Post::live()->latest("updated_at")->get() as $b) {
            $urls[] = [
                "loc"  => route("post", $b->slug),
                "pri"  => "0.7",
                "freq" => "monthly",
                "mod"  => optional($b->updated_at)->toAtomString(),
            ];
        }

        foreach (Property::visible()->latest('updated_at')->get() as $p) {
            $urls[] = [
                'loc'  => route('property', $p->slug),
                'pri'  => $p->is_featured ? '0.9' : '0.8',
                'freq' => 'weekly',
                'mod'  => optional($p->updated_at)->toAtomString(),
            ];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n"
             . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $u) {
            $xml .= "  <url>\n"
                 .  '    <loc>' . htmlspecialchars($u['loc'], ENT_XML1) . "</loc>\n"
                 .  (isset($u['mod']) ? '    <lastmod>' . $u['mod'] . "</lastmod>\n" : '')
                 .  '    <changefreq>' . $u['freq'] . "</changefreq>\n"
                 .  '    <priority>' . $u['pri'] . "</priority>\n"
                 .  "  </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    /**
     * robots.txt -- yahan se isliye ki sitemap ka poora URL apne aap
     * bane. File mein likhte to domain badalne par wo galat reh jaata.
     */
    public function robots()
    {
        $txt = "User-agent: *\n"
             . "Allow: /\n"
             . "Disallow: /admin\n"
             . "Disallow: /login\n\n"
             . 'Sitemap: ' . url('/sitemap.xml') . "\n";

        return response($txt, 200)->header('Content-Type', 'text/plain; charset=UTF-8');
    }

    public function enquiry(Request $request)
    {
        /* Honeypot. Bot har field bharta hai, insaan is chhupe hue box
           ko dekh hi nahi paata -- to bhara hua matlab bot. Chupchaap
           "shukriya" keh dete hain, warna bot ko pata chal jaata hai
           ki pakda gaya aur wo tareeka badal leta hai. */
        if (filled($request->input('website'))) {
            return back()->with('ok', 'Thank you. We will call you shortly.');
        }

        $data = $request->validate([
            'name'        => ['required', 'string', 'max:120'],
            'phone'       => ['required', 'string', 'max:20'],
            'email'       => ['nullable', 'email', 'max:160'],
            'message'     => ['nullable', 'string', 'max:2000'],
            'budget'      => ['nullable', 'string', 'max:60'],
            'property_id' => ['nullable', 'integer', 'exists:properties,id'],
        ]);

        $property = $data['property_id'] ?? null
            ? Property::find($data['property_id'])
            : null;

        Enquiry::create($data + [
            'property_title' => $property?->title,
            'source_page'    => $request->input('source_page') ?: url()->previous(),
        ]);

        return back()->with('ok', 'Thank you. We have your details and will call you shortly.');
    }
}
