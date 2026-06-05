@extends('layouts.admin')
@section('title', 'বিভাগ সম্পাদনা')

@section('content')
<form action="{{ route('admin.categories.update', $category) }}" method="POST">
    @csrf @method('PUT')

    <input type="text" name="name" id="titleInput" class="form-control"
           value="{{ old('name', $category->name) }}" required>

    <input type="text" name="slug" id="slugInput" class="form-control"
           value="{{ old('slug', $category->slug) }}">

    <textarea name="description" class="form-control">{{ old('description', $category->description) }}</textarea>

    <input type="number" name="order" class="form-control"
           value="{{ old('order', $category->order) }}">

    <option value="active" {{ old('status',$category->status)=='active'?'selected':'' }}>সক্রিয়</option>
    <option value="inactive" {{ old('status',$category->status)=='inactive'?'selected':'' }}>নিষ্ক্রিয়</option>

    <button type="submit" class="btn btn-danger">আপডেট করুন</button>
</form>
@endsection