@extends('frontend.layouts.app')
@section('head')
<x-meta current-page-id="home" />
@endsection
@section('content')
<div class="v-full-width quality-m pb-240 pt-150">
    <div class="container ">
        @if($partners)
        <?php
        //dd($partners);
        ?>
        @foreach ($partners as $partner)
            <div class="row align-items-top">
                <div class="col-md-5 pt-210">
                    <img class="v-img-left" src="{{ asset('storage/'.$partner->image_one)}}" alt="{{ $partner->title }}">
                </div>
                <div class="col-md-7">
                    <h3 class="ps-lg-5 ps-3 pb-70 v-heading color-blue mw-575">
                        {{ $partner->title }}
                    </h3>
                    <div class="mw-480  ms-190  pb-135 pt-2">
                        <p class="v-details color-blue mb-4">{{ $partner->description }}</p>
                        <a class="v-link" href="{{ $partner->link }}">
                            <span class="v-circle"><span class="arrow v-arrow "></span></span>
                            Learn More
                        </a>
                    </div>
                    <div class="text-end">
                        <img class="v-img-right" src="{{ asset('storage/'.$partner->image_two)}}" alt="{{ $partner->title }}">
                    </div>
                </div>
            </div>
        @endforeach
        @endif
    </div>
</div>
@endsection