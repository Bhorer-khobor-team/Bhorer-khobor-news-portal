@extends('layouts.public')
@section('title', 'শর্তাবলী')

@section('content')
<div class="container-fluid px-3">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="bk-page-header mb-4">
                <h2><i class="bi bi-file-text me-2 text-danger"></i>শর্তাবলী</h2>
            </div>
            <div class="card border-0 shadow-sm">
                <div class="card-body bk-page-content">
                    @if($terms && $terms->content)
                    {!! $terms->content !!}
                    @else
                    <p class="text-muted text-center py-4">শর্তাবলী এখনো আপডেট করা হয়নি।</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection