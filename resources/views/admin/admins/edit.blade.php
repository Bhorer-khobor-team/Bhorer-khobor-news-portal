@extends('layouts.admin')
@section('title', 'অ্যাডমিন সম্পাদনা')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.admins.update', $admin) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-semibold">নাম</label>
                        <input type="text" name="name" class="form-control"
                               value="{{ old('name', $admin->name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">ইমেইল</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $admin->email) }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">ফোন</label>
                        <input type="text" name="phone" class="form-control"
                               value="{{ old('phone', $admin->phone) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">রোল</label>
                        <select name="role" class="form-select" required>
                            @foreach($roles as $role)
                            {{-- Pre-select current role from $currentRole variable --}}
                            <option value="{{ $role->name }}"
                                {{ $currentRole === $role->name ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">নতুন পাসওয়ার্ড (ঐচ্ছিক)</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">খালি রাখলে পাসওয়ার্ড পরিবর্তন হবে না</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">পাসওয়ার্ড নিশ্চিত করুন</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">অ্যাকাউন্ট স্ট্যাটাস</label>
                            <select name="is_active" class="form-select">
                                <option value="1" {{ $admin->is_active?'selected':'' }}>সক্রিয়</option>
                                <option value="0" {{ !$admin->is_active?'selected':'' }}>নিষ্ক্রিয়</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">লক স্ট্যাটাস</label>
                            <select name="is_locked" class="form-select">
                                <option value="0" {{ !$admin->is_locked?'selected':'' }}>আনলক</option>
                                <option value="1" {{ $admin->is_locked?'selected':'' }}>লক করা</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.admins.index') }}" class="btn btn-outline-secondary flex-grow-1">
                            <i class="bi bi-arrow-left me-1"></i>ফিরুন
                        </a>
                        <button type="submit" class="btn btn-danger flex-grow-1">
                            <i class="bi bi-check-circle me-1"></i>আপডেট করুন
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection