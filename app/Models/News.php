<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    protected $fillable = [
        'title', 'subtitle', 'slug', 'body', 'image', 'image_source',
        'news_source', 'is_featured', 'category_id', 'admin_id',
        'status', 'views', 'published_at',
    ];

    protected $casts = [
        'is_featured'  => 'boolean',
        'published_at' => 'datetime',
    ];

    // Auto-generate slug and set published_at automatically
    protected static function booted(): void
    {
        static::creating(function (News $news) {
            if (empty($news->slug)) {
                $news->slug = Str::slug($news->title);
            }

            if ($news->status === 'published' && empty($news->published_at)) {
                $news->published_at = now();
            }
        });

        static::updating(function (News $news) {
            if ($news->status === 'published' && empty($news->published_at)) {
                $news->published_at = now();
            }
        });
    }

    // Each article belongs to one category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Each article is written by one admin
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    // An article can have many tags
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'news_tag');
    }

    // Only published articles
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    // Only featured articles (for hero carousel)
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Increment view count
    public function incrementViews(): void
    {
        $this->increment('views');
    }
}
