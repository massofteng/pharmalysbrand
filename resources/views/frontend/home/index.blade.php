@extends('frontend.layouts.app')
@section('head')
<x-meta current-page-id="home" />
@endsection
@section('content')
<div class="v-app">
    <!--video player-->
    <?php
    $video = 'dummy.mp4';
    if($slider_content){
        $video = $slider_content->video;
    }

    ?>
    <div class="video-player" id="video-player">
        <video width="100%" id="video_banner" autoplay muted loop
               style="right: 0; top: 0; min-width:100%;object-fit: cover;z-index: 999999">
            <source src="{{ asset('storage/'. $video)}}" type="video/mp4">
            <source src="{{ asset('storage/'. $video)}}" type="video/ogg">
        </video>
        <div class="banner-overlay-text d-flex align-items-center align-content-between">
            <div class="play-btn play-desktop">
                <a data-bs-toggle="modal" href="#videoModal" role="button"
                   onclick="videoPlay()">
                    <img src="assets/img/play.svg" alt="Play">
                </a>
                <!--                <a href="#link"-->
                <!--                   onclick="openFullscreen()">-->
                <!--                    <img src="assets/img/play.svg" alt="Play">-->
                <!--                </a>-->
            </div>
            <h2>
                @if($slider_content)
                    {{ $slider_content->title}}
               @endif
            </h2>
        </div>
        <div class="play-btn play-mobile">
            <a data-bs-toggle="modal" href="#videoModal" role="button"
               onclick="videoPlay()">
                <img src="assets/img/play.svg" alt="Play">
            </a>
            <!--                <a href="#link"-->
            <!--                   onclick="openFullscreen()">-->
            <!--                    <img src="assets/img/play.svg" alt="Play">-->
            <!--                </a>-->
        </div>
    </div>
    <div class="modal fade" id="videoModal" aria-hidden="true" aria-labelledby="videoModalLabel"
         tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <button class="close-option bg-transparent" data-bs-dismiss="modal" aria-label="Close"
                        onclick="videoMuted()">
                    <img src="assets/img/close.png" alt="Close">
                </button>
                <!--<button class="btn btn-danger close-option" onclick="exitvFullscreen();">Close Option</button>-->
                <div>
                    <video style="position: absolute; right: 0; top: 0; min-width:100%;object-fit: cover;z-index: 999999"
                           width="100%" height="100%" id="video_modal" autoplay muted loop controls>
                        <source src="{{ asset('storage/'. $video)}}" type="video/mp4">
                        <source src="{{ asset('storage/'. $video)}}" type="video/ogg">
                    </video>
                </div>
            </div>
        </div>
    </div>
    <!--video player-->
    <!--banner bottom-->
    <div class="container v-b-m">
        <div class="row pt-160 pb-160">
            <div class="col-lg-8 offset-lg-4 col-md-12">
                <h3 class="v-sub-heading color-blue mw-720 ms-lg-5" data-aos="fade-up" data-aos-duration="2000">
                    @if(isset($slider_content->description))
                    {{ $slider_content->description}}
                    @endif
                </h3>
            </div>
        </div>
    </div>
    <!--banner bottom-->
    <!--image left fullwidth section-->
    @if($anonymous_post_one)
    <div class="v-full-width v-b-m">
        <div class="d-block d-md-none" data-aos="fade-up" data-aos-duration="2000">
            <img class="v-img-left" src="{{ asset('storage/'.$anonymous_post_one->image)}}" alt="Work">
        </div>
        <div class="container ">
            <div class="row align-items-center">
                <div class="col-md-5  d-none d-md-block d-lg-block d-xl-block" data-aos="fade-up" data-aos-duration="3000">
                    <img class="v-img-left" src="{{ asset('storage/'.$anonymous_post_one->image)}}" alt="Work">
                </div>
                <div class="col-md-7" data-aos="fade-up" data-aos-duration="2000">
                    <div class="mw-480 ms-80 mb-4" >
                        <h1 class="v-heading color-blue">{{ $anonymous_post_one->title }}</h1>
                    </div>
                    <div class="mw-480 pb-160 ms-160">
                        <p class="v-details color-blue mb-4">
                            {{ $anonymous_post_one->description }}
                        </p>
                        <a class="v-link" href="#link">
                            <span class="v-circle"><span class="arrow v-arrow "></span></span>
                            Learn More
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--image left fullwidth section-->
    <!--stories section-->
    <div class="v-m-stories container-fluid pb-60 pt-160" data-aos="fade-up" data-aos-duration="2000">
        <div class="row align-items-center">
            <div class="col-md-7">
                <h3 class="v-heading color-blue ps-xl-5 ">{{__('home.stories')}}</h3>
            </div>
            <div class="col-md-5 position-relative d-none d-md-block">
                <a href="#link" class=" v-link-after text-black vf-600">Show all stories</a>
            </div>
        </div>
    </div>
    @endif
    <div class="container pb-70" data-aos="fade-up" data-aos-duration="2000">
        @if($stories)
        @php $data_aos = 1000; @endphp
            @foreach($stories as $story)
                <?php
                if($story){
                    $story_content = json_decode($story->block_content);
                ?>
                <a href="#link" class="v-stories" data-aos="fade-up" data-aos-duration="2000">
                    <div class="row mb-5 align-items-center">
                        <div class="col-md-5">
                            <div class="v-stories-img">
                                <div class="v-stories-img-slide">
                                    <img src="{{ asset('storage/'.$story_content->content[0]->logo )}}" alt="Stories">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 pt-lg-3">
                            <h3 class="v-title text-black ps-220">{{ $story_content->content[0]->title }}</h3>
                            <h6 class="text-black ps-220"><b>Category: </b>{{ $story->category->name }}</h6>
                        </div>
                    </div>
                </a>
                <?php } ?>
                @endforeach
            @endif
        <div class="row align-items-center v-m-show-all-stories">
            <div class="col-md-12 position-relative d-block d-md-none">
                <a href="#link" class=" v-link-after text-black vf-600">Show all stories</a>
            </div>
        </div>
    </div>
    <!--stories section-->
    <!--facts section-->
    <div class=" bg-blue pt-90 pb-70">
        <div class="container-fluid pb-70" data-aos="fade-right" data-aos-duration="2000">
            <div class="row">
                <div class="col-12">
                    <h3 class="v-heading text-white ps-lg-3">{{ __('home.facts')}}</h3>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row v-nav facts-slider-active">
                @if($facts)
                    @php $data_aos = 1000; @endphp
                    @foreach($facts as $fact)
                        <?php 
                        if($fact){
                            $fact_content = json_decode($fact->block_content);
                        ?>
                        <div class="col-md-6" data-aos="fade-right" data-aos-duration="{{ $data_aos=+1000 }}">
                            <div class="v-count-box">
                                <h6>{{ $fact_content->content[0]->title }}</h6>
                                <h3>{{ $fact_content->content[0]->count }}</h3>
                                <p class="text-white v-body">{{ $fact_content->content[0]->details }}</p>
                            </div>
                        </div>
                        <?php } ?>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <!--facts section-->
    <!--brand section start-->
    <div class="bg-blue-shade pb-160 pt-70">
        <div class="container-fluid pb-70">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <h3 class="v-heading color-blue">{{ __('home.brands')}}</h3>
                </div>
                <div class="col-md-5 position-relative d-none d-md-block">
                    <a href="#link" class="v-link-after text-black vf-600">Visit the brands page</a>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row v-nav v-brand-slider">
                @if($brands)
                    @foreach($brands as $brand)
                        <?php 
                        if($brand){
                            $brand_con = json_decode($brand->block_content);
                            $brand_content = $brand_con->content;
                        ?>
                        <div class="col-md-4 ">
                            <div class=" box-section ">
                                <div class="box-section-img">
                                    <img src="{{ asset('storage/'.$brand_content[0]->logo)}}" alt="Brands">
                                </div>
                                <h5 class="v-box-title color-blue color-blue vf-600">{{ $brand_content[0]->title}}</h5>
                                <p class="color-black-shade v-body">{{ $brand_content[0]->description}}</p>
                            </div>
                        </div>
                <?php } ?>
                @endforeach
                @endif 
            </div>
            <div class="row align-items-center v-m-show-all-stories">
                <div class="col-md-12 position-relative d-block d-md-none">
                    <a href="#link" class=" v-link-after text-black vf-600">Visit the brands page</a>
                </div>
            </div>
        </div>
    </div>
    <!--brand section end-->
    @if($anonymous_post_two)
    <div class="v-full-width quality-m pb-240 pt-150">
        <div class="container " >
            <div class="row align-items-top">
                <div class="col-md-5 pt-210" data-aos="fade-up" data-aos-duration="2000">
                    <img class="v-img-left" src="{{ asset('storage/'.$anonymous_post_two->image )}}" alt="Quality">
                </div>
                <div class="col-md-7" data-aos="fade-up" data-aos-duration="2000">
                    <h3 class="ps-lg-5 ps-3 pb-70 v-heading color-blue mw-575">
                      {{ $anonymous_post_two->title }}
                    </h3>

                    <div class="mw-480  ms-190  pb-135 pt-2" data-aos="fade-up" data-aos-duration="2000">
                        <p class="v-details color-blue mb-4">
                            {{ $anonymous_post_two->description }}
                        </p>
                        <a class="v-link" href="#link">
                            <span class="v-circle"><span class="arrow v-arrow "></span></span>
                            Learn More
                        </a>
                    </div>
                    <div class="text-end" data-aos="fade-up" data-aos-duration="2000">
                        <img class="v-img-right" src="assets/img/q2.jpg" alt="Quality">
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
<!--===body===-->
@endsection



