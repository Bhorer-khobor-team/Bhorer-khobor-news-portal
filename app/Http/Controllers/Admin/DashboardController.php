<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\News;


class DashboardController extends Controller
{
    public function index()
    {
        // 4 stat card values
        $totalNews    = News::count();
        $todayNews    = News::whereDate('created_at', today())->count();
        $inactiveNews = News::where('status', 'inactive')->count();
        $totalAds     = Advertisement::count();


        // Recent news table — 10 latest with category and author
        $recentNews   = News::with(['category', 'admin'])
            ->latest()
            ->limit(10)
            ->get();


        return view('admin.dashboard', compact(
            'totalNews', 'todayNews', 'inactiveNews', 'totalAds', 'recentNews'
        ));
    }
}

