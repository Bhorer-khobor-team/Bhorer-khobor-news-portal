@extends('layouts.public')
@section('title', $query ? '"' . $query . '" - অনুসন্ধান' : 'অনুসন্ধান')

@section('content')
<div class="container-fluid px-3">

    {{-- Search Hero --}}
    <div class="bk-search-hero mb-4">
        <h2 class="mb-3 text-white">সংবাদ অনুসন্ধান</h2>
        <form action="{{ route('public.search') }}" method="GET">
            <div class="input-group bk-search-hero-bar">
                <input type="text" name="q" class="form-control form-control-lg"
                       placeholder="কীওয়ার্ড দিয়ে সংবাদ খুঁজুন..." value="{{ $query }}" autofocus>
                <button class="btn btn-danger btn-lg px-4" type="submit">
                    <i class="bi bi-search me-1"></i>খুঁজুন
                </button>
            </div>
        </form>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            @if($query)
            <div class="mb-3">
                <p class="text-muted">
                    "<strong>{{ $query }}</strong>" এর জন্য
                    @if($results instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    {{ $results->total() }} টি ফলাফল পাওয়া গেছে
                    @endif
                </p>
            </div>

            @if($results instanceof \Illuminate\Support\Collection ? $results->isEmpty() : ($results instanceof \Illuminate\Pagination\LengthAwarePaginator && $results->isEmpty()))
            <div class="bk-no-results text-center py-5">
                <i class="bi bi-search fs-1 text-muted mb-3 d-block"></i>
                <h5>কোনো ফলাফল পাওয়া যায়নি</h5>
                <p class="text-muted">ভিন্ন কীওয়ার্ড দিয়ে আবার চেষ্টা করুন।</p>
            </div>
            @else
            <div class="d-flex flex-column gap-3">
                @foreach($results as $item)
                <div class="bk-search-result-card">
                    @if($item->image)
                    <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}" class="bk-search-thumb" loading="lazy">
                    @else
                    <div class="bk-search-thumb bk-thumb-placeholder"><i class="bi bi-image text-muted"></i></div>
                    @endif
                    <div class="flex-grow-1">
                        <span class="badge bg-danger mb-1">{{ $item->category->name }}</span>
                        <h6 class="bk-search-title">
                            <a href="{{ route('public.news.show', $item->slug) }}">
                                {!! preg_replace('/(' . preg_quote($query, '/') . ')/iu', '<mark>$1</mark>', e($item->title)) !!}
                            </a>
                        </h6>
                        <p class="text-muted small mb-1">
                            {!! Str::limit(preg_replace('/(' . preg_quote($query, '/') . ')/iu', '<mark>$1</mark>', e(strip_tags($item->body))), 200) !!}
                        </p>
                        <div class="bk-card-meta">
                            <span><i class="bi bi-clock me-1"></i>{{ $item->published_at?->diffForHumans() }}</span>
                            <span class="ms-3"><i class="bi bi-eye me-1"></i>{{ number_format($item->views) }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-4">
                {{ $results->links() }}
            </div>
            @endif
            @else
            <div class="text-center py-5 text-muted">
                <i class="bi bi-search fs-1 mb-3 d-block"></i>
                <p>অনুসন্ধানের জন্য একটি কীওয়ার্ড লিখুন।</p>
            </div>
            @endif
        </div>

        <div class="col-lg-4">
            @include('public.partials.sidebar')
        </div>
    </div>
</div>
@endsection
