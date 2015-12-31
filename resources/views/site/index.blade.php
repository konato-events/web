<?
/** @var array $events */
/** @var array $types */
?>
@extends('layout-master')

@section('js')
    {{--<script src="assets/plugins/waypoints/waypoints.min.js"></script>--}}
    <script src="assets/plugins/countdown/jquery.plugin.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>

    <script src="assets/js/theme-ajax-mail.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/custom.js"></script>

    <script type="text/javascript">
        "use strict";
        jQuery(document).ready(function () {
            theme.init();
            theme.initGoogleMap();
        });

        jQuery(window).load(function () {
            var $body = jQuery('body');

            $body.scrollspy({offset: 100, target: '.navigation'});
            $body.scrollspy('refresh');
            theme.onResize();

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

        jQuery(window).resize(function () {
            jQuery('body').scrollspy('refresh');
            theme.onResize();
        });

        jQuery(document).ready(function () {
            theme.onResize();
        });
    </script>
@endsection

@section('content')
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
                                    <? $search_url = act('event@search'); ?>
                                    <!--?=sprintf(_('Find %sconferences%s, %stalks%s, %smeetings%s, %ssymposiums%s, %sexhibitions%s, and even %sspeakers%s'),-->
                                    <?=sprintf(_('Find %sconferences%s, %stalks%s, %smeetings%s, %ssymposiums%s, %suniversity events%s and more'),
                                    "<a href='$search_url?types[]={$types['conference']}'>",'</a>',
                                    "<a href='$search_url?types[]={$types['talks']}&types[]={$types['single talk']}'>",'</a>',
                                    "<a href='$search_url?types[]={$types['meeting']}'>",'</a>',
                                    "<a href='$search_url?types[]={$types['symposium']}'>",'</a>',
                                    "<a href='$search_url?types[]={$types['university meeting']}'>",'</a>')?>
                                </span>
                            </h4>

                            <div class="row">
                                <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                                    <form action="<?=act('event@search')?>" method="get" class="location-search">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" name="q" class="form-control text" placeholder="<?=_('Find by theme or keyword')?>" />
                                                {{--<select class="selectpicker"><option>LOCATION</option></select>--}}
                                                <button class="form-control button-search">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <p class="caption-text">
                                <!--
                                <a class="btn btn-theme btn-theme-dark scroll-to" href="#"><?=_('Popular events')?></a>
                                <a class="btn btn-theme btn-theme-light" href="#"><?=_('Latest events')?></a>
                                -->

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
                        ['#', 'map', _('Explore new meetings'), _('About: exploration'), //map-signs, map-o
                                _('Ever though <em>"Hey, I never heard of that event! How could I miss such thing?"</em> Enter <strong>Konato</strong>: it won\'t happen again!')
                        ],
                        ['#', 'users', _('Meet new people'), _('About: networking'),
                                _('Make new contacts, expand your network and meet like-minded students or professionals - not only those who live nearby.')
                        ],
                        ['#', 'calendar-check-o', _('Prepare for the event'), _('About: preparation'),
                                _('See the schedule and organize yourself. On <b>Konato</b> you\'re sure not to miss the activities of your interest.')
                        ],
                        ['#', 'bullhorn', _('Spread what you know'), _('About: knowledge'),
                                _('Reach new audiences and get close to your public - or <em>that</em> speaker from the last congress you\'ve been.')
                        ],
                    //['#', 'users', _('Find your speakers'),
                    //    _('Going to organize your own event? Get in touch with field experts and invite (or
                    //    hire) them to help you out!')
                    //]
                ];
                foreach ($thumbs as $thumb):
                    list($link, $icon, $title, $button, $desc) = $thumb;
                ?>
                <div class="col-sm-6 col-md-3">
                    <div class="thumbnail no-border no-padding text-center">
                        @include('components.rehex', compact('link', 'icon'))
                        <div class="caption">
                            <h3 class="caption-title"><a href="<?=$link?>"><?=$title?></a></h3>
                            <p class="caption-text"><?=$desc?></p>
                            <p class="caption-more">
                                <a href="<?=$link?>" class="btn btn-theme"><?=$button?></a>
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
    <!-- FIXME: hidden as we have not enough events and no pictures to be displayed here -->
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
                foreach($events as $event):
                    list($img, $title, $desc) = $event;
                    $dimensions = getimagesize(public_path($img));
                    $size_class = ($dimensions[0] > $dimensions[1])? 'larger-x' : 'larger-y';
                ?>
                    <div class="col-md-3 col-sm-6 photos">
                        <a href="#">
                            <div class="thumbnail no-border no-padding">
                                <div class="media <?=$size_class?>" style="background-image: url(<?=$img?>)">
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
    <section class="page-section no-padding-top light create-new-event">
        <div class="container text-center">
            <h1 class="section-title"><?=_('Join a growing platform of events of all types and sizes')?></h1>

            <p><?=_('<b>Konato</b> is the best place to market your event.<br>Here we bring together all sorts of people, and they can find it by their interests - this makes sure you receive the right public, and our users find exactly the type of activities they\'re looking for.')?></p>

            <div><a href="<?=act('event@submit')?>" class="btn btn-theme btn-theme-md"><?=_('Submit your event')?></a></div>
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
@endsection
