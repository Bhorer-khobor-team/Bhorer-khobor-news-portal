@extends('layouts.admin')
@section('title', 'নতুন বিজ্ঞাপন')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.advertisements.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">শিরোনাম <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title') }}" required>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">স্থান <span class="text-danger">*</span></label>
                            {{-- Loop through positions() — store KEY ('home_top'), display LABEL ('Home Top') --}}
                            <select name="position" class="form-select" required>
                                <option value="">নির্বাচন করুন</option>
                                @foreach($positions as $key => $label)
                                <option value="{{ $key }}" {{ old('position') === $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">রিডাইরেক্ট লিংক <span class="text-danger">*</span></label>
                            <input type="url" name="link" class="form-control"
                                   value="{{ old('link') }}" placeholder="https://" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">বিজ্ঞাপনদাতার নাম</label>
                            <input type="text" name="advertiser_name" class="form-control"
                                   value="{{ old('advertiser_name') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">যোগাযোগ</label>
                            <input type="text" name="advertiser_contact" class="form-control"
                                   value="{{ old('advertiser_contact') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">স্ট্যাটাস</label>
                            <select name="is_active" class="form-select">
                                <option value="1" {{ old('is_active','1')==='1'?'selected':'' }}>সক্রিয়</option>
                                <option value="0" {{ old('is_active')==='0'?'selected':'' }}>নিষ্ক্রিয়</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">শুরুর তারিখ</label>
                            <input type="date" name="starts_at" class="form-control" value="{{ old('starts_at') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">শেষের তারিখ</label>
                            <input type="date" name="ends_at" class="form-control" value="{{ old('ends_at') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">ছবি <span class="text-danger">*</span></label>
                            <input type="file" name="image" id="imageInput" class="form-control" accept="image/*" required>
                            <img id="imagePreview" src="" alt="" class="img-fluid rounded d-none mt-2" style="max-height:150px">
                        </div>
                        <div class="col-12 d-flex gap-2">
                            <a href="{{ route('admin.advertisements.index') }}" class="btn btn-outline-secondary flex-grow-1">
                                <i class="bi bi-arrow-left me-1"></i>ফিরুন
                            </a>
                            <button type="submit" class="btn btn-danger flex-grow-1">
                                <i class="bi bi-check-circle me-1"></i>বিজ্ঞাপন যোগ করুন
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection