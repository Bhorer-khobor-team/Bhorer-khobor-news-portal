<?php


namespace App\Providers;


use App\Models\Advertisement;
use App\Models\Category;
use App\Models\News;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Share these 4 variables with ALL public.* views automatically
        // This runs once per request — no need to pass them in every controller
        View::composer('public.*', function ($view) {


            // Navigation categories — active only, ordered by 'order' column
            // withCount(['news' => ...]) adds news_count property to each category
            $navCategories = Category::active()
                ->ordered()
                ->withCount(['news' => fn($q) => $q->published()])
                ->get();


            // Sidebar: 5 latest published articles with their category
            $sidebarNews = News::published()
                ->with('category')
                ->latest('published_at')
                ->limit(5)
                ->get();


            // Breaking news ticker: 10 latest headlines
            $breakingNews = News::published()
                ->latest('published_at')
                ->limit(10)
                ->get();


            // Sidebar advertisement (sidebar_top position)
            $sidebarAd = Advertisement::active()
                ->where('position', 'sidebar_top')
                ->first();


            $view->with(compact('navCategories', 'sidebarNews', 'breakingNews', 'sidebarAd'));
        });
    }
}

