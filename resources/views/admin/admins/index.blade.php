@extends('layouts.admin')
@section('title', 'অ্যাডমিন ব্যবস্থাপনা')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">অ্যাডমিন ব্যবস্থাপনা</h4>
    <a href="{{ route('admin.admins.create') }}" class="btn btn-danger btn-sm">
        <i class="bi bi-plus-circle me-1"></i>নতুন অ্যাডমিন
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table bk-table mb-0">
                <thead>
                    <tr>
                        <th>#</th><th>নাম</th><th>ফোন</th><th>ইমেইল</th>
                        <th>রোল</th><th>স্ট্যাটাস</th><th>অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($admins as $admin)
                    <tr>
                        <td class="text-muted small">{{ $admins->firstItem() + $loop->index }}</td>
                        <td class="fw-semibold">{{ $admin->name }}</td>
                        <td class="text-muted small">{{ $admin->phone ?? '—' }}</td>
                        <td class="small">{{ $admin->email }}</td>
                        <td>
                            @foreach($admin->roles as $role)
                            <span class="badge bg-primary">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            {{-- 3-way status logic --}}
                            @if($admin->is_active && !$admin->is_locked)
                            <span class="badge bg-success">সক্রিয়</span>
                            @elseif($admin->is_locked)
                            <span class="badge bg-danger">লক করা</span>
                            @else
                            <span class="badge bg-secondary">নিষ্ক্রিয়</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.admins.edit', $admin) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.admins.destroy', $admin) }}"
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
                    <tr><td colspan="7" class="text-center text-muted py-4">কোনো অ্যাডমিন নেই।</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($admins->hasPages())
    <div class="card-footer">{{ $admins->links() }}</div>
    @endif
</div>
@endsection