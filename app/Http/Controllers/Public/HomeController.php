<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\News;

class HomeController extends Controller
{
    public function index()
    {
        // Up to 5 featured published articles for hero carousel
        $featuredNews = News::published()->featured()
            ->with('category')
            ->latest('published_at')
            ->limit(5)
            ->get();

        // Main grid: paginated 12 per page
        $latestNews = News::published()
            ->with('category')
            ->latest('published_at')
            ->paginate(12);

        // All active ads keyed by position string
        // Usage in view: $advertisements['home_top'], $advertisements['home_middle'] etc.
        $advertisements = Advertisement::active()
            ->get()
            ->keyBy('position');

        return view('public.home', compact('featuredNews', 'latestNews', 'advertisements'));
    }
}