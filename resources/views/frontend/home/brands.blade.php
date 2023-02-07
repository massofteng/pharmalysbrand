@extends('frontend.layouts.app')
@section('head')
<x-meta current-page-id="home" />
@endsection
@section('content')
@php
    //$brands = \App\Pharmalys\BlockQuery::init('home')->typeOf('brand-section');
@endphp
<div class="bg-blue-shade pb-160 pt-70">
    <div class="container-fluid pb-70">
        <div class="row align-items-center">
            <div class="col-md-7">
                <h3 class="v-heading color-blue">{{__('brand.title')}}</h3>
            </div>
            <div class="col-md-5 position-relative d-none d-md-block">
                <a href="#link" class="v-link-after text-black vf-600">Visit the brands page</a>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row v-nav v-brand-slider">
            @foreach ($brands as $brand)
            <div class="col-md-4 ">
                <div class=" box-section ">
                    <div class="box-section-img">
                        <img src="{{ asset('storage/'.$brand->logo)}}" alt="{{ $brand->title }}">
                    </div>
                    <h5 class="v-box-title color-blue color-blue vf-600">{{ $brand->title }}</h5>
                    <p class="color-black-shade v-body">{{ $brand->description }}</p>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row align-items-center v-m-show-all-stories">
            <div class="col-md-12 position-relative d-block d-md-none">
                <a href="#link" class=" v-link-after text-black vf-600">Visit the brands page</a>
            </div>
        </div>
    </div>
</div>
@endsection