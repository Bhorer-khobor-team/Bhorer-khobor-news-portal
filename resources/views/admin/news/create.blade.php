@extends('layouts.admin')
@section('title', 'নতুন সংবাদ')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css">
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">নতুন সংবাদ লিখুন</h4>
    <a href="{{ route('admin.news.index') }}" class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>ফিরে যান
    </a>
</div>

<form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row g-4">

        {{-- Left Column: Content --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">শিরোনাম <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="titleInput" class="form-control"
                               value="{{ old('title') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">স্লাগ</label>
                        <input type="text" name="slug" id="slugInput" class="form-control"
                               value="{{ old('slug') }}">
                        <div class="form-text">খালি রাখলে শিরোনাম থেকে স্বয়ংক্রিয়ভাবে তৈরি হবে</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">সাব-শিরোনাম</label>
                        <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">বিষয়বস্তু <span class="text-danger">*</span></label>
                        <textarea name="body" id="newsBody" class="form-control">{{ old('body') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Options --}}
        <div class="col-lg-4">

            {{-- Publication --}}
            <div class="card mb-3">
                <div class="card-header fw-semibold">প্রকাশনা</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">বিভাগ <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select" required>
                            <option value="">বিভাগ নির্বাচন করুন</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id')==$cat->id?'selected':'' }}>
                                {{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">স্ট্যাটাস</label>
                        <select name="status" class="form-select">
                            <option value="inactive" {{ old('status','inactive')=='inactive'?'selected':'' }}>নিষ্ক্রিয়</option>
                            <option value="published" {{ old('status')=='published'?'selected':'' }}>প্রকাশিত</option>
                        </select>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="is_featured" value="1" class="form-check-input"
                               id="isFeatured" {{ old('is_featured')?'checked':'' }}>
                        <label class="form-check-label" for="isFeatured">ফিচার্ড সংবাদ (হিরো ক্যারোসেল)</label>
                    </div>
                </div>
            </div>

            {{-- Image --}}
            <div class="card mb-3">
                <div class="card-header fw-semibold">ছবি</div>
                <div class="card-body">
                    <img id="imagePreview" src="" alt="" class="img-fluid rounded mb-2 d-none">
                    <input type="file" name="image" id="imageInput" class="form-control" accept="image/*">
                    <div class="mt-2">
                        <input type="text" name="image_source" class="form-control form-control-sm"
                               placeholder="ছবির উৎস" value="{{ old('image_source') }}">
                    </div>
                </div>
            </div>

            {{-- Extra --}}
            <div class="card mb-3">
                <div class="card-header fw-semibold">অতিরিক্ত তথ্য</div>
                <div class="card-body">
                    <div class="mb-2">
                        <label class="form-label small">ট্যাগসমূহ (কমা দিয়ে আলাদা করুন)</label>
                        <input type="text" name="tags" class="form-control form-control-sm"
                               placeholder="রাজনীতি, অর্থনীতি, ঢাকা" value="{{ old('tags') }}">
                    </div>
                    <div class="mb-2">
                        <label class="form-label small">সংবাদ সূত্র</label>
                        <input type="text" name="news_source" class="form-control form-control-sm"
                               placeholder="বিবিসি, রয়টার্স" value="{{ old('news_source') }}">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-danger w-100">
                <i class="bi bi-save me-1"></i>সংবাদ প্রকাশ করুন
            </button>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js"></script>
<script>
    $('#newsBody').summernote({
        height: 350,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture']],
            ['view', ['fullscreen', 'codeview']],
        ]
    });
</script>
@endpush