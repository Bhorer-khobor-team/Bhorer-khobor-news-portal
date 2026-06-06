@extends('layouts.public')
@section('title', 'হোম')

@section('content')
<div class="container-fluid px-3">
    <div class="row g-4">
        <div class="col-lg-8">

            {{-- Hero Carousel (Featured News) --}}
            @if($featuredNews->isNotEmpty())
            <div id="heroCarousel" class="carousel slide bk-hero-carousel mb-4" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    @foreach($featuredNews as $i => $fn)
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $i }}"
                            class="{{ $i===0?'active':'' }}"></button>
                    @endforeach
                </div>
                <div class="carousel-inner rounded">
                    @foreach($featuredNews as $i => $fn)
                    <div class="carousel-item {{ $i===0?'active':'' }}">
                        <a href="{{ route('public.news.show', $fn->slug) }}">
                            @if($fn->image)
                            <img src="{{ Storage::url($fn->image) }}" class="d-block w-100 bk-hero-img"
                                 alt="{{ $fn->title }}" loading="{{ $i===0?'eager':'lazy' }}">
                            @else
                            <div class="bk-hero-placeholder d-flex align-items-center justify-content-center">
                                <i class="bi bi-image fs-1 text-muted"></i>
                            </div>
                            @endif
                        </a>
                        <div class="carousel-caption bk-carousel-caption">
                            <span class="badge bg-danger mb-2">{{ $fn->category->name }}</span>
                            <h5 class="fw-bold">
                                <a href="{{ route('public.news.show', $fn->slug) }}" class="text-white text-decoration-none">
                                    {{ Str::limit($fn->title, 90) }}
                                </a>
                            </h5>
                            <p class="small opacity-75 d-none d-md-block">{{ $fn->published_at?->diffForHumans() }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
            @endif

            {{-- Home Top Ad --}}
            @if(isset($advertisements['home_top']))
            <div class="bk-ad-block mb-4 text-center">
                <a href="{{ $advertisements['home_top']->link }}" target="_blank" rel="nofollow">
                    <img src="{{ Storage::url($advertisements['home_top']->image) }}"
                         alt="{{ $advertisements['home_top']->title }}" class="img-fluid rounded">
                </a>
            </div>
            @endif

            {{-- Latest News Grid --}}
            <h5 class="bk-section-title mb-3">
                <i class="bi bi-newspaper me-2"></i>সর্বশেষ সংবাদ
            </h5>
            <div class="row g-3">
                @foreach($latestNews as $i => $newsItem)

                {{-- Inline Ad every 6 items --}}
                @if($i > 0 && $i % 6 === 0 && isset($advertisements['home_middle']))
                <div class="col-12">
                    <div class="bk-ad-block text-center">
                        <a href="{{ $advertisements['home_middle']->link }}" target="_blank" rel="nofollow">
                            <img src="{{ Storage::url($advertisements['home_middle']->image) }}"
                                 alt="{{ $advertisements['home_middle']->title }}" class="img-fluid rounded">
                        </a>
                    </div>
                </div>
                @endif

                <div class="col-md-4 col-sm-6">
                    <div class="bk-news-card h-100">
                        <a href="{{ route('public.news.show', $newsItem->slug) }}" class="bk-card-img-link">
                            @if($newsItem->image)
                            <img src="{{ Storage::url($newsItem->image) }}" alt="{{ $newsItem->title }}"
                                 class="bk-card-img" loading="lazy">
                            @else
                            <div class="bk-card-img-placeholder">
                                <i class="bi bi-image fs-2 text-muted"></i>
                            </div>
                            @endif
                        </a>
                        <div class="bk-card-body">
                            <span class="bk-card-category">{{ $newsItem->category->name }}</span>
                            <h6 class="bk-card-title">
                                <a href="{{ route('public.news.show', $newsItem->slug) }}">
                                    {{ Str::limit($newsItem->title, 80) }}
                                </a>
                            </h6>
                            <div class="bk-card-meta">
                                <span><i class="bi bi-clock me-1"></i>{{ $newsItem->published_at?->diffForHumans() }}</span>
                                <span><i class="bi bi-eye me-1"></i>{{ number_format($newsItem->views) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-4">{{ $latestNews->links() }}</div>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">
            @include('public.partials.sidebar')
        </div>
    </div>
</div>
@endsection
