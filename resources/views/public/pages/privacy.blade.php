@extends('layouts.public')
@section('title', 'গোপনীয়তা নীতি')

@section('content')
<div class="container-fluid px-3">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="bk-page-header mb-4">
                <h2><i class="bi bi-shield-check me-2 text-danger"></i>গোপনীয়তা নীতি</h2>
            </div>
            <div class="card border-0 shadow-sm">
                <div class="card-body bk-page-content">
                    @if($policy && $policy->content)
                    {{-- Render HTML from Summernote unescaped --}}
                    {!! $policy->content !!}
                    @else
                    <p class="text-muted text-center py-4">গোপনীয়তা নীতি এখনো আপডেট করা হয়নি।</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
