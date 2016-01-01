'use strict';
var theme = function () {

    // BootstrapSelect
    // ---------------------------------------------------------------------------------------
    function handleBootstrapSelect() {
        $('.selectpicker').selectpicker();
    }

    // add hover class for correct view on mobile devices
    // ---------------------------------------------------------------------------------------
    function handleHoverClass() {
        var hover = $('.thumbnail');
        hover.hover(
          function () { $(this).addClass('hover'); },
          function () { $(this).removeClass('hover'); }
        );
    }

    // Smooth scrolling
    // ---------------------------------------------------------------------------------------
    function handleSmoothScroll() {
        $('.sf-menu a, .scroll-to').click(function () {

            if ($(this).hasClass('btn-search-toggle')) {
                $('.header-search-wrapper').fadeToggle();
                $('.header').toggleClass('header-overlay');
            }
            else {

                //var headerH = $('header').outerHeight();
                var headerH = 0;
                $('.sf-menu a').removeClass('active');
                $(this).addClass('active');
                $('html, body').animate({
                    scrollTop: $($(this).attr('href')).offset().top - headerH + 'px'
                }, {
                    duration: 1200,
                    easing: 'easeInOutExpo'
                });
                return false;

            }
        });
    }

    // preloader
    // ---------------------------------------------------------------------------------------
    $(window).load(function () {
        $('#status').fadeOut();
        $('#preloader').delay(200).fadeOut(100);
    });

    // Isotope
    $(window).load(function () {
        if ($().isotope) {
            $('.isotope.events').isotope({// initialize isotope
                filter: '.festival',
                itemSelector: '.isotope-item' // options...
                        //,transitionDuration: 0 // disable transition
            });
            var $filtrableEvents = $('#filtrable-events').find('a');
            $filtrableEvents.click(function () { // filter items when filter link is clicked
                var selector = $(this).attr('data-filter');
                $filtrableEvents.parent().removeClass('current');
                $(this).parent().addClass('current');
                $('.isotope.events').isotope({filter: selector});
                return false;
            });

            $('.isotope.gallery').isotope({// initialize isotope
                itemSelector: '.isotope-item' // options...
                        //,transitionDuration: 0 // disable transition
            });

            var $filtrableGallery = $('#filtrable-gallery').find('a');
            $filtrableGallery.click(function () { // filter items when filter link is clicked
                var selector = $(this).attr('data-filter');
                $filtrableGallery.parent().removeClass('current');
                $(this).parent().addClass('current');
                $('.isotope.gallery').isotope({filter: selector});
                return false;
            });
        }
    });

    // Shrink header on scroll
    // ---------------------------------------------------------------------------------------
    function handleAnimatedHeader() {
        var header = $('.header.fixed');
        function refresh() {
            var scroll = $(window).scrollTop();
            if (scroll >= 99) {
                header.addClass('shrink');
            } else {
                header.removeClass('shrink');
            }
        }

        $(window).load(function() { refresh(); });
        $(window).scroll(function() { refresh(); });
        $(window).on('touchstart scrollstart scrollstop touchmove', function () { refresh(); });
    }

    // resize page
    // ---------------------------------------------------------------------------------------
    function resizePage() {
      var $mainSlider = $('#main-slider');
        if ($('body').hasClass('boxed')) {
            $mainSlider.find('.page').each(function () {
                $(this).removeAttr('style');
            });
        }
//        if ($('body').hasClass('coming-soon')) {
//            $('#main-slider').find('.page').each(function () {
//                $(this).removeAttr('style');
//                $('.page').css('min-height', $(window).height());
//            });
//        }
//        else {
//            $('.page').css('min-height', $(window).height());
//        }
        $mainSlider.trigger('refresh');
        $('#testimonials').trigger('refresh');
        $('.partners-carousel .owl-carousel').trigger('refresh');
        $('.partners-carousel-2 .owl-carousel').trigger('refresh');
        $('.carousel-slider .owl-carousel').trigger('refresh');
    }

    // INIT FUNCTIONS
    // ---------------------------------------------------------------------------------------
    return {
        onResize: function () {
            resizePage();
        },

        init: function () {
            handleBootstrapSelect();
            handleHoverClass();
            handleSmoothScroll();
            handleAnimatedHeader();
        },

        // Google map
        initGoogleMap: function () {
            var map, marker;
            function initialize() {
                map = new google.maps.Map(document.getElementById('map-canvas'), {
                    scrollwheel: false,
                    zoom: 11,
                    center: new google.maps.LatLng(-22.948611,-43.207222)
                });
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(-22.948611,-43.157222),
                    map: map,
                    icon: '/assets/img/icon-google-map.png',
                    title: 'We are here!'
                });
            }
            google.maps.event.addDomListener(window, 'load', initialize);
        }

    };

}();

$(document).ready(function () {

    // Google map
    // ---------------------------------------------------------------------------------------
    if (typeof google === 'object' && typeof google.maps === 'object') {
        if ($('#map-canvas1').length) {

            var map;
            var marker;
            var infowindow;

            var image = '/assets/img/icon-google-map.png'; // marker icon
            google.maps.event.addDomListener(window, 'load', function () {
                var mapOptions = {
                    scrollwheel: false,
                    zoom: 10,
                    center: new google.maps.LatLng(-22.948611,-43.157222) // map coordinates
                };

                map = new google.maps.Map(document.getElementById('map-canvas1'), mapOptions);
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(41.0096559,28.9755535), // marker coordinates
                    map: map,
                    icon: image,
                    title: 'Hello World!'
                });

                //infowindow = new google.maps.InfoWindow({
                //    content: contentString
                //    ,maxWidth: 50
                    //,maxHeight: 500
                //});
                google.maps.event.addListener(marker, 'click', function() {
                    infowindow.open(map,marker);
                });

                // open marker when google map init
                function initialize() {
                    google.maps.event.trigger(marker, 'click');
                }
                initialize();

                /*
                 * The google.maps.event.addListener() event waits for
                 * the creation of the infowindow HTML structure 'domready'
                 * and before the opening of the infowindow defined styles
                 * are applied.
                 */
                google.maps.event.addListener(infowindow, 'domready', function() {

                    // Reference to the DIV which receives the contents of the infowindow using jQuery
                    var iwOuter = $('.gm-style-iw');

                    /* The DIV we want to change is above the .gm-style-iw DIV.
                     * So, we use jQuery and create a iwBackground variable,
                     * and took advantage of the existing reference to .gm-style-iw for the previous DIV with .prev().
                     */
                    var iwBackground = iwOuter.prev();

                    // Remove the background shadow DIV
                    iwBackground.children(':nth-child(2)').css({'display' : 'none'});

                    // Remove the white background DIV
                    iwBackground.children(':nth-child(4)').css({'display' : 'none'});

                    // Moves the infowindow 115px to the right.
                    iwOuter.parent().parent().css({left: '10px'});

                    // Moves the shadow arrow // hide
                    iwBackground.children(':nth-child(1)').attr('style', function(i,s){ return s + 'display: none !important;'});

                    // Moves the arrow 76px to the left margin
                    iwBackground.children(':nth-child(3)').attr('style', function(i,s){ return s + 'left: 80px !important; margin-top: -10px; z-index: 0;'});

                    // Changes the desired color for the tail outline.
                    // The outline of the tail is composed of two descendants of div which contains the tail.
                    // The .find('div').children() method refers to all the div which are direct descendants of the previous div.
                    iwBackground.children(':nth-child(3)').find('div').children().css({'box-shadow': 'rgba(255, 255, 255, 0.1) 0px 1px 6px', 'z-index' : '1'});

                    // Taking advantage of the already established reference to
                    // div .gm-style-iw with iwOuter variable.
                    // You must set a new variable iwCloseBtn.
                    // Using the .next() method of JQuery you reference the following div to .gm-style-iw.
                    // Is this div that groups the close button elements.
                    var iwCloseBtn = iwOuter.next();

                    // Apply the desired effect to the close button
                    iwCloseBtn.css({
                        opacity: '1',
                        right: '48px', top: '14px',
                        width: '19px', height: '19px',
                        border: '3px solid #ffffff',
                        'border-radius': '17px',
                        'background-color': '#ffffff'
                    });

                    // The API automatically applies 0.7 opacity to the button after the mouseout event.
                    // This function reverses this event to the desired value.
                    iwCloseBtn.mouseout(function(){
                        $(this).css({opacity: '1'});
                    });

                });

            });

        }
    }

});
