<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
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

        return view('site.home', compact('featured', 'counts'));
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

    public function about()
    {
        return view('site.about');
    }

    public function contact()
    {
        return view('site.contact');
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
