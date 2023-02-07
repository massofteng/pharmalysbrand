@extends('frontend.layouts.app')
@section('head')
<x-meta current-page-id="home" />
@endsection
@section('content')
<div class="v-m-stories container-fluid pb-60 pt-160">
    <div class="row align-items-center">
        <div class="col-md-7">
            <h3 class="v-heading color-blue ps-xl-5 ">Stories</h3>
        </div>
        <div class="col-md-5 position-relative d-none d-md-block">
            <a href="#link" class=" v-link-after text-black vf-600">Show all stories</a>
        </div>
    </div>
</div>
<div class="container pb-70">
    @if($stories)
    @foreach($stories as $story)
        <a href="#link" class="v-stories">
            <div class="row mb-5 align-items-center">
                <div class="col-md-5">
                    <div class="v-stories-img">
                        <div class="v-stories-img-slide">
                            <img src="{{ asset('storage/'.$story->image)}}" alt="Stories">
                        </div>
                    </div>
                </div>
                <div class="col-md-7 pt-lg-3">
                    <h3 class="v-title text-black ps-220">
                        {{ $story->title }}
                    </p></h3>
                    <h6 class="text-black ps-220"><b>Category</b>  {{ $story->category->name }}</h6>
                </div>
            </div>
        </a>
    @endforeach
    @endif
    <div class="row align-items-center v-m-show-all-stories">
        <div class="col-md-12 position-relative d-block d-md-none">
            <a href="#link" class=" v-link-after text-black vf-600">Show all stories</a>
        </div>
    </div>
</div>
@endsection