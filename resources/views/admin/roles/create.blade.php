@extends('layouts.admin')
@section('title', 'নতুন রোল')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.roles.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label fw-semibold">রোল নাম <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <h6 class="fw-semibold mb-3">অনুমতিসমূহ</h6>

                    {{-- Loop through $permissions — keyed by module name --}}
                    @foreach($permissions as $module => $perms)
                    <div class="card border mb-3">
                        <div class="card-header bg-light py-2">
                            {{-- Select-all checkbox for this module --}}
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input module-toggle"
                                       id="module_{{ $module }}" data-module="{{ $module }}">
                                <label class="form-check-label fw-semibold text-capitalize"
                                       for="module_{{ $module }}">
                                    {{ ucfirst($module) }}
                                </label>
                            </div>
                        </div>
                        <div class="card-body py-2">
                            <div class="row">
                                @foreach($perms as $perm)
                                <div class="col-md-4 col-6">
                                    <div class="form-check">
                                        <input type="checkbox" name="permissions[]" value="{{ $perm->name }}"
                                               class="form-check-input perm-{{ $module }}"
                                               id="perm_{{ $perm->id }}"
                                               {{ in_array($perm->name, old('permissions',[])) ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="perm_{{ $perm->id }}">
                                            {{ $perm->name }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary flex-grow-1">
                            <i class="bi bi-arrow-left me-1"></i>ফিরুন
                        </a>
                        <button type="submit" class="btn btn-danger flex-grow-1">
                            <i class="bi bi-check-circle me-1"></i>রোল তৈরি করুন
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Select-all toggle for each module
document.querySelectorAll('.module-toggle').forEach(function(toggle) {
    toggle.addEventListener('change', function() {
        const module = this.dataset.module;
        document.querySelectorAll('.perm-' + module).forEach(function(cb) {
            cb.checked = toggle.checked;
        });
    });
});
</script>
@endpush