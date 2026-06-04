@extends('layouts.admin')
@section('title', 'সব সংবাদ')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">সব সংবাদ</h4>
    <a href="{{ route('admin.news.create') }}" class="btn btn-danger btn-sm">
        <i class="bi bi-plus-lg me-1"></i>নতুন সংবাদ
    </a>
</div>

{{-- Filter Bar --}}
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('admin.news.index') }}">
            <div class="row g-2 align-items-end">
                <div class="col-md-3">
                    <input type="text" name="title" class="form-control form-control-sm"
                           placeholder="শিরোনাম খুঁজুন..." value="{{ request('title') }}">
                </div>
                <div class="col-md-2">
                    <select name="category_id" class="form-select form-select-sm">
                        <option value="">সব বিভাগ</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id')==$cat->id?'selected':'' }}>
                            {{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">সব স্ট্যাটাস</option>
                        <option value="published" {{ request('status')=='published'?'selected':'' }}>প্রকাশিত</option>
                        <option value="inactive" {{ request('status')=='inactive'?'selected':'' }}>নিষ্ক্রিয়</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="from_date" class="form-control form-control-sm"
                           value="{{ request('from_date') }}">
                </div>
                <div class="col-md-2">
                    <input type="date" name="to_date" class="form-control form-control-sm"
                           value="{{ request('to_date') }}">
                </div>
                <div class="col-md-1 d-flex gap-1">
                    <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-search"></i></button>
                    <a href="{{ route('admin.news.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-x"></i></a>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- News Table --}}
<div class="card">
    <div class="card-body p-0">
        <table class="table bk-table mb-0">
            <thead>
                <tr>
                    <th>#</th><th>ছবি</th><th>শিরোনাম</th><th>বিভাগ</th>
                    <th>ভিউ</th><th>রিপোর্টার</th><th>স্ট্যাটাস</th>
                    <th>তারিখ</th><th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($news as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if($item->image)
                        <img src="{{ Storage::url($item->image) }}" class="bk-thumb" alt="">
                        @else
                        <div class="bk-thumb-placeholder"><i class="bi bi-image text-muted"></i></div>
                        @endif
                    </td>
                    <td>
                        <div class="fw-semibold" style="max-width:260px">{{ Str::limit($item->title, 60) }}</div>
                        @if($item->is_featured)<span class="badge bg-warning text-dark ms-1" style="font-size:10px">Featured</span>@endif
                    </td>
                    <td><span class="badge bg-secondary">{{ $item->category->name ?? '—' }}</span></td>
                    <td>{{ number_format($item->views) }}</td>
                    <td>{{ $item->admin->name ?? '—' }}</td>
                    <td>
                        @if($item->status === 'published')
                        <span class="badge bg-success">প্রকাশিত</span>
                        @else
                        <span class="badge bg-secondary">নিষ্ক্রিয়</span>
                        @endif
                    </td>
                    <td class="text-muted" style="font-size:12px">
                        {{ $item->published_at?->format('d M Y') ?? '—' }}
                    </td>
                    <td>
                        <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.news.destroy', $item) }}" method="POST" class="d-inline"
                              onsubmit="return confirmDelete()">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center text-muted py-4">কোনো সংবাদ পাওয়া যায়নি</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $news->links() }}</div>
</div>
@endsection