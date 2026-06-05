<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\News;

class NewsController extends Controller
{
    public function show(string $slug)
    {
        // Find published article by slug — 404 if not found
        $news = News::published()
            ->with(['category', 'admin', 'tags'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment the view counter by 1
        $news->incrementViews();

        // 3 related articles from the same category (excluding current)
        $relatedNews = News::published()
            ->where('category_id', $news->category_id)
            ->where('id', '!=', $news->id)
            ->latest('published_at')
            ->limit(3)
            ->get();

        // Inline ad for the article page
        $articleAd = Advertisement::active()
            ->where('position', 'article_inline')
            ->first();

        return view('public.news.show', compact('news', 'relatedNews', 'articleAd'));
    }
}
