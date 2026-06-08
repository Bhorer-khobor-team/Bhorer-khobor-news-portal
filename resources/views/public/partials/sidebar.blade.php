{{-- Sidebar Ad (sidebar_top position from ViewServiceProvider) --}}
@if(isset($sidebarAd) && $sidebarAd)
<div class="bk-ad-block mb-4 text-center">
    <a href="{{ $sidebarAd->link }}" target="_blank" rel="nofollow">
        <img src="{{ Storage::url($sidebarAd->image) }}"
             alt="{{ $sidebarAd->title }}" class="img-fluid rounded">
    </a>
</div>
@endif

{{-- Latest News Widget --}}
<div class="bk-widget mb-4">
    <div class="bk-widget-title">
        <i class="bi bi-clock me-2"></i>সর্বশেষ সংবাদ
    </div>
    <div class="bk-widget-body">
        @foreach($sidebarNews as $item)
        <div class="bk-sidebar-news-item">
            @if($item->image)
            <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}"
                 class="bk-sidebar-thumb" loading="lazy">
            @else
            <div class="bk-sidebar-thumb bk-thumb-placeholder"><i class="bi bi-image"></i></div>
            @endif
            <div>
                <a href="{{ route('public.news.show', $item->slug) }}" class="bk-sidebar-news-link">
                    {{ Str::limit($item->title, 70) }}
                </a>
                <div class="bk-meta-small">
                    <i class="bi bi-clock me-1"></i>{{ $item->published_at?->diffForHumans() ?? '' }}
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- Categories Widget --}}
<div class="bk-widget mb-4">
    <div class="bk-widget-title">
        <i class="bi bi-tags me-2"></i>বিভাগসমূহ
    </div>
    <div class="bk-widget-body p-0">
        @foreach($navCategories as $cat)
        <a href="{{ route('public.category.show', $cat->slug) }}" class="bk-cat-widget-item">
            <span>{{ $cat->name }}</span>
            <span class="badge bg-danger rounded-pill">{{ $cat->news_count }}</span>
        </a>
        @endforeach
    </div>
</div>
