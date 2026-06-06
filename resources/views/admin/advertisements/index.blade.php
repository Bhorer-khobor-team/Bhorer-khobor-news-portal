@extends('layouts.admin')
@section('title', 'বিজ্ঞাপন')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">বিজ্ঞাপন</h4>
    <a href="{{ route('admin.advertisements.create') }}" class="btn btn-danger btn-sm">
        <i class="bi bi-plus-circle me-1"></i>নতুন বিজ্ঞাপন
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table bk-table mb-0">
                <thead>
                    <tr>
                        <th>#</th><th>শিরোনাম</th><th>ছবি</th>
                        <th>স্থান</th><th>তারিখ পরিসর</th>
                        <th>স্ট্যাটাস</th><th>যোগ করা হয়েছে</th><th>অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($advertisements as $ad)
                    <tr>
                        <td class="text-muted small">{{ $advertisements->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="fw-semibold small">{{ $ad->title }}</div>
                            @if($ad->advertiser_name)
                            <div class="text-muted" style="font-size:11px">{{ $ad->advertiser_name }}</div>
                            @endif
                        </td>
                        <td>
                            <img src="{{ Storage::url($ad->image) }}" alt="" class="bk-thumb">
                        </td>
                        {{-- Display label from positions() using key stored in DB --}}
                        <td>
                            <span class="badge bg-light text-dark">
                                {{ \App\Models\Advertisement::positions()[$ad->position] ?? $ad->position }}
                            </span>
                        </td>
                        <td class="small text-muted">
                            {{ $ad->starts_at?->format('d M Y') ?? '—' }}
                            @if($ad->ends_at) → {{ $ad->ends_at->format('d M Y') }} @endif
                        </td>
                        <td>
                            @if($ad->is_active)
                            <span class="badge bg-success">সক্রিয়</span>
                            @else
                            <span class="badge bg-secondary">নিষ্ক্রিয়</span>
                            @endif
                        </td>
                        <td class="small text-muted">{{ $ad->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.advertisements.edit', $ad) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.advertisements.destroy', $ad) }}"
                                      method="POST" onsubmit="return confirmDelete()">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">কোনো বিজ্ঞাপন নেই।</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($advertisements->hasPages())
    <div class="card-footer">{{ $advertisements->links() }}</div>
    @endif
</div>
@endsection