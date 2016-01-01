'use strict';
var theme = function () {

    // add hover class for correct view on mobile devices
    // ---------------------------------------------------------------------------------------
    function handleHoverClass() {
        var hover = $('.thumbnail');
        hover.hover(
          function () { $(this).addClass('hover'); },
          function () { $(this).removeClass('hover'); }
        );
    }

    // Shrink header on scroll
    // ---------------------------------------------------------------------------------------
    function handleAnimatedHeader() {
        var header = $('.header.fixed');
        function refresh() {
          header.toggleClass('shrink', $(window).scrollTop() >= 99);
        }

        $(window)
          .load(refresh)
          .scroll(refresh)
          .on('touchstart scrollstart scrollstop touchmove', refresh);
    }

    // INIT FUNCTIONS
    // ---------------------------------------------------------------------------------------
    return {
        init: function () {
            handleHoverClass();
            handleAnimatedHeader();
        },

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
    // TODO: this could probably be moved into a separate file, as maps are not used in all pages
    // TODO: inject back this script when Google Maps is implemented: https://maps.googleapis.com/maps/api/js?v=3.exp
    // ---------------------------------------------------------------------------------------
    if (typeof google === 'object' && typeof google.maps === 'object') {
        if ($('#map-canvas1').length) {
            var map, marker, infowindow;

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
                //    ,maxHeight: 500
                //});
                //google.maps.event.addListener(marker, 'click', function() {
                //    infowindow.open(map,marker);
                //});

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
