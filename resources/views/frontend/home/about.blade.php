@extends('frontend.layouts.app')
@section('head')
<x-meta current-page-id="about" />
@endsection
@section('content')
<?php
//dd($abouts);
if($abouts){
    if(isset($abouts[0])){
        $first = json_decode($abouts[0]->contents);
    }
    if(isset($abouts[1])){
        $second = json_decode($abouts[1]->contents);
    }
    if(isset($abouts[2])){
        $third = json_decode($abouts[2]->contents);
    }
    if(isset($abouts[3])){
        $fourth = json_decode($abouts[3]->contents);
    }
}
?>
<div class="v-app">
    @if(isset($first[0]->content))
    <div class="v-full-width v-b-m loading-head">
        <div class="container ">
            <div class="row align-items-center position-relative" data-aos="fade-left" data-aos-duration="1600">
                <div class="col-md-5 d-none d-md-block d-lg-block d-xl-block">
                    <img class="v-img-left" src="{{ asset('storage/'.$first[0]->content[0]->image)}}" alt="{{ $first[0]->content[0]->title }}">
                </div>
                <div class="col-md-7">
                    <div class="mw-480 ms-80 mb-4">
                        <h1 class="v-heading color-blue ">
                           {{ $first[0]->content[0]->title}}
                        </h1>
                    </div>
                    <div class="mw-480 pb-160 ms-160">
                        <p class="v-details color-blue mb-4 ">
                            {{ $first[0]->content[0]->sub_description}}
                        </p>

                    </div>
                    <div class="mw-480 ms-80 mb-4">
                        <a class="v-link v-link-arrow-down" href="#link">
                            <img src="assets/img/arrow-down.png" alt="Arrow Down">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-block d-md-none">
            <img class="v-img-left" src="assets/img/abm.jpg" alt="Work">
        </div>
    </div>
    <!--image left fullwidth section end-->
    <!--text right start-->
    <div class="container">
        <div class="row pt-160 pb-160 pt-md-100 pb-md-100">

            <div class="col-lg-8 offset-lg-4 col-md-12">
                <h3 class="v-sub-heading color-blue mw-720 mw-md-575 ms-lg-5" data-aos="fade-up" data-aos-duration="2000">
                    {{ $first[0]->content[0]->description}}
                </h3>
            </div>
        </div>
    </div>
    @endif
    <!--text right end-->
    <!--full bg image start-->
    @if(isset($second[0]->content))
    <div class="container d-block d-md-none">
        <div class="row">
            <div class="col-12">
                <h3 class="v-heading color-blue mw-575 m-auto pb-5" data-aos="fade-up" data-aos-duration="2000">
                   {{ $second[0]->content[0]->title}}
                </h3>
            </div>
        </div>
    </div>
    <div class="full-img-bg about-full-img-bg">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-4 text-center" data-aos="fade-up" data-aos-duration="2000">
                    <a href="https://www.youtube.com/@SeliseGroup" target="_blank">
                        <img class="ps-lg-5" src="assets/img/a-play.png" alt="About Play">
                    </a>
                </div>
                <div class="col-md-8  d-none d-md-block">
                    <div class="mw-710 ms-lg-5">
                        <h3 class="vfs-64 lh-80 text-white vf-600" data-aos="fade-up" data-aos-duration="2000">
                            {{ $second[0]->content[0]->description_title}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--full bg image end-->
    <!-- text right start-->
    <div class="container">
        <div class="row pt-160 pb-160 mw-md-575 pt-md-50 pb-md-50">

            <div class="col-lg-8 offset-lg-4 col-md-12" data-aos="fade-up" data-aos-duration="2000">
                <h3 class="vfs-28 lh-35 color-blue vf-600  ms-lg-5">{{ $second[0]->content[0]->description}}.</p>
            </div>
        </div>
    </div>
    @endif
    <!-- text right end-->
    <!--image left fullwidth section start-->
    @if(isset($third[0]->content))
    <div class="v-full-width v-b-m pb-240 v-our-values">
        <div class="container">
            @foreach($third[0]->content as $content)
            <div class="row">
                <div class="col-md-5 d-none d-md-block d-lg-block d-xl-block" data-aos="fade-up" data-aos-duration="2000">
                    <img class="v-img-left" src="{{ asset('storage/'.$content->logo)}}" alt="{{ $content->title }}">
                </div>
                <div class="col-md-7 mw-md-575">
                    <!-- remove class for v-p-box-hr and add extra class for pb-50-->
                    <div class="d-md-flex d-block mw-595 ms-160  pt-70 pb-50" data-aos="fade-up" data-aos-duration="2000">
                        <div class="v-p-box-img">
                            <img src="{{ asset('storage/'.$content->logo)}}" alt="{{ $content->title }}">
                        </div>
                        <div class="v-p-box-content">
                            <h3 class="vfs-24 lh-30 color-blue vf-600 pt-3">
                                {{ $content->title}}
                            </h3>
                            <p class="color-blue-shade">
                                {{ $content->description}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="d-block d-md-none" data-aos="fade-up" data-aos-duration="2000">
            <img class="v-img-left" src="assets/img/apm2.jpg" alt="Work">
        </div>
    </div>
    @endif
    <!--image left fullwidth section end-->
    <!--history section start-->
    @if(isset($fourth[0]))
    <div class="bg-blue history-slide-padding">
        <div class="container-fluid pb-70">
            <div class="row align-items-center">
                <div class="col-12" data-aos="fade-up" data-aos-duration="2000">
                    <h3 class="v-heading text-white">{{__('about.brand')}}</h3>
                </div>
            </div>
        </div>
        <div class="container history-slide v-nav">
            @foreach($fourth[0]->content as $content)
            <div class="container history-slide v-nav">
                <div class="history-box-single">
                    <div class="row align-items-center flex-column-reverse flex-md-row">
                        <div class="col-md-5">
                            <div class="history-image">
                                <img src="{{ asset('storage/'.$content->logo)}}" alt="{{ $content->title }}">
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="history-text">
                                <h3>{{ $content->title }}</h3>
                                <p>{{ $content->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    <!--history section end-->
    <!--brand lives section start-->

    {{-- This part like as landing page partner --}}
    @if($partners)
    @foreach ($partners as $partner)
        <div class="v-full-width quality-m pb-240 pt-150">
            <div class="container ">
                <div class="row align-items-top">
                    <div class="col-md-5 pt-210" data-aos="fade-up" data-aos-duration="2000">
                        <img class="v-img-left" src="{{ asset('storage/'.$partner->image_one)}}" alt="{{ $partner->title }}">
                    </div>
                    <div class="col-md-7">
                        <h3 class="ps-lg-5 ps-3 pb-70 v-heading color-blue mw-575" data-aos="fade-up" data-aos-duration="2000">
                            {{ $partner->title }}</h3>
                        <div class="mw-480  ms-190  pb-135 pt-2" data-aos="fade-up" data-aos-duration="2000">
                            <p class="mb-4">
                                {{ $partner->description }}
                            </p>
                        </div>
                        <div class="text-end" data-aos="fade-up" data-aos-duration="2000">
                            <img class="v-img-right" src="{{ asset('storage/'.$partner->image_two)}}" alt="{{ $partner->title }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @endif
    <!--brand lives section end-->
    <!--brand section start-->
    <div class="bg-blue-shade pb-160 pt-70">
        <div class="container-fluid pb-70">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <h3 class="v-heading color-blue">{{__('home.brand')}}</h3>
                </div>
                <div class="col-md-5 position-relative d-none d-md-block z-5">
                    <div class="v-link-after-v1 ">
                        <a href="#link" class="text-black vf-600">Visit the brands page</a>
                    </div>
                </div>
            </div>
        </div>
        {{-- brand like as landing page brand --}}
        <div class="container-fluid">
            <div class="row v-nav v-brand-slider">
                @if($brands)
                    @foreach ($brands as $brand)
                    <div class="col-md-4 " data-aos="fade-left" data-aos-duration="3000">
                        <div class=" box-section ">
                            <div class="box-section-img">
                                <img src="{{ asset('storage/'.$brand->logo)}}" alt="{{ $brand->title }}">
                            </div>
                            <h5 class="v-box-title color-blue color-blue vf-600">{{ $brand->title }}</h5>
                            <p class="color-black-shade v-body">
                                {{ $brand->description }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                @endif
                <div class="col-md-4 " data-aos="fade-left" data-aos-duration="3000">
                    <div class=" box-section ">
                        <div class="box-section-img">

                            <img src="assets/img/b1.png" alt="Brands">
                        </div>
                        <h5 class="v-box-title color-blue color-blue vf-600">Primalac</h5>
                        <p class="color-black-shade v-body">In addition to infant formula for the first months and years
                            of your child's life, with
                            Primalac
                            we
                            also offer formulas for children with special needs. Premature babies, children with
                            allergies
                            or a
                            low birth weight – we help your children to develop a strong immune system from day one.</p>
                    </div>
                </div>
            </div>
            <div class="row align-items-center v-m-show-all-stories">
                <div class="col-md-12 position-relative d-block d-md-none z-5">
                    <div class="v-link-after-v1 ">
                        <a href="#link" class="text-black vf-600">Visit the brands page</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--brand section end-->
    <!--map & text right start -->
    <div class="container">
        <div class="row pt-160 pb-160 mw-md-575 pt-md-50 pb-md-50">

            <div class="col-lg-8 offset-lg-4 col-md-12" data-aos="fade-up" data-aos-duration="2000">
                <h3 class="vfs-28 lh-35 color-blue vf-600  ms-lg-5">At home in the world</h3>
                <p class="ms-lg-5">We support parents all over the world in giving their children a healthy start in
                    life. With products and information that originate in Switzerland.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-12" data-aos="fade-up" data-aos-duration="2000">
                <img src="assets/img/world-map.png" alt="World Map">
            </div>
        </div>
    </div>
    <!--map & text right end-->
    <!--country tab start-->
    <div class="container">
        <div class="row pt-160 pb-160 mw-md-575 pt-md-50 pb-md-50">

            <div class="col-md-7 offset-md-5" data-aos="fade-up" data-aos-duration="2000">

                <ul class="v-tab-list nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <span class="active v-tab-list-item" id="pills-tab-1" data-bs-toggle="pill" data-bs-target="#pills-tab-id-1" role="tab" aria-controls="pills-tab-id-1" aria-selected="true">All
                        </span>
                    </li>

                    <li class="nav-item" role="presentation">
                        <span class="v-tab-list-item" id="pills-tab-2" data-bs-toggle="pill" data-bs-target="#pills-tab-id-2" role="tab" aria-controls="pills-tab-id-2" aria-selected="true"> Africa

                        </span>
                    </li>
                    <li class="nav-item" role="presentation">
                        <span class="v-tab-list-item" id="pills-tab-3" data-bs-toggle="pill" data-bs-target="#pills-tab-id-3" role="tab" aria-controls="pills-tab-id-3" aria-selected="true"> America

                        </span>
                    </li>

                    <li class="nav-item" role="presentation">
                        <span class="v-tab-list-item" id="pills-tab-4" data-bs-toggle="pill" data-bs-target="#pills-tab-id-4" role="tab" aria-controls="pills-tab-id-4" aria-selected="true"> Asia Pacific

                        </span>
                    </li>
                    <li class="nav-item" role="presentation">
                        <span class="v-tab-list-item" id="pills-tab-5" data-bs-toggle="pill" data-bs-target="#pills-tab-id-5" role="tab" aria-controls="pills-tab-id-5" aria-selected="true"> Europe
                        </span>
                    </li>
                    <li class="nav-item" role="presentation">
                        <span class="v-tab-list-item" id="pills-tab-5" data-bs-toggle="pill" data-bs-target="#pills-tab-id-5" role="tab" aria-controls="pills-tab-id-5" aria-selected="true"> Middle East
                        </span>
                    </li>

                </ul>
                <div class="tab-content v-tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-tab-id-1" role="tabpanel" aria-labelledby="pills-tab-1">
                        <ul>
                            <li>1</li>
                            <li>Algeria</li>
                            <li>Bahrain</li>

                            <li>Burundi</li>

                            <li> Benin</li>

                            <li> Burkina Faso</li>

                            <li> Cameroon</li>

                            <li>China</li>

                            <li>Congo Brazza</li>

                            <li> Djibouti</li>

                        </ul>

                    </div>
                    <div class="tab-pane fade" id="pills-tab-id-2" role="tabpanel" aria-labelledby="pills-tab-2">
                        <ul>
                            <li>2</li>
                            <li>Algeria</li>
                            <li>Bahrain</li>

                            <li>Burundi</li>

                            <li> Benin</li>

                            <li> Burkina Faso</li>

                            <li> Cameroon</li>

                            <li>China</li>

                            <li>Congo Brazza</li>

                            <li> Djibouti</li>

                        </ul>
                    </div>

                    <div class="tab-pane fade" id="pills-tab-id-3" role="tabpanel" aria-labelledby="pills-tab-3">
                        <ul>
                            <li>3</li>
                            <li>Algeria</li>
                            <li>Bahrain</li>

                            <li>Burundi</li>

                            <li> Benin</li>

                            <li> Burkina Faso</li>

                            <li> Cameroon</li>

                            <li>China</li>

                            <li>Congo Brazza</li>

                            <li> Djibouti</li>

                        </ul>

                    </div>
                    <div class="tab-pane fade" id="pills-tab-id-4" role="tabpanel" aria-labelledby="pills-tab-4">
                        <ul>
                            <li>4</li>
                            <li>Algeria</li>
                            <li>Bahrain</li>

                            <li>Burundi</li>

                            <li> Benin</li>

                            <li> Burkina Faso</li>

                            <li> Cameroon</li>

                            <li>China</li>

                            <li>Congo Brazza</li>

                            <li> Djibouti</li>

                        </ul>

                    </div>
                    <div class="tab-pane fade" id="pills-tab-id-5" role="tabpanel" aria-labelledby="pills-tab-5">
                        <ul>
                            <li>5</li>
                            <li>Algeria</li>
                            <li>Bahrain</li>

                            <li>Burundi</li>

                            <li> Benin</li>

                            <li> Burkina Faso</li>

                            <li> Cameroon</li>

                            <li>China</li>

                            <li>Congo Brazza</li>

                            <li> Djibouti</li>

                        </ul>

                    </div>
                    <div class="tab-pane fade" id="pills-tab-id-6" role="tabpanel" aria-labelledby="pills-tab-6">
                        <ul>
                            <li>6</li>
                            <li>Algeria</li>
                            <li>Bahrain</li>

                            <li>Burundi</li>

                            <li> Benin</li>

                            <li> Burkina Faso</li>

                            <li> Cameroon</li>

                            <li>China</li>

                            <li>Congo Brazza</li>

                            <li> Djibouti</li>

                        </ul>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--country tab end-->
</div>
@endsection