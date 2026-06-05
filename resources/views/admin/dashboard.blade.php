@extends('layouts.admin')
@section('title', 'ড্যাশবোর্ড')

@section('content')

{{-- 4 Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="bk-stat-card bk-stat-primary">
            <div class="bk-stat-icon"><i class="bi bi-newspaper"></i></div>
            <div>
                <div class="bk-stat-value">{{ $totalNews }}</div>
                <div class="bk-stat-label">মোট সংবাদ</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="bk-stat-card bk-stat-success">
            <div class="bk-stat-icon"><i class="bi bi-calendar-check"></i></div>
            <div>
                <div class="bk-stat-value">{{ $todayNews }}</div>
                <div class="bk-stat-label">আজকের সংবাদ</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="bk-stat-card bk-stat-warning">
            <div class="bk-stat-icon"><i class="bi bi-pause-circle"></i></div>
            <div>
                <div class="bk-stat-value">{{ $inactiveNews }}</div>
                <div class="bk-stat-label">নিষ্ক্রিয় সংবাদ</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="bk-stat-card bk-stat-info">
            <div class="bk-stat-icon"><i class="bi bi-megaphone"></i></div>
            <div>
                <div class="bk-stat-value">{{ $totalAds }}</div>
                <div class="bk-stat-label">মোট বিজ্ঞাপন</div>
            </div>
        </div>
    </div>
</div>

{{-- Quick Action Buttons --}}
<div class="d-flex flex-wrap gap-2 mb-4">
    <a href="{{ route('admin.news.create') }}" class="btn btn-danger btn-sm">
        <i class="bi bi-plus-circle me-1"></i>নতুন সংবাদ
    </a>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-tag me-1"></i>নতুন বিভাগ
    </a>
    <a href="{{ route('admin.advertisements.create') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-megaphone me-1"></i>নতুন বিজ্ঞাপন
    </a>
    <a href="{{ route('public.home') }}" target="_blank" class="btn btn-outline-primary btn-sm">
        <i class="bi bi-globe me-1"></i>সাইট দেখুন
    </a>
</div>

{{-- Recent News Table --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-semibold"><i class="bi bi-clock-history me-2 text-danger"></i>সাম্প্রতিক সংবাদ</h6>
        <a href="{{ route('admin.news.index') }}" class="btn btn-sm btn-outline-danger">সব দেখুন</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table bk-table mb-0">
                <thead>
                    <tr>
                        <th>ছবি</th><th>শিরোনাম</th><th>বিভাগ</th>
                        <th>স্ট্যাটাস</th><th>তারিখ</th><th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentNews as $item)
                    <tr>
                        <td>
                            @if($item->image)
                            <img src="{{ Storage::url($item->image) }}" alt="" class="bk-thumb">
                            @else
                            <div class="bk-thumb bk-thumb-placeholder"><i class="bi bi-image"></i></div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-semibold small">{{ Str::limit($item->title, 60) }}</div>
                            @if($item->is_featured)
                            <span class="badge bg-warning text-dark" style="font-size:10px">Featured</span>
                            @endif
                        </td>
                        <td><span class="badge bg-light text-dark">{{ $item->category->name ?? '—' }}</span></td>
                        <td>
                            @if($item->status === 'published')
                            <span class="badge bg-success">প্রকাশিত</span>
                            @else
                            <span class="badge bg-secondary">নিষ্ক্রিয়</span>
                            @endif
                        </td>
                        <td class="small text-muted">{{ $item->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection