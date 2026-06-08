@extends('layouts.public')
@section('title', $category->name)

@section('content')
<div class="container-fluid px-3">

    {{-- Category Banner --}}
    <div class="bk-category-banner mb-4">
        <h2 class="mb-1">{{ $category->name }}</h2>
        @if($category->description)
        <p class="mb-0 opacity-75">{{ $category->description }}</p>
        @endif
    </div>

    <div class="row g-4">
        <div class="col-lg-8">

            {{-- Empty state if no news --}}
            @if($news->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-newspaper fs-1 mb-3 d-block"></i>
                <p>এই বিভাগে কোনো সংবাদ পাওয়া যায়নি।</p>
            </div>
            @else

            {{-- News Grid --}}
            <div class="row g-3">
                @foreach($news as $item)
                <div class="col-md-4 col-sm-6">
                    <div class="bk-news-card h-100">
                        <a href="{{ route('public.news.show', $item->slug) }}" class="bk-card-img-link">
                            @if($item->image)
                            <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}"
                                 class="bk-card-img" loading="lazy">
                            @else
                            <div class="bk-card-img-placeholder">
                                <i class="bi bi-image fs-2 text-muted"></i>
                            </div>
                            @endif
                        </a>
                        <div class="bk-card-body">
                            <h6 class="bk-card-title">
                                <a href="{{ route('public.news.show', $item->slug) }}">
                                    {{ Str::limit($item->title, 80) }}
                                </a>
                            </h6>
                            <div class="bk-card-meta">
                                <span><i class="bi bi-clock me-1"></i>{{ $item->published_at?->diffForHumans() }}</span>
                                <span><i class="bi bi-eye me-1"></i>{{ number_format($item->views) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $news->links() }}
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
