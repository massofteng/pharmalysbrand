(function ($) {
    "use strict";

    /*loader*/
    $(window).on('load', function () {
        $('.loading-section').hide();
    })
    /*loader*/
    /*aos init for animation*/
    AOS.init();
    /*aos init for animation*/

    /*=== language location popup ===*/
    $('.location-cta,.offcanvasMobileLabel').click(function () {
        $('.location-language').slideToggle();
        $('body').toggleClass('location-language-modal-open');
    });
    $('.language-location-submit,.v-btn-close').click(function () {
        $('.location-language').slideUp();
        $('body').removeClass('location-language-modal-open');

    });
    /*=== language location popup ===*/
    /*footer mobile*/
    $('.widget').click(function () {
        $('.widget').not(this).removeClass('active')
        $(this).toggleClass('active')
    });
    /*footer mobile*/

    // $('.facts-slider-active_').slick({
    // dots: false,
    // autoplay: false,
    // autoplaySpeed: 500,
    // arrows: true,
    // fade: true,
    // infinite: false,
    // prevArrow: "<img class='a-left control-c prev slick-prev' src='assets/img/prev.png'>",
    // nextArrow: "<img class='a-right control-c next slick-next' src='assets/img/next.png'>",
    // slidesToShow: 3,

    //  centerMode: true,
    //infinite: false,
    //centerPadding: '100px',
    //slidesToShow: 1,

    // responsive: [
    //     {
    //         breakpoint: 768,
    //         settings: {
    //             arrows: false,
    //             centerMode: true,
    //             centerPadding: '40px',
    //             slidesToShow: 3
    //         }
    //     },
    // {
    //     breakpoint: 480,
    //     settings: {
    //         arrows: false,
    //         centerMode: true,
    //         centerPadding: '40px',
    //         slidesToShow: 1
    //     }
    // }
    // ]

    //});
    /*Featured stories slider stories page*/
    $('.featured-stories-slider-active').slick({
        infinite: false,
        speed: 300,
        slidesToShow: 1,
        centerMode: true,
        variableWidth: true,
        prevArrow: "<img class='a-left control-c prev slick-prev' src='assets/img/prev.png' alt='Pre'>",
        nextArrow: "<img class='a-right control-c next slick-next' src='assets/img/next.png' alt='next'>",
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    centerMode: false,
                    variableWidth: false,
                }
            }
        ]

    });
    /*Featured stories slider stories page*/

    /* stories details slider*/
    $('.stories-details-slider-active').slick({
        infinite: false,
        speed: 300,
        slidesToShow: 1,
        centerMode: true,
        variableWidth: true,
        prevArrow: "<img class='a-left control-c prev slick-prev' src='assets/img/prev.png' alt='Pre'>",
        nextArrow: "<img class='a-right control-c next slick-next' src='assets/img/next.png' alt='next'>",
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    centerMode: false,
                    variableWidth: false,
                }
            }
        ]

    });
    /* stories details slider*/


    /*stories listing slider*/
    if ($(window).width() <= 580) {
        $('.stories-listing-slider').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: false,
            autoplaySpeed: 2000,
            prevArrow: "<img class='a-left control-c prev slick-prev' src='assets/img/prev-1.png' alt='Pre'>",
            nextArrow: "<img class='a-right control-c next slick-next' src='assets/img/next-1.png' alt='next'>",
        });
    }
    /*stories listing slider*/
    /*about page country*/
    if ($(window).width() <= 580) {
        $('.v-tab-list').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: false,
            autoplaySpeed: 2000,
            prevArrow: "<img class='a-left control-c prev slick-prev' src='assets/img/prev-1.png' alt='Pre'>",
            nextArrow: "<img class='a-right control-c next slick-next' src='assets/img/next-1.png' alt='next'>",
            responsive: [
                {
                    breakpoint: 380,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                    }
                }]
        });
    }
    /*about page country*/


    /*brand slider home page*/
    if ($(window).width() <= 1024) {

        $('.v-brand-slider').slick({
            infinite: false,
            speed: 300,
            slidesToShow: 1,
            centerMode: true,
            variableWidth: true,
            adaptiveHeight: false,
            prevArrow: "<img class='a-left control-c prev slick-prev' src='assets/img/prev.png' alt='Pre'>",
            nextArrow: "<img class='a-right control-c next slick-next' src='assets/img/next.png' alt='next'>",
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        centerMode: false,
                        variableWidth: false,
                    }
                }
            ]

        });
    }
    /*brand slider home page*/
    /*facts  slider home page*/

    if ($(window).width() <= 769) {
        $('.facts-slider-active').slick({

            infinite: false,
            speed: 300,
            slidesToShow: 1,
            centerMode: true,
            variableWidth: true,
            prevArrow: "<img class='a-left control-c prev slick-prev' src='assets/img/prev.png' alt='Pre'>",
            nextArrow: "<img class='a-right control-c next slick-next' src='assets/img/next.png' alt='next'>",

        });
    }

    /*facts  slider home page*/
    $('.history-slide').slick({

        infinite: true,
        speed: 300,
        slidesToShow: 4,
        slidesToScroll: 1,
        vertical: true,
        autoplay: true,

        pauseOnHover: false,
        centerMode: true,
        autoplaySpeed: 5000,
        prevArrow: false,
        nextArrow: false,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    infinite: true,
                    vertical: false,
                    prevArrow: "<img class='a-left control-c prev slick-prev' src='assets/img/prev.png' alt='Pre'>",
                    nextArrow: "<img class='a-right control-c next slick-next' src='assets/img/next.png' alt='next'>",
                }

            },]
    });
    // $('.history-slide').on('beforeChange', function(event, slick, currentSlide, nextSlide){
    //     $(".slick-slide").removeClass('works');
    //     $('.slick-current').addClass('works');
    // });

    // const slider_history = $(".history-slide");
    // slider_history
    //     .slick({
    //         infinite: false,
    //         speed: 300,
    //         slidesToShow: 3,
    //         slidesToScroll: 1,
    //         vertical: true,
    //         autoplay: false,
    //         // pauseOnHover:false,
    //         autoplaySpeed: 500,
    //         prevArrow: "<img class='a-left control-c prev slick-prev' src='assets/img/prev.png' alt='Pre'>",
    //         nextArrow: "<img class='a-right control-c next slick-next' src='assets/img/next.png' alt='next'>",
    //     });
    //
    // slider_history.on('wheel', (function (e) {
    //     e.preventDefault();
    //
    //     if (e.originalEvent.deltaY < 0) {
    //         $(this).slick('slickPrev');
    //     } else {
    //         $(this).slick('slickNext');
    //     }
    // }));

})(jQuery);