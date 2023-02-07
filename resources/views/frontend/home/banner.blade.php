@php
    $banner = \App\Pharmalys\BlockQuery::init('home')->typeOf('banner-slider')->getContent();
    $banner_file = get_content_field($banner, 'video');
    $banner_file_mime = pharmalys_get_banner_mime($banner_file);
@endphp
<div class="video-player" id="video-player">
    <video width="100%" id="video_banner" autoplay muted loop
           style="right: 0; top: 0; min-width:100%;object-fit: cover;z-index: 999999">
        <source src="{{ $banner_file }}" type="{{ $banner_file_mime }}">
        <source src="{{ $banner_file }}" type="{{ $banner_file_mime }}">
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
            {{ get_content_field($banner, 'title') }}
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
                    <source src="{{ $banner_file }}" type="{{ $banner_file_mime }}">
                    <source src="{{ $banner_file }}" type="{{ $banner_file_mime }}">
                </video>
            </div>

        </div>
    </div>
</div>