<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        // Get search term from query string: /search?q=keyword
        $query = $request->input('q', '');

        $results = collect(); // empty collection if no query

        if (!empty($query)) {
            $results = News::published()
                ->where(function ($q) use ($query) {
                    // Search across three columns
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('subtitle', 'like', "%{$query}%")
                      ->orWhere('body', 'like', "%{$query}%");
                })
                ->with('category')
                ->latest('published_at')
                ->paginate(15)
                ->withQueryString(); // keeps ?q=keyword in pagination links
        }

        return view('public.search', compact('query', 'results'));
    }
}
