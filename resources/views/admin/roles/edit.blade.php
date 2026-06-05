@extends('layouts.admin')
@section('title', 'রোল সম্পাদনা')

@section('content')
<form action="{{ route('admin.roles.update', $role) }}" method="POST">
    @csrf @method('PUT')

    {{-- Pre-filled role name --}}
    <input type="text" name="name" class="form-control"
           value="{{ old('name', $role->name) }}" required>

    {{-- Pre-checked permissions using $rolePermissions array --}}
    @foreach($permissions as $module => $perms)
        @foreach($perms as $perm)
        <input type="checkbox" name="permissions[]" value="{{ $perm->name }}"
               class="form-check-input perm-{{ $module }}"
               {{-- Check if permission is in $rolePermissions array --}}
               {{ in_array($perm->name, old('permissions', $rolePermissions)) ? 'checked' : '' }}>
        @endforeach
    @endforeach

    <button type="submit" class="btn btn-danger">আপডেট করুন</button>
</form>

{{-- Same module-toggle JavaScript as create view --}}
@push('scripts')
<script>
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
