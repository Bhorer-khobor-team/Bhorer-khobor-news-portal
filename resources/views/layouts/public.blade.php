<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ভোরের খবর') | ভোরের খবর</title>
    <meta name="description" content="@yield('meta_description', 'বাংলাদেশের সর্বশেষ সংবাদ - ভোরের খবর')">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/bhorer-khobor.css') }}">
    @stack('styles')
</head>
<body>

{{-- Top Bar --}}
<div class="bk-topbar py-1">
    <div class="container-fluid px-3">
        <div class="d-flex justify-content-between align-items-center">
            <small class="text-white-50">
                <i class="bi bi-calendar3 me-1"></i>
                {{ now()->locale('bn')->isoFormat('dddd, D MMMM YYYY') }}
            </small>
            <div class="d-flex gap-3">
                <a href="{{ route('public.privacy') }}" class="text-white-50 small text-decoration-none">গোপনীয়তা নীতি</a>
                <a href="{{ route('public.terms') }}" class="text-white-50 small text-decoration-none">শর্তাবলী</a>
            </div>
        </div>
    </div>
</div>

{{-- Main Navbar --}}
<nav class="navbar navbar-expand-lg bk-navbar sticky-top">
    <div class="container-fluid px-3">
        <a class="navbar-brand bk-brand" href="{{ route('public.home') }}">
    <img src="{{ asset('images/logo.png') }}"
         alt="ভোরের খবর লোগো"
         style="height:42px; width:auto; object-fit:contain; margin-right:8px; vertical-align:middle;">
    <span class="bk-brand-text">ভোরের খবর</span>
</a>
        <button class="navbar-toggler text-white border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <i class="bi bi-list fs-4"></i>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto ms-3">
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('public.home') ? 'active' : '' }}" href="{{ route('public.home') }}">হোম</a>
                </li>
                @foreach($navCategories->take(6) as $cat)
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->is('category/' . $cat->slug) ? 'active' : '' }}"
                       href="{{ route('public.category.show', $cat->slug) }}">{{ $cat->name }}</a>
                </li>
                @endforeach
            </ul>
            <form class="d-flex" action="{{ route('public.search') }}" method="GET">
                <div class="input-group bk-search-bar">
                    <input class="form-control form-control-sm" type="search" name="q"
                           placeholder="সংবাদ খুঁজুন..." value="{{ request('q') }}">
                    <button class="btn btn-sm bk-search-btn" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</nav>

{{-- Breaking News Ticker --}}
@if(isset($breakingNews) && $breakingNews->isNotEmpty())
<div class="bk-breaking-news">
    <div class="container-fluid px-3">
        <div class="d-flex align-items-center">
            <span class="bk-breaking-label flex-shrink-0">
                <i class="bi bi-lightning-fill me-1"></i>সর্বশেষ
            </span>
            <div class="bk-ticker-wrap flex-grow-1 overflow-hidden">
                <div class="bk-ticker-content">
                    @foreach($breakingNews as $bn)
                    <a href="{{ route('public.news.show', $bn->slug) }}" class="text-decoration-none text-dark me-5">
                        {{ $bn->title }}
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- Category Nav Bar --}}
@if(isset($navCategories) && $navCategories->isNotEmpty())
<div class="bk-category-nav d-none d-lg-block">
    <div class="container-fluid px-3">
        <div class="d-flex align-items-center overflow-x-auto gap-1 py-1">
            @foreach($navCategories as $cat)
            <a href="{{ route('public.category.show', $cat->slug) }}"
               class="bk-cat-link {{ request()->is('category/' . $cat->slug) ? 'active' : '' }}">
                {{ $cat->name }}
                <span class="bk-cat-count">{{ $cat->news_count }}</span>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- Main Content --}}
<main class="bk-main py-4">
    @yield('content')
</main>

{{-- Footer --}}
<footer class="bk-footer pt-5 pb-3">
    <div class="container-fluid px-3">
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <h5 class="text-white mb-3">ভোরের খবর</h5>
                <p class="text-secondary small">বাংলাদেশের সর্বশেষ সংবাদ, বিশ্লেষণ ও তথ্যের জন্য ভোরের খবরের সাথে থাকুন।</p>
                <div class="d-flex gap-2 mt-3">
                    <a href="#" class="bk-social-btn"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="bk-social-btn"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="bk-social-btn"><i class="bi bi-youtube"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <h6 class="text-white mb-3">বিভাগসমূহ</h6>
                <ul class="list-unstyled">
                    @foreach($navCategories->take(6) as $cat)
                    <li class="mb-1">
                        <a href="{{ route('public.category.show', $cat->slug) }}" class="text-secondary text-decoration-none small bk-footer-link">
                            <i class="bi bi-chevron-right me-1"></i>{{ $cat->name }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-lg-3 col-md-6">
                <h6 class="text-white mb-3">দ্রুত লিংক</h6>
                <ul class="list-unstyled">
                    <li class="mb-1"><a href="{{ route('public.home') }}" class="text-secondary text-decoration-none small bk-footer-link"><i class="bi bi-chevron-right me-1"></i>হোম</a></li>
                    <li class="mb-1"><a href="{{ route('public.search') }}" class="text-secondary text-decoration-none small bk-footer-link"><i class="bi bi-chevron-right me-1"></i>অনুসন্ধান</a></li>
                    <li class="mb-1"><a href="{{ route('public.privacy') }}" class="text-secondary text-decoration-none small bk-footer-link"><i class="bi bi-chevron-right me-1"></i>গোপনীয়তা নীতি</a></li>
                    <li class="mb-1"><a href="{{ route('public.terms') }}" class="text-secondary text-decoration-none small bk-footer-link"><i class="bi bi-chevron-right me-1"></i>শর্তাবলী</a></li>
                    <li class="mb-1"><a href="{{ route('admin.login') }}" class="text-secondary text-decoration-none small bk-footer-link"><i class="bi bi-chevron-right me-1"></i>অ্যাডমিন প্যানেল</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6">
                <h6 class="text-white mb-3">যোগাযোগ</h6>
                <ul class="list-unstyled text-secondary small">
                    <li class="mb-2"><i class="bi bi-geo-alt me-2"></i>ঢাকা, বাংলাদেশ</li>
                    <li class="mb-2"><i class="bi bi-envelope me-2"></i>info@bhorerkhobor.com</li>
                    <li class="mb-2"><i class="bi bi-telephone me-2"></i>+880 1700-000000</li>
                </ul>
            </div>
        </div>
        <hr class="bk-footer-divider my-4">
        <div class="text-center text-secondary small">
            <p class="mb-0">&copy; {{ date('Y') }} ভোরের খবর। সকল স্বত্ব সংরক্ষিত।</p>
        </div>
    </div>
</footer>

{{-- Back to Top --}}
<button id="backToTop" class="bk-back-to-top" title="উপরে যান">
    <i class="bi bi-arrow-up"></i>
</button>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/bhorer-khobor.js') }}"></script>
@stack('scripts')
</body>
</html>
