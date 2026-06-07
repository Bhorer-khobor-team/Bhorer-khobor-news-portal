@extends('layouts.admin')
@section('title', 'সব সংবাদ')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div></div>
    <a href="{{ route('admin.news.create') }}" class="btn btn-danger btn-sm">
        <i class="bi bi-plus-circle me-1"></i>নতুন সংবাদ
    </a>
</div>

{{-- Filters --}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body py-2">
        <form method="GET" action="{{ route('admin.news.index') }}" class="row g-2 align-items-end">
            <div class="col-md-3">
                <input type="text" name="title" class="form-control form-control-sm" placeholder="শিরোনাম খুঁজুন" value="{{ request('title') }}">
            </div>
            <div class="col-md-2">
                <select name="category_id" class="form-select form-select-sm">
                    <option value="">সব বিভাগ</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select form-select-sm">
                    <option value="">সব স্ট্যাটাস</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>প্রকাশিত</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>নিষ্ক্রিয়</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="from_date" class="form-control form-control-sm" value="{{ request('from_date') }}" placeholder="থেকে">
            </div>
            <div class="col-md-2">
                <input type="date" name="to_date" class="form-control form-control-sm" value="{{ request('to_date') }}" placeholder="পর্যন্ত">
            </div>
            <div class="col-md-1 d-flex gap-1">
                <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-funnel"></i></button>
                <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-x"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table bk-table mb-0">
                <thead>
                    <tr>
                        <th width="40">#</th>
                        <th>বিভাগ</th>
                        <th>শিরোনাম</th>
                        <th>ছবি</th>
                        <th>ভিউ</th>
                        <th>রিপোর্টার</th>
                        <th>স্ট্যাটাস</th>
                        <th>তারিখ</th>
                        <th width="100">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($news as $item)
                    <tr>
                        <td class="text-muted small">{{ $news->firstItem() + $loop->index }}</td>
                        <td><span class="badge bg-light text-dark">{{ $item->category->name ?? '—' }}</span></td>
                        <td>
                            <div class="fw-semibold small">{{ Str::limit($item->title, 60) }}</div>
                            @if($item->is_featured)
                            <span class="badge bg-warning text-dark" style="font-size:10px"><i class="bi bi-star-fill"></i> Featured</span>
                            @endif
                        </td>
                        <td>
                            @if($item->image)
                            <img src="{{ Storage::url($item->image) }}" alt="" class="bk-thumb">
                            @else
                            <div class="bk-thumb bk-thumb-placeholder"><i class="bi bi-image text-muted"></i></div>
                            @endif
                        </td>
                        <td class="small">{{ number_format($item->views) }}</td>
                        <td class="small text-muted">{{ $item->admin->name ?? '—' }}</td>
                        <td>
                            @if($item->status === 'published')
                            <span class="badge bg-success">প্রকাশিত</span>
                            @else
                            <span class="badge bg-secondary">নিষ্ক্রিয়</span>
                            @endif
                        </td>
                        <td class="small text-muted">{{ $item->published_at?->format('d M Y') ?? '—' }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.news.destroy', $item) }}" method="POST" onsubmit="return confirmDelete()">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="9" class="text-center text-muted py-4">কোনো সংবাদ পাওয়া যায়নি।</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($news->hasPages())
    <div class="card-footer bg-white">
        {{ $news->links() }}
    </div>
    @endif
</div>
@endsection
