@extends('layouts.app')
@section('content')
<div class="about-page">
    <div class="container">
        <div class="vertical-space-100"></div>
        <h2 class="heading text-center">About <span class="common">Us</span></h2>
        <div class="about-content">
            <p>
                {!! $about->about_content !!}
            </p>
            <div class="vertical-space-60"></div>
        </div>
    </div>
</div>
@endsection 