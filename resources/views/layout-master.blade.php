<!DOCTYPE html>
<!--[if lt IE 7 ]>
<html class="ie ie6" lang="en"><![endif]-->
<!--[if IE 7 ]>
<html class="ie ie7" lang="en"><![endif]-->
<!--[if IE 8 ]>
<html class="ie ie8" lang="en"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en"><!--<![endif]-->
<head>
    <meta charset="utf-8">
    <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@section('title')<?=_('Event Discovery')?>@show [Konato]</title>{{-- https://moz.com/learn/seo/title-tag --}}
    <meta content="Konato" name="apple-mobile-web-app-title">
    <meta content="Konato" name="application-name">

    @include('_favicons')

    {{-- FIXME: COMPILE THIS STUFF!!!!!!!1111ONE11! --}}
    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/plugins/bootstrap-select/bootstrap-select.min.css">
    {{--<link rel="stylesheet" href="assets/plugins/owlcarousel2/assets/owl.carousel.min.css">--}}
    {{--<link rel="stylesheet" href="assets/plugins/owlcarousel2/assets/owl.theme.default.min.css">--}}
    <link rel="stylesheet" href="assets/plugins/prettyphoto/css/prettyPhoto.css">
    <link rel="stylesheet" href="assets/plugins/animate/animate.min.css">
    <link rel="stylesheet" href="assets/plugins/countdown/jquery.countdown.css">
    <link rel="stylesheet" href="/css/styles.css">

    <!--[if lt IE 9]>
        <script src="assets/plugins/iesupport/html5shiv.js"></script>
        <script src="assets/plugins/iesupport/respond.min.js"></script>
    <![endif]-->

    @yield('css')
    @yield('head-js')
</head>
<body id="home" class="wide body-light multipage">

<div class="wrapper">

    <!-- TODO: reevaluate H1~H6 usage, it's a little messy right now -->
    <header class="header fixed">

        {{-- Notification bar. Could be used later }}
            <div class="top-line">
                <div class="container">
                    <ul class="user-menu">
                        <li><a href="#popup-login"  data-toggle="modal"><i class="fa fa-file-text-o"></i> Register Now</a></li>
                        <li><a href="#popup-login" data-toggle="modal"><i class="fa fa-user"></i> Login</a></li>
                    </ul>
                    <div class="hot-line"><span><i class="fa fa-calendar"></i> <strong>Latest Event:</strong></span>  Standart Event Name Here  "15 October at 20:00 - 22:00 on Manhattan / New York"</div>
                </div>
            </div>
        {{ --}}

        <div class="container">
            <div class="header-wrapper clearfix">

                <div class="logo">
                    <a href="/" class="scroll-to">
                        <span class="fa-stack">
                            <i class="fa logo-hex fa-stack-2x"></i>
                            <i class="fa logo-fa fa-cloud fa-stack-1x"></i>
                        </span>
                        Konato
                    </a>
                </div>

                <!-- Navigation -->
                <div id="mobile-menu"></div>
                <nav class="navigation closed clearfix">
                    <a href="#" class="menu-toggle btn"><i class="fa fa-bars"></i></a>
                    <ul class="sf-menu nav">
                        <li{{-- class="active"--}}><a href="/"><i class="fa fa-table"></i> <?=_('Dashboard')?></a></li>
                        <li><a href="#"><i class="fa fa-map-marker"></i> <?=_('Places')?></a></li>
                        <li><a href="#"><i class="fa fa-comments-o"></i> <?=_('Speakers')?></a></li>

                        <li><!-- TODO: REMOVE THIS ENTRY -->
                            <a href="index.html">Template</a>
                            <ul>
                                <li><a href="index.html">Home</a></li>
                                <li><a href="index-2.html">Home 2</a></li>
                                <li><a href="event-list.html">Event List</a></li>
                                <li><a href="event-grid.html">Event Grid</a></li>
                                <li><a href="event-single.html">Single Event</a></li>
                                <li><a href="blog.html">Blog</a></li>
                                <li><a href="blog-single.html">Blog Single</a></li>
                                <li><a href="search-results.html">Search Results</a></li>
                                <li><a href="coming-soon-1.html">Coming Soon 1</a></li>
                                <li><a href="coming-soon-2.html">Coming Soon 2</a></li>
                                <li><a href="coming-soon-3.html">Coming Soon 3</a></li>
                                <li><a href="error-page.html">404</a></li>
                            </ul>
                        </li>

                        <li class="header-search-wrapper">
                            <form action="#" class="header-search-form">
                                <input type="text" class="form-control header-search" placeholder="Search" />
                                <input type="submit" hidden="hidden" />
                            </form>
                        </li>
                        <li><a href="#" class="btn-search-toggle"><i class="fa fa-search"></i></a></li>
                        <li><a href="#" class="btn btn-theme btn-submit-event">SUBMIT EVENT
                                <i class="fa fa-plus-circle"></i></a></li>
                    </ul>
                </nav>
                <!-- /Navigation -->

            </div>
        </div>
    </header>

    <div class="content-area">

        <div id="main">
            <section class="page-section no-padding">
                <div class="container full-width">

                    <div id="hero-block">
                            <div class="div-table">
                                <div class="div-cell">
                                    <h1 class="caption-title"><?=_('Expand your horizons')?></h1>
                                    <h2 class="caption-subtitle"><?=_('Discover even more.<br>Share your knowledge.<br>Get to know great people!')?></h2>
                                    <h4>
                                        <span>
                                            <?=sprintf(_('Find %sconferences%s, %stalks%s, %smeetings%s, %sfairs%s, %sexhibitions%s, and even %sspeakers%s'),
                                                '<a href="#">','</a>',
                                                '<a href="#">','</a>',
                                                '<a href="#">','</a>',
                                                '<a href="#">','</a>',
                                                '<a href="#">','</a>',
                                                '<a href="#">','</a>')?>
                                        </span>
                                    </h4>

                                    <div class="row">
                                        <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                                            <form action="#" class="location-search">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control text" placeholder="<?=_('Find by theme or keyword')?>" />
                                                        <select class="selectpicker">
                                                            <option>LOCATION</option>
                                                            <option>LOCATION</option>
                                                            <option>LOCATION</option>
                                                        </select>
                                                        <button class="form-control button-search">
                                                            <i class="fa fa-search"></i></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <p class="caption-text">
                                        <a class="btn btn-theme btn-theme-dark scroll-to" href="#">Popular Events</a>
                                        <a class="btn btn-theme btn-theme-transparent-white" href="#">Latest Events</a>

                                        {{-- TIP: How to include a video inside a modal --}}
                                        {{--<a class="btn btn-theme btn-theme btn-theme-transparent-white" href="http://www.youtube.com/watch?v=O-zpOMYRi0w" data-gal="prettyPhoto">Latest Events</a>--}}
                                    </p>
                                </div>
                            </div>

                    </div>

                </div>
            </section>
        </div>

        {{-- TIP: here used to be a box to announce a "featured event".
             This could be used later for packages including ads. See the original theme for markup --}}

        {{-- TIP: here used to be a list of events and a horizontal list of categories to filter that list.
             This could be used later to boost our credibility, showing off some important events. See original
             theme for markup --}}

        <!-- PAGE -->
        <section class="page-section light">
            <div class="container">

                <div class="row thumbnails info-thumbs clear">
                    <?php
                        $thumbs = [
                            ['#', 'map', _('Explore new meetings'), //map-signs, map-o
                                _('Ever though <em>"Hey, I never heard of that event! How could I miss such thing?"</em> Enter <strong>Konato</strong>: it won\'t happen again!')
                            ],
                            ['#', 'bullhorn', _('Spread what you know'),
                                _('Reach new audiences and get close to your public - or <em>that</em> speaker from the last congress you\'ve been.')
                            ],
                            ['#', 'users', _('Meet new people'),
                                _('Make new contacts, expand your network and meet like-minded students or professionals - not only those who live nearby.')
                            ],
                            ['#', 'calendar-check-o', _('Prepare for the event'),
                                _('See the schedule and organize yourself. On <b>Konato</b> you\'re sure not to miss the activities of your interest.')
                            ],
                            //['#', 'users', _('Find your speakers'),
                            //    _('Going to organize your own event? Get in touch with field experts and invite (or
                            //    hire) them to help you out!')
                            //]
                        ];
                        foreach ($thumbs as $thumb):
                            list($link, $icon, $title, $desc) = $thumb;
                    ?>
                        <div class="col-sm-6 col-md-3">
                            <div class="thumbnail no-border no-padding text-center">
                                @include('components.rehex', compact('link', 'icon'))
                                <div class="caption">
                                    <h3 class="caption-title"><?=$title?></h3>
                                    <p class="caption-text"><?=$desc?></p>
                                    <p class="caption-more">
                                        <a href="<?=$link?>" class="btn btn-theme"><?=_('Details')?></a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </section>

        {{-- TIP: here used to be a list of hotels. Besides not being used currently, it broke on theme changes.
             See original theme for markup if this gets useful later --}}

        {{-- TIP: here used to be testimonials. This might be useful later, so see original theme for markup --}}

        {{-- TIP: here we had a horizontal list to filter pictures from the list below --}}
        <section class="page-section no-padding-top light">
            <div class="container full-width">

                <h1 class="container section-title">
                    <span class="icon-inner">
                        <span class="fa-stack">
                            <i class="fa rhex fa-stack-2x"></i>
                            <i class="fa fa-photo fa-stack-1x"></i>
                        </span>
                    </span>
                    <span class="title-inner"><?=_('Great events')?> <small> / <?=_('that we\'re proud to have been part of')?></small></span>
                </h1>

                <div class="row thumbnails no-padding gallery">
                    <?php
                        $events = [
                            1 => ['/img/event-sample1.jpg', 'iMasters Developer Week RJ' , 'Rio de Janeiro, Brazil'],
                            2 => ['/img/event-sample2.jpg', 'PHP\'n Rio 2011', 'Rio de Janeiro, Brazil'],
                            3 => ['/img/event-sample3.jpg', 'PHPConf 2015', 'Osasco, Brazil'],
                            4 => ['/img/event-sample4.jpg', 'TDCOnline 2015 POA', 'Porto Alegre, Brazil'],
                            5 => ['/img/event-sample5.jpg', 'O\'Reilly\'s Fluent', 'San Francisco, USA'],
                            6 => ['/img/event-sample6.gif', 'UERJ Sem Muros', 'Rio de Janeiro, Brazil'],
                            7 => ['/img/event-sample7.jpg', '53º Congresso HUPE', 'Rio de Janeiro, Brazil'],
                            8 => ['/img/event-sample8.png', 'XXVI Congresso Brasileiro de Virologia', 'Florianópolis,
                            Brazil']
                        ];
                        shuffle($events);
                        foreach($events as $event):
                            list($img, $title, $desc) = $event;
                            $dimensions = getimagesize(APP_ROOT.'/public'.$img);
                            $size = ($dimensions[0] > $dimensions[1])? '100% auto' : 'auto 100%';
                    ?>
                        <div class="col-md-3 col-sm-6 photos">
                            <a href="#">
                                <div class="thumbnail no-border no-padding">
                                    <div class="media" style="background-image: url(<?=$img?>); background-size:
                                    <?=$size?>;">
                                        {{-- TIP: here used to be a coloured semi-opaque hover with some buttons --}}
                                        <div class="caption back">
                                            <div class="caption-wrapper div-table">
                                                <div class="caption-inner div-cell">
                                                    <h3 class="caption-title"><?=$title?></h3>
                                                    <p class="caption-category"><?=$desc?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach ?>

                </div>
                {{-- TIP: here used to be a centered button to open up all photos --}}
            </div>
        </section>

        {{-- TIP: here used to be a caroussel of sponsors. Not sure this would be useful but... the markup is in the theme --}}

        {{-- TIP: here used to be a caroussel(?) of speakers. Too lousy but could be useful? the markup is in the theme --}}

        {{-- TIP: here was a "featured" block on a different color. might be useful, markup => theme --}}

        {{-- TIP: here was a list of blog posts. seems big but might be useful for SEO/content-marketing later --}}

        <!-- PAGE -->
        <section class="page-section light create-new-event">
            <div class="container text-center">
                <h1 class="section-title">Create Your Own New Event</h1>

                <p>Bring people together, or turn your passion into a business. Eventbrite gives you everything you need to host your best event yet.</p>

                <div><a href="#" class="btn btn-theme btn-theme-md">SUBMIT EVENT</a></div>
            </div>
        </section>
        <!-- /PAGE -->

        <section class="page-section" id="location">
            <div class="container full-width gmap-background">

                {{-- TIP: here was a floating box over the map with details about the event address. markup? in the theme --}}

                <div class="google-map">
                    <div id="map-canvas"></div>
                </div>

            </div>
        </section>


    </div>
    <!-- /Content area -->

    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer-meta">
            <div class="container text-center">
                {{-- TIP: cool block with several social icons. Certainly useful later! --}}
                {{--<div class="clearfix">--}}
                    {{--<ul class="social-line list-inline">--}}
                        {{--<li>--}}
                            {{--<a href="#" class="twitter"><i class="fa fa-twitter"></i></a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="#" class="dribbble"><i class="fa fa-dribbble"></i></a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="#" class="facebook"><i class="fa fa-facebook"></i></a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="#" class="google"><i class="fa fa-google-plus"></i></a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="#" class="instagram"><i class="fa fa-instagram"></i></a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="#" class="pinterest"><i class="fa fa-pinterest"></i></a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="#" class="skype"><i class="fa fa-skype"></i></a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</div>--}}
                <span class="copyright">
                    <?=_('Discover amazing events on Konato')?> &copy; <?=date('Y')?>
                    <span>
                        <?=sprintf(_('%sHard work (and poutine!)%s made this real @ Rio de Janeiro'),
                            '<a href="https://about.me/igorsantos07" target="_blank">', '</a>') ?>
                        <img src="/img/sugar-loaf-icon.png" title="<?=_('Mavelous City, place of the Sugar Loaf')?>">
                    </span>
                </span>
            </div>
        </div>
    </footer>
    <!-- /FOOTER -->

    <div class="to-top"><?=_('Go to top')?> <i class="fa fa-angle-up"></i></div>


</div>
<!-- Popup: Login -->
<div class="modal fade login-register" id="popup-login" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" id="main-slider">
        <button type="button" class="close close-btn" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>

        <div class="form-background">
            <div class="col-sm-6 popup-form">
                <div class="form-header color">
                    <h1 class="section-title">
                        <span class="icon-inner"><span class="fa-stack"><i class="fa rhex fa-stack-2x"></i><i class="fa fa-ticket fa-stack-1x"></i></span></span>
                        <span class="title-inner">Login</span>
                    </h1>
                </div>
                <form method="post" action="#" class="registration-form alt" name="registration-form-alt" id="registration-form-alt">
                    <div class="row">
                        <div class="col-sm-12 form-alert"></div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="text" placeholder="User Name" title="" data-toggle="tooltip" class="form-control input-name" data-original-title="Name is required">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="text" placeholder="Password" title="" data-toggle="tooltip" class="form-control input-password" data-original-title="Password">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="text-center">
                                <button type="submit" class="btn btn-theme btn-block submit-button" data-animation-delay="100" data-animation="flipInY"> Log in
                                    <i class="fa fa-arrow-circle-right"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="form-footer color">
                    <a href="#" class="popup-password"> Lost your password?</a>
                </div>
            </div>

            <div class="popup-form col-sm-6">
                <div class="form-header color">
                    <h1 class="section-title">
                        <span class="icon-inner"><span class="fa-stack"><i class="fa rhex fa-stack-2x"></i><i class="fa fa-ticket fa-stack-1x"></i></span></span>
                        <span class="title-inner">Register</span>
                    </h1>
                </div>
                <form method="post" action="#" class="registration-form alt" name="registration-form-alt" id="registration-form-alt">
                    <div class="row">
                        <div class="col-sm-12 form-alert"></div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="text" placeholder="User Name" title="" data-toggle="tooltip" class="form-control input-name" data-original-title="Name is required">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="text" placeholder="E-mail" title="" data-toggle="tooltip" class="form-control input-password" data-original-title="Password">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="text-center">
                                <button type="submit" class="btn btn-theme btn-block submit-button" data-animation-delay="100" data-animation="flipInY"> Register Now
                                    <i class="fa fa-arrow-circle-right"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

</div>
<!-- /Popup: Login -->


</div>
<!-- /Wrap all content -->

<!-- JS Global -->

<?php
    const JQUERY_VERSION = '2.1.4';
    const JQUERY_COMPAT_VERSION = '1.11.3';
?>
@if($prod)
    <!--[if lt IE 9]>
<script src="//code.jquery.com/jquery-{{ JQUERY_COMPAT_VERSION }}.min.js"></script><![endif]-->
<!--[if gte IE 9]><!-->
<script src="//code.jquery.com/jquery-{{ JQUERY_VERSION }}.min.js"></script>
<!--<![endif]-->
@else
    <!--[if lt IE 9]>
<script src="/js/jquery-{{ JQUERY_COMPAT_VERSION }}.js"></script><![endif]-->
<!--[if gte IE 9]><!-->
<script src="/js/jquery-{{ JQUERY_VERSION }}.js"></script>
<!--<![endif]-->
@endif

<script src="assets/plugins/modernizr.custom.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script src="assets/plugins/superfish/js/superfish.js"></script>
<script src="assets/plugins/prettyphoto/js/jquery.prettyPhoto.js"></script>
<script src="assets/plugins/placeholdem.min.js"></script>
<script src="assets/plugins/jquery.smoothscroll.min.js"></script>
<script src="assets/plugins/jquery.easing.min.js"></script>
<script src="assets/plugins/smooth-scrollbar.min.js"></script>

<!-- JS Page Level -->
{{--<script src="assets/plugins/owlcarousel2/owl.carousel.min.js"></script>--}}
<script src="assets/plugins/waypoints/waypoints.min.js"></script>
<script src="assets/plugins/countdown/jquery.plugin.min.js"></script>
<script src="assets/plugins/countdown/jquery.countdown.min.js"></script>
<script src="assets/plugins/isotope/jquery.isotope.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false"></script>

<script src="assets/js/theme-ajax-mail.js"></script>
<script src="assets/js/theme.js"></script>
<script src="assets/js/custom.js"></script>

<script type="text/javascript">
    "use strict";
    jQuery(document).ready(function () {
        theme.init();
//        theme.initMainSlider();
        theme.initCountDown();
//        theme.initPartnerSlider();
//        theme.initTestimonials();
//        theme.initCorouselSlider4();
//        theme.initCorouselSlider3();
        theme.initGoogleMap();
    });
    jQuery(window).load(function () {
        theme.initAnimation();
    });

    jQuery(window).load(function () {
        jQuery('body').scrollspy({offset: 100, target: '.navigation'});
    });
    jQuery(window).load(function () {
        jQuery('body').scrollspy('refresh');
    });
    jQuery(window).resize(function () {
        jQuery('body').scrollspy('refresh');
    });

    jQuery(document).ready(function () {
        theme.onResize();
    });
    jQuery(window).load(function () {
        theme.onResize();
    });
    jQuery(window).resize(function () {
        theme.onResize();
    });

    jQuery(window).load(function () {
        if (location.hash != '') {
            var hash = '#' + window.location.hash.substr(1);
            if (hash.length) {
                jQuery('html,body').delay(0).animate({
                    scrollTop: jQuery(hash).offset().top - 44 + 'px'
                }, {
                    duration: 1200,
                    easing  : "easeInOutExpo"
                });
            }
        }
    });
</script>

@yield('js')

</body>
</html>
