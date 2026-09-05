<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $guarded = [];

    protected $casts = [
        'faq'          => 'array',
        'is_featured'  => 'boolean',
        'published_at' => 'datetime',
    ];

    public const CATEGORIES = [
        'guide'      => 'Buying Guide',
        'area'       => 'Area Guide',
        'investment' => 'Investment',
        'legal'      => 'Papers & Legal',
        'news'       => 'News',
    ];

    /**
     * Site par sirf yahi dikhte hain.
     *
     * published_at ki shart isliye ki lekh aaj likha ja sake aur agle
     * hafte apne aap chhape. Sirf status dekhte to aage ki tareekh wala
     * lekh turant dikhne lag jaata.
     */
    public function scopeLive($q)
    {
        return $q->where('status', 'published')
                 ->where(fn ($w) => $w->whereNull('published_at')->orWhere('published_at', '<=', now()));
    }

    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? ucfirst((string) $this->category);
    }

    public function getCoverAttribute(): string
    {
        return $this->cover_image
            ?: 'https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?w=1200&q=70';
    }

    public function getDateLabelAttribute(): string
    {
        return ($this->published_at ?? $this->created_at)?->format('d M Y') ?? '';
    }

    /**
     * "6 min read".
     *
     * 200 shabd prati minute maana hai -- angrezi gadya ke liye yahi
     * aam andaaza hai. Ye number padhne wale ko batata hai ki abhi
     * padhein ya baad mein, aur bounce kam karta hai.
     */
    public function getReadingTimeAttribute(): string
    {
        $words = str_word_count(strip_tags((string) $this->content));

        return max(1, (int) ceil($words / 200)) . ' min read';
    }

    /** Excerpt na likha ho to content se pehli kuch line utha lete hain. */
    public function getSummaryAttribute(): string
    {
        if (filled($this->excerpt)) {
            return $this->excerpt;
        }

        return Str::limit(trim(preg_replace('~\s+~', ' ', strip_tags((string) $this->content))), 165);
    }

    protected static function booted(): void
    {
        static::saving(function (self $p) {
            if (blank($p->slug)) {
                $p->slug = self::uniqueSlug($p->title, $p->id);
            }
        });
    }

    public static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'post';
        $slug = $base;
        $i    = 2;

        while (self::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
