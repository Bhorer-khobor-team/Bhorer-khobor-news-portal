@extends('layouts.admin')
@section('title', 'সংবাদ সম্পাদনা')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css">
@endpush

@section('content')
<form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- Title --}}
    <input type="text" name="title" id="titleInput" class="form-control"
           value="{{ old('title', $news->title) }}" required>

    {{-- Slug --}}
    <input type="text" name="slug" id="slugInput" class="form-control"
           value="{{ old('slug', $news->slug) }}">

    {{-- Subtitle --}}
    <input type="text" name="subtitle" class="form-control"
           value="{{ old('subtitle', $news->subtitle) }}">

    {{-- Body (Summernote reads from textarea value) --}}
    <textarea name="body" id="newsBody">{{ old('body', $news->body) }}</textarea>

    {{-- Category --}}
    @foreach($categories as $cat)
    <option value="{{ $cat->id }}"
        {{ old('category_id', $news->category_id) == $cat->id ? 'selected' : '' }}>
        {{ $cat->name }}</option>
    @endforeach

    {{-- Status --}}
    <option value="inactive" {{ old('status',$news->status)=='inactive'?'selected':'' }}>নিষ্ক্রিয়</option>
    <option value="published" {{ old('status',$news->status)=='published'?'selected':'' }}>প্রকাশিত</option>

    {{-- is_featured --}}
    <input type="checkbox" name="is_featured" value="1"
           {{ old('is_featured', $news->is_featured) ? 'checked' : '' }}>

    {{-- Current image --}}
    @if($news->image)
    <img src="{{ Storage::url($news->image) }}" class="img-fluid rounded mb-2" style="max-height:120px">
    @endif
    <input type="file" name="image" id="imageInput" class="form-control" accept="image/*">

    {{-- Tags (pre-filled from $tagString) --}}
    <input type="text" name="tags" class="form-control form-control-sm"
           value="{{ old('tags', $tagString) }}">

    <button type="submit" class="btn btn-danger w-100">আপডেট করুন</button>
</form>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js"></script>
<script>$('#newsBody').summernote({ height: 350 });</script>
@endpush