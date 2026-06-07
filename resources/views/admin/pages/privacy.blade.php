@extends('layouts.admin')
@section('title', 'গোপনীয়তা নীতি')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css">
@endpush

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.privacy.update') }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-semibold">বিষয়বস্তু</label>
                <textarea name="content" id="pageContent"
                          class="form-control @error('content') is-invalid @enderror">
{{ old('content', $policy->content) }}</textarea>
                @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-check-circle me-1"></i>আপডেট করুন
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js"></script>
<script>$('#pageContent').summernote({ height: 400 });</script>
@endpush
