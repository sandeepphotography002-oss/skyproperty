<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Property extends Model
{
    protected $guarded = [];

    protected $casts = [
        'features'    => 'array',
        'images'      => 'array',
        'is_featured' => 'boolean',
        'area'        => 'decimal:2',
    ];

    /** Site par dikhne wali sirf yahi hain. */
    public function scopeVisible($q)
    {
        return $q->where('status', '!=', 'hidden');
    }

    public function scopeAvailable($q)
    {
        return $q->where('status', 'available');
    }

    public function enquiries()
    {
        return $this->hasMany(Enquiry::class);
    }

    /* ── naam aur label ───────────────────────────────────────── */

    public const TYPES = [
        'plot'      => 'Plot',
        'land'      => 'Agricultural Land',
        'farmhouse' => 'Farmhouse',
        'cottage'   => 'Cottage',
        'resort'    => 'Resort',
        'homestay'  => 'Homestay',
    ];

    public const LISTINGS = [
        'sale' => 'For Sale',
        'rent' => 'For Rent',
    ];

    public const AREA_UNITS = ['marla', 'kanal', 'acre', 'bigha', 'sq ft'];

    public function getTypeLabelAttribute(): string
    {
        return self::TYPES[$this->type] ?? ucfirst((string) $this->type);
    }

    public function getListingLabelAttribute(): string
    {
        return self::LISTINGS[$this->listing] ?? 'For Sale';
    }

    /* ── daam ─────────────────────────────────────────────────── */

    /**
     * Daam ko "₹45 Lakh" / "₹1.2 Crore" mein badalta hai.
     *
     * Poora number (₹4,50,00,000) padhne mein waqt lagta hai aur card
     * par jagah bhi zyada leta hai. Lakh aur crore wahi hain jisme log
     * asal mein baat karte hain.
     */
    public function getPriceLabelAttribute(): string
    {
        $p = (int) $this->price;

        if ($p <= 0) {
            return 'Price on request';
        }

        if ($p >= 10000000) {
            $c = $p / 10000000;
            $out = '₹' . rtrim(rtrim(number_format($c, 2), '0'), '.') . ' Cr';
        } elseif ($p >= 100000) {
            $l = $p / 100000;
            $out = '₹' . rtrim(rtrim(number_format($l, 2), '0'), '.') . ' Lakh';
        } else {
            $out = '₹' . number_format($p);
        }

        return $this->price_note ? $out . ' ' . $this->price_note : $out;
    }

    public function getAreaLabelAttribute(): ?string
    {
        if ($this->area === null || (float) $this->area <= 0) {
            return null;
        }

        /* 8.00 ko "8" dikhate hain, 8.50 ko "8.5" -- trailing zero
           listing card par bekaar jagah lete hain. */
        $n = rtrim(rtrim(number_format((float) $this->area, 2), '0'), '.');

        return $n . ' ' . $this->area_unit;
    }

    /* ── image ────────────────────────────────────────────────── */

    /**
     * Cover na ho to pehli gallery image, wo bhi na ho to placeholder.
     * Har card ko kuch na kuch dikhana hai -- khaali dabba listing ko
     * adhoora dikhata hai.
     */
    public function getCoverAttribute(): string
    {
        if ($this->cover_image) {
            return $this->cover_image;
        }

        $imgs = $this->images ?? [];

        return $imgs[0] ?? 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=1200&q=70';
    }

    public function getFullLocationAttribute(): string
    {
        return collect([$this->locality, $this->city, $this->district])
            ->filter()
            ->unique()
            ->implode(', ');
    }

    /* ── slug ─────────────────────────────────────────────────── */

    protected static function booted(): void
    {
        static::saving(function (self $p) {
            if (blank($p->slug)) {
                $p->slug = self::uniqueSlug($p->title, $p->id);
            }
        });
    }

    /**
     * Do property ek hi naam ki ho sakti hain ("2 Kanal Plot in Morni"),
     * isliye takraav par -2, -3 lagate hain. Bina iske doosri save hi
     * nahi hoti, kyunki slug unique hai.
     */
    public static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'property';
        $slug = $base;
        $i    = 2;

        while (self::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
