@extends('layouts.admin')
@section('title', 'বিজ্ঞাপন সম্পাদনা')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.advertisements.update', $advertisement) }}"
                      method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">শিরোনাম</label>
                            <input type="text" name="title" class="form-control"
                                   value="{{ old('title', $advertisement->title) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">স্থান</label>
                            <select name="position" class="form-select" required>
                                @foreach($positions as $key => $label)
                                <option value="{{ $key }}"
                                    {{ old('position', $advertisement->position) === $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">রিডাইরেক্ট লিংক</label>
                            <input type="url" name="link" class="form-control"
                                   value="{{ old('link', $advertisement->link) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">বিজ্ঞাপনদাতার নাম</label>
                            <input type="text" name="advertiser_name" class="form-control"
                                   value="{{ old('advertiser_name', $advertisement->advertiser_name) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">যোগাযোগ</label>
                            <input type="text" name="advertiser_contact" class="form-control"
                                   value="{{ old('advertiser_contact', $advertisement->advertiser_contact) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">স্ট্যাটাস</label>
                            <select name="is_active" class="form-select">
                                <option value="1" {{ old('is_active', $advertisement->is_active?'1':'0')==='1'?'selected':'' }}>সক্রিয়</option>
                                <option value="0" {{ old('is_active', $advertisement->is_active?'1':'0')==='0'?'selected':'' }}>নিষ্ক্রিয়</option>
                            </select>
                        </div>
                        {{-- Date inputs MUST use Y-m-d format for HTML date input --}}
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">শুরুর তারিখ</label>
                            <input type="date" name="starts_at" class="form-control"
                                   value="{{ old('starts_at', $advertisement->starts_at?->format('Y-m-d')) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">শেষের তারিখ</label>
                            <input type="date" name="ends_at" class="form-control"
                                   value="{{ old('ends_at', $advertisement->ends_at?->format('Y-m-d')) }}">
                        </div>
                        <div class="col-12">
                            {{-- Show current image --}}
                            <label class="form-label fw-semibold">বর্তমান ছবি</label>
                            <div>
                                <img src="{{ Storage::url($advertisement->image) }}" alt=""
                                     class="img-fluid rounded mb-2" style="max-height:120px">
                            </div>
                            <label class="form-label fw-semibold">নতুন ছবি (ঐচ্ছিক)</label>
                            <input type="file" name="image" id="imageInput" class="form-control" accept="image/*">
                            <img id="imagePreview" src="" alt="" class="img-fluid rounded d-none mt-2" style="max-height:150px">
                        </div>
                        <div class="col-12 d-flex gap-2">
                            <a href="{{ route('admin.advertisements.index') }}" class="btn btn-outline-secondary flex-grow-1">
                                <i class="bi bi-arrow-left me-1"></i>ফিরুন
                            </a>
                            <button type="submit" class="btn btn-danger flex-grow-1">
                                <i class="bi bi-check-circle me-1"></i>আপডেট করুন
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
