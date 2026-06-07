@extends('layouts.admin')
@section('title', 'রোল ও অনুমতি')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">রোল ও অনুমতি</h4>
    <a href="{{ route('admin.roles.create') }}" class="btn btn-danger btn-sm">
        <i class="bi bi-plus-circle me-1"></i>নতুন রোল
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table bk-table mb-0">
                <thead>
                    <tr>
                        <th>#</th><th>রোল নাম</th><th>অনুমতিসমূহ</th><th>অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                    <tr>
                        <td class="text-muted">{{ $loop->iteration }}</td>
                        <td class="fw-semibold">{{ $role->name }}</td>
                        <td>
                            @forelse($role->permissions as $perm)
                            <span class="badge bg-light text-dark me-1 mb-1" style="font-size:11px">
                                {{ $perm->name }}
                            </span>
                            @empty
                            <span class="text-muted small">কোনো অনুমতি নেই</span>
                            @endforelse
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.roles.edit', $role) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.roles.destroy', $role) }}"
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
                    <tr><td colspan="4" class="text-center text-muted py-4">কোনো রোল নেই।</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection