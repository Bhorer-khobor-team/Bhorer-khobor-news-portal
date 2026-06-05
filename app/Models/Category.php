<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'order', 'status'];

    // Auto-generate slug from name when creating
    protected static function booted(): void
    {
        static::creating(function (Category $category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    // One category has many news articles
    public function news()
    {
        return $this->hasMany(News::class);
    }

    // Scope: only active categories
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Scope: sorted by the order column
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
