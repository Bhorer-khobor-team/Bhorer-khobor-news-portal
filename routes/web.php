<?php


use App\Http\Controllers\Admin;
use App\Http\Controllers\Public;
use Illuminate\Support\Facades\Route;


// ─── Public Routes ───────────────────────────────────


Route::name('public.')->group(function () {
    Route::get('/', [Public\HomeController::class, 'index'])->name('home');
    Route::get('/news/{slug}', [Public\NewsController::class, 'show'])->name('news.show');
    Route::get('/category/{slug}', [Public\CategoryController::class, 'show'])->name('category.show');
    Route::get('/search', [Public\SearchController::class, 'index'])->name('search');
    Route::get('/privacy-policy', [Public\PageController::class, 'privacy'])->name('privacy');
    Route::get('/terms-and-conditions', [Public\PageController::class, 'terms'])->name('terms');
});


// ─── Admin Auth Routes ────────────────────────────────


Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('admin.guest')->group(function () {
        Route::get('/login',  [Admin\AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [Admin\AuthController::class, 'login']);
    });


    Route::middleware('admin.auth')->group(function () {
        Route::post('/logout',   [Admin\AuthController::class,    'logout'])->name('logout');
        Route::get('/dashboard', [Admin\DashboardController::class,'index'] )->name('dashboard');


        Route::resource('news',           Admin\NewsController::class);
        Route::resource('categories',     Admin\CategoryController::class);
        Route::resource('advertisements', Admin\AdvertisementController::class);
        Route::resource('admins',         Admin\AdminController::class);
        Route::resource('roles',          Admin\RoleController::class);


        Route::get( '/privacy-policy',   [Admin\PrivacyPolicyController::class,'edit']  )->name('privacy.edit');
        Route::put( '/privacy-policy',   [Admin\PrivacyPolicyController::class,'update'])->name('privacy.update');
        Route::get( '/terms-conditions', [Admin\TermsController::class,'edit']  )->name('terms.edit');
        Route::put( '/terms-conditions', [Admin\TermsController::class,'update'])->name('terms.update');
    });
});

