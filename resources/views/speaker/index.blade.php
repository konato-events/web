<?php
/** @var string $theme */
use Illuminate\Support\Str;

$title = $theme? _r('Speakers on %s', $theme) : _('Speakers on your themes of interest');
?>
@extends('layout-header')
@section('title', $title)

@section('js')
    {{--<script src="assets/plugins/owlcarousel2/owl.carousel.min.js"></script>--}}
    <script src="/assets/plugins/waypoints/waypoints.min.js"></script>
    <script src="/assets/plugins/countdown/jquery.plugin.min.js"></script>
    <script src="/assets/plugins/countdown/jquery.countdown.min.js"></script>
    <script src="/assets/plugins/isotope/jquery.isotope.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>

    <script src="/assets/js/theme.js"></script>
    <script src="/assets/js/custom.js"></script>

    <script type="text/javascript">
        "use strict";
        jQuery(document).ready(function () {
            theme.init();
            theme.initMainSlider();
            theme.initCountDown();
            theme.initPartnerSlider2();
            theme.initImageCarousel();
            theme.initTestimonials();
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
@endsection

@section('header-title', $title)
@section('header-breadcrumbs')
    @if ($theme)
        <ul class="breadcrumb">
            <li><a href="#">IT (Information Technologies)</a></li>
            <li><a href="#">Languages</a></li>
            <li><a href="#">{{$theme}}</a></li>
            <li class="active"><?=_('Speakers')?></li>
        </ul>
    @endif
@endsection

@section('content')
<section class="page-section with-sidebar first-section">
    <div class="container-fluid">
        <div class="row">
            <aside id="sidebar" class="sidebar col-md-3">
                <div class="widget">
                    <div class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title"><?=$theme? _('Preferred themes') : _('Most common themes')?></h4>
                            </div>
                            <div class="panel-body">
                                <ul class="themes">
                                    @foreach($themes as $id => $t)
                                        <li><a href="{{act('event@theme'), "$id-".Str::slug($t)}}">{{$t}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
