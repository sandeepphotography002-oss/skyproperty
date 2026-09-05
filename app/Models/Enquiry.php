<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    protected $guarded = [];

    protected $casts = ['seen_at' => 'datetime'];

    public const STATUSES = [
        'new'       => 'New',
        'contacted' => 'Contacted',
        'visited'   => 'Site Visited',
        'closed'    => 'Closed',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    /** Jinpar abhi nazar nahi padi -- sidebar ka badge inhi ko ginta hai. */
    public function scopeUnseen($q)
    {
        return $q->whereNull('seen_at');
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst((string) $this->status);
    }
}
