@extends('frontend.layouts.app')
@section('head')
<x-meta current-page-id="story" />
@endsection
@section('content')
<div class="v-app ">
    <!--Top heading-->
    <div class="container v-b-m">
        <div class="row pt-160 pb-160">
            @if($header)
                <div class="col-lg-8 offset-lg-4 col-md-12">
                    <h1 class="vfs-64 lh-80 vf-600 color-blue mw-720 mw-md-550 ms-lg-5 mb-4" data-aos="fade-up"
                        data-aos-duration="2000">
                       {{ $header->title }}
                    </h1>
                    <h3 class="vfs-24 lh-36 color-blue  mw-md-550 mw-720 ms-lg-5" data-aos="fade-up"
                        data-aos-duration="2000">
                        {{ $header->description }}
                    </h3>
                </div>
            @endif
        </div>
    </div>
    <!--Top heading-->
    <!--stories-->
    <div class="container-fluid pb-70">
        <div class="row">
            <div class="col-md-12">
                <div class="stories-m-listing" data-aos="fade-up" data-aos-duration="2000">
                    <ul class="stories-listing-slider v-listing-tab">
                        <li><a href="#link" class="tablinks active" onclick="openListing(event, 'v-tab-1')"id="defaultOpen"> All Topics</a></li>
                        <li><a href="#link" class="tablinks" onclick="openListing(event, 'v-tab-2')"> Insights</a></li>
                        <li><a href="#link" class="tablinks" onclick="openListing(event, 'v-tab-3')"> Manufacturing</a></li>
                        <li><a href="#link" class="tablinks" onclick="openListing(event, 'v-tab-4')"> Research</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--All stories-->
    <div id="v-tab-1" class="tabcontent">
        <div class="container pb-70" data-aos="fade-up" data-aos-duration="2000">
            @if($stories)
            <?php $s =  1;?>
            @foreach($stories as $story)
                @if($s<=3)
                <a href="#link" class="v-stories" data-aos="fade-up" data-aos-duration="2000">
                    <div class="row mb-5 align-items-center">
                        <div class="col-md-5">
                            <div class="v-stories-img">
                                <div class="v-stories-img-slide">
                                    <img src="{{ asset('storage/'.$story->image)}}" alt="Stories">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 pt-lg-3">
                            <h3 class="v-title text-black ps-220">{{ $story->title }} </h3>
                            <h6 class="text-black ps-220"><b>Category: </b> {{ $story->category->name }}</h6>
                        </div>
                    </div>
                </a>
                @endif
                <?php $s++;?>
            @endforeach
            @endif
            <div class="row align-items-center v-m-show-all-stories">
                <div class="col-md-12 position-relative d-block d-md-none">
                    <div class="v-link-after-v1 ">
                        <a href="{{ route('frontend.stories')}}" class="text-black vf-600">Show all stories</a>
                    </div>
                </div>
            </div>
        </div>
        <!--stories-->
        <!--featured stories-->
        <div class="bg-blue pt-90 pb-240 featured-stories-container">
            <div class="container-fluid pb-70">
                <div class="row">
                    <div class="col-12" data-aos="fade-up" data-aos-duration="2000">
                        <h3 class="v-headingtext-white ps-lg-3">Featured Stories</h3>
                    </div>
                </div>
            </div>
            <div class="featured-stories-slider-container" data-aos="fade-up" data-aos-duration="2000">
                <div class="v-nav featured-stories-slider-active">
                    @if($feature_stories)
                        @foreach($feature_stories as $fs)
                        <a href="#link" class="v-featured-stories-box position-relative">
                            <div class="v-stories-img">
                                <div class="v-stories-img-slide">
                                    <img src="{{ asset('storage/'.$fs->image)}}" alt="Stories">
                                </div>
                            </div>
                            <div class="v-featured-stories-content">
                                <h3 class="v-title text-white v-transition">
                                    {{ $story->title }}
                                </h3>
                                <h6 class="text-white"><b>Category:</b> {{ $story->category->name }}</h6>
                            </div>
                        </a>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <!--featured stories-->
        <!--stories-->
        <div class="container pt-150 pb-70 v-box-stories" data-aos="fade-up" data-aos-duration="2000">
            <div class="row mb-lg-5 align-items-center justify-content-between">
                @if($stories)
                    <?php $ls = 1;?>
                    @foreach($stories as $story)
                        @if($ls>3)
                            <div class="col-md-6 mb-5" data-aos="fade-up" data-aos-duration="2000">
                                <a href="#link" class="v-stories-box">
                                    <div class="v-stories-img">
                                        <div class="v-stories-img-slide">
                                            <img src="{{ asset('storage/'.$story->image)}}" alt="Stories">
                                        </div>
                                    </div>
                                    <h3 class="v-title text-black"> {{ $story->title }}</h3>
                                    <h6 class="text-black"><b>Category:</b> {{ $story->category->name }}</h6>
                                </a>
                            </div>
                        @endif
                        <?php $ls++;?>
                    @endforeach
                @endif
            </div>
            <div class="row align-items-center v-m-show-all-stories pt-5 pb-160">
                <div class="offset-lg-6 col-lg-6 position-relative">
                    <div class="v-link-after-v1 ">
                        <a href="stories-filter.php" class="text-black vf-600 ps-lg-5">View Archive</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- stories-->
    </div>
    <div id="v-tab-2" class="tabcontent"><x-insight :stories="$insights" /></div>
    <div id="v-tab-3" class="tabcontent"><x-manufacturing :stories="$manufacturings" /></div>
    <div id="v-tab-4" class="tabcontent"><x-research :stories="$reasearchs" /></div>
</div>
@endsection

@push('custom-scripts')
<script>
    function openListing(evt, listItems) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace("active","");
        }
        document.getElementById(listItems).style.display = "block";
        evt.currentTarget.className += "active";
    }
    document.getElementById("defaultOpen").click();
</script>
@endpush