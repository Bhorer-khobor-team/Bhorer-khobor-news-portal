@extends('layouts.admin')
@section('title', 'নতুন বিভাগ')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">নতুন বিভাগ</h4>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>ফিরে যান
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">নাম <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="titleInput" class="form-control"
                               value="{{ old('name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">স্লাগ</label>
                        <input type="text" name="slug" id="slugInput" class="form-control"
                               value="{{ old('slug') }}">
                        <div class="form-text">বাংলা নামের জন্য category-1, category-2 ইত্যাদি ব্যবহার হবে</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">বিবরণ</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">প্রদর্শন ক্রম</label>
                            <input type="number" name="order" class="form-control" value="{{ old('order', 1) }}" min="1">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">স্ট্যাটাস</label>
                            <select name="status" class="form-select">
                                <option value="active" {{ old('status','active')=='active'?'selected':'' }}>সক্রিয়</option>
                                <option value="inactive" {{ old('status')=='inactive'?'selected':'' }}>নিষ্ক্রিয়</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-danger"><i class="bi bi-save me-1"></i>সংরক্ষণ করুন</button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">বাতিল</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection