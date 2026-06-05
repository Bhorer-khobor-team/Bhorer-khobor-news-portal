@extends('layouts.admin')
@section('title', 'বিভাগসমূহ')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">বিভাগসমূহ</h4>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-danger btn-sm">
        <i class="bi bi-plus-lg me-1"></i>নতুন বিভাগ
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table bk-table mb-0">
            <thead>
                <tr><th>#</th><th>নাম</th><th>স্লাগ</th><th>ক্রম</th><th>স্ট্যাটাস</th><th>Action</th></tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="fw-semibold">{{ $cat->name }}</td>
                    <td class="text-muted font-monospace" style="font-size:12px">{{ $cat->slug }}</td>
                    <td>{{ $cat->order }}</td>
                    <td>
                        @if($cat->status === 'active')
                        <span class="badge bg-success">সক্রিয়</span>
                        @else
                        <span class="badge bg-secondary">নিষ্ক্রিয়</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.categories.edit', $cat) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" class="d-inline"
                              onsubmit="return confirmDelete()">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">কোনো বিভাগ নেই</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection