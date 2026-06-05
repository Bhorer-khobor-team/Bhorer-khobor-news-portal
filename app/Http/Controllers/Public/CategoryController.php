<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;

class CategoryController extends Controller
{
    public function show(string $slug)
    {
        // Find active category by slug — 404 if not found
        $category = Category::active()->where('slug', $slug)->firstOrFail();

        // Get paginated published news for this category
        $news = News::published()
            ->where('category_id', $category->id)
            ->with('category')
            ->latest('published_at')
            ->paginate(12);

        return view('public.category.show', compact('category', 'news'));
    }
}
