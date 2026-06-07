@extends('layouts.public')
@section('title', $news->title)
@section('meta_description', Str::limit(strip_tags($news->body), 160))

@section('content')
<div class="container-fluid px-3">
    <div class="row g-4">
        <div class="col-lg-8">

            {{-- Breadcrumb --}}
            <nav class="mb-3" aria-label="breadcrumb">
                <ol class="breadcrumb bk-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('public.home') }}">হোম</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('public.category.show', $news->category->slug) }}">
                            {{ $news->category->name }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active text-truncate" style="max-width:200px">
                        {{ Str::limit($news->title, 50) }}
                    </li>
                </ol>
            </nav>

            <article class="bk-article">
                {{-- Category badge --}}
                <a href="{{ route('public.category.show', $news->category->slug) }}"
                   class="badge bg-danger text-decoration-none mb-2">
                    {{ $news->category->name }}
                </a>

                {{-- Title and subtitle --}}
                <h1 class="bk-article-title">{{ $news->title }}</h1>
                @if($news->subtitle)
                <p class="bk-article-subtitle">{{ $news->subtitle }}</p>
                @endif

                {{-- Meta bar: author, date, time, views --}}
                <div class="bk-article-meta d-flex flex-wrap gap-3 align-items-center mb-3">
                    <span><i class="bi bi-person me-1"></i>{{ $news->admin->name ?? 'ভোরের খবর' }}</span>
                    <span><i class="bi bi-calendar3 me-1"></i>{{ $news->published_at?->format('d F Y') }}</span>
                    <span><i class="bi bi-clock me-1"></i>{{ $news->published_at?->format('h:i A') }}</span>
                    <span><i class="bi bi-eye me-1"></i>{{ number_format($news->views) }} পাঠক</span>
                </div>

                {{-- Featured image with source credit --}}
                @if($news->image)
                <figure class="bk-article-figure">
                    <img src="{{ Storage::url($news->image) }}" alt="{{ $news->title }}"
                         class="img-fluid rounded bk-article-img">
                    @if($news->image_source)
                    <figcaption class="text-muted small mt-1">ছবি: {{ $news->image_source }}</figcaption>
                    @endif
                </figure>
                @endif

                {{-- Inline article advertisement --}}
                @if(isset($articleAd) && $articleAd)
                <div class="bk-ad-block text-center my-4">
                    <a href="{{ $articleAd->link }}" target="_blank" rel="nofollow">
                        <img src="{{ Storage::url($articleAd->image) }}"
                             alt="{{ $articleAd->title }}" class="img-fluid rounded">
                    </a>
                </div>
                @endif

                {{-- Article body — unescaped HTML from Summernote --}}
                <div class="bk-article-body">
                    {!! $news->body !!}
                </div>

                @if($news->news_source)
                <div class="bk-news-source mt-3">
                    <small class="text-muted"><i class="bi bi-link-45deg me-1"></i>সূত্র: {{ $news->news_source }}</small>
                </div>
                @endif

                {{-- Tags --}}
                @if($news->tags->isNotEmpty())
                <div class="bk-tags mt-4">
                    <i class="bi bi-tags me-2 text-muted"></i>
                    @foreach($news->tags as $tag)
                    <span class="badge bg-light text-dark border me-1">{{ $tag->name }}</span>
                    @endforeach
                </div>
                @endif

                {{-- Social share buttons --}}
                <div class="bk-share-bar mt-4">
                    <span class="me-3 fw-semibold text-muted small">শেয়ার করুন:</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                       target="_blank" class="btn btn-sm bk-share-facebook">
                        <i class="bi bi-facebook me-1"></i>Facebook
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($news->title) }}"
                       target="_blank" class="btn btn-sm bk-share-twitter ms-2">
                        <i class="bi bi-twitter-x me-1"></i>Twitter
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($news->title . ' ' . request()->url()) }}"
                       target="_blank" class="btn btn-sm bk-share-whatsapp ms-2">
                        <i class="bi bi-whatsapp me-1"></i>WhatsApp
                    </a>
                </div>
            </article>

            {{-- Related news --}}
            @if($relatedNews->isNotEmpty())
            <div class="mt-5">
                <h5 class="bk-section-title mb-3">
                    <i class="bi bi-arrow-right-circle me-2"></i>সম্পর্কিত সংবাদ
                </h5>
                <div class="row g-3">
                    @foreach($relatedNews as $related)
                    <div class="col-md-4">
                        <div class="bk-news-card h-100">
                            <a href="{{ route('public.news.show', $related->slug) }}" class="bk-card-img-link">
                                @if($related->image)
                                <img src="{{ Storage::url($related->image) }}" alt="{{ $related->title }}"
                                     class="bk-card-img" loading="lazy">
                                @else
                                <div class="bk-card-img-placeholder"><i class="bi bi-image fs-2 text-muted"></i></div>
                                @endif
                            </a>
                            <div class="bk-card-body">
                                <h6 class="bk-card-title">
                                    <a href="{{ route('public.news.show', $related->slug) }}">
                                        {{ Str::limit($related->title, 80) }}
                                    </a>
                                </h6>
                                <div class="bk-card-meta">
                                    <span><i class="bi bi-clock me-1"></i>{{ $related->published_at?->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">
            @include('public.partials.sidebar')
        </div>
    </div>
</div>
@endsection