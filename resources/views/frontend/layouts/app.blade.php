<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @yield('head')

    <!--=== favicon ===-->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <!--=== favicon ===-->

    <!--===style===-->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
          integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/slick.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/slick-theme.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/default.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/media.css') }}">
    <!--===style===-->

    @method('header')
</head>
<body>
@include('frontend.partials.header')

<!--===body===-->

@yield('content')

<!--===body===-->

@include('frontend.partials.footer')

<!--===script===-->
<script src="{{ asset('assets/js/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/slick.min.js') }}"></script>
<script src="{{ asset('assets/js/aos.js') }}"></script>
<script src="{{ asset('assets/js/site-script.js') }}"></script>
<!--===script===-->

<script>
    function openFullscreen() {

        var video_banner = document.getElementById("video_banner");
        if (video_banner.requestFullscreen) {
            video_banner.requestFullscreen();
        } else if (video_banner.webkitRequestFullscreen) { /* Safari */
            video_banner.webkitRequestFullscreen();
        } else if (video_banner.msRequestFullscreen) { /* IE11 */
            video_banner.msRequestFullscreen();
        }
    }

    function exitvFullscreen() {

        document.getElementById("video_banner").controls = false;
        var element = document.getElementById("video-player");
        element.classList.remove("v-video-style");
        document.body.classList.remove('v-overflow-hidden');

    }

    function playPause() {
        if (video_banner.paused)
            video_banner.play();
        else
            video_banner.pause();
    }

    var video_modal = document.getElementById("video_modal");

    function videoMuted() {
        video_modal.pause();
    }

    function videoPlay() {
        video_modal.play();
    }
</script>
<!--only for home page video popup-->
@stack('custom-scripts')
@stack('footer')
</body>
    <!--Geotargetly Script-->
    <script>
        (function(g,e,o,t,a,r,ge,tl,y){
        t=g.getElementsByTagName(e)[0];y=g.createElement(e);y.async=true;
        y.src='https://g1386590346.co/gl?id=-NMNH4QwM31bWE83wGGt&refurl='+g.referrer+'&winurl='+encodeURIComponent(window.location);
        t.parentNode.insertBefore(y,t);
        })(document,'script');
    </script>
</html>

