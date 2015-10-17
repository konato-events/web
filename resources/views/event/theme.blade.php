<?php
/** @var string   $theme
  * @var int      $paid
  * @var string[] $types
  * @var int[]    $selected_types */
use Illuminate\Support\Str;

$title = sprintf(_('Events about %s'), $theme);
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
                        easing: "easeInOutExpo"
                    });
                }
            }
        });
    </script>
@endsection

@section('header-title', $theme)
@section('header-bg', '/img/theme-sample1.jpg')
@section('header-breadcrumbs')
    @if ($theme)
        <ul class="breadcrumb">
            <li><a href="#">IT (Information Technologies)</a></li>
            <li><a href="#">Languages</a></li>
            <li class="active">{{$theme}}</li>
        </ul>
    @endif
@endsection

@section('content')
<section class="page-section with-sidebar first-section">
    <div class="container-fluid">
        <div class="row">
            <aside id="sidebar" class="sidebar col-md-3">

                <form class="widget">
                    <div class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title"><?=_('Event types')?></h4>
                            </div>
                            <div class="panel-body">
                                <div class="checkbox">
                                    <?php foreach($types as $id => $value):
                                    $check = in_array($id, $selected_types); ?>
                                    <label>
                                        <input type="checkbox" name="theme" value="{{$id}}" <?=$check? 'checked':''?>> {{$value}}
                                    </label>
                                    <?php endforeach ?>
                                </div>

                                <div class="row" id="paid_select">
                                    <div class="col-xs-12">
                                        <input type="range" min="-1" max="1" value="<?=$paid?>">
                                    </div>
                                    <div class="col-xs-4 text-left">  <?=_('Free')?></div>
                                    <div class="col-xs-4 text-center"><?=_('Both')?></div>
                                    <div class="col-xs-4 text-right"> <?=_('Paid')?></div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title"><?=_('Related themes')?></h4>
                            </div>
                            <div class="panel-body">
                                <ul class="themes">
                                    @foreach($themes as $id => $name)
                                        <li><a href="{{act('event@theme', "$id-".Str::slug($name))}}">{{$name}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </form>

            </aside>

            <hr class="page-divider transparent visible-xs">

            <section id="content" class="content col-md-6">

                <div class="listing-meta">

                    <div class="options">
                        <a class="byrevelance" href="#"><?=_('Relevance')?></a>
                        <a class="bydate active" href="#"><?=_('Date')?></a>
                    </div>

                </div>

                <?php //TODO: see if this block is repeatable enough to become a component as well ?>
                <div class="tab-content">
                    <div id="list-view" class="tab-pane fade active in" role="tabpanel">
                        <div class="thumbnails events vertical">
                            <?php $date_fmt = _('d/m/Y') ?>
                            @foreach($events as $id => $event)
                                @include('event._event_block', compact('date_fmt', 'id', 'event'))
                                <hr class="page-divider half"/>
                                <?php //TODO: use a forelse instead, this needs an empty clause ?>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="pagination-wrapper">
                            <ul class="pagination">
                                <?php //TODO: improve styling for disabled buttons ?>
                                <li class="disabled"><a href="#"><i class="fa fa-chevron-left"></i></a></li>
                                <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#"><i class="fa fa-chevron-right"></i></a></li>
                            </ul>
                        </div>
                        <!-- /Pagination -->
                    </div>
                </div>
            </section>

            <hr class="page-divider transparent visible-xs"/>

            <aside id="sidebar-info" class="sidebar col-md-3">

                <div class="widget">
                    <div class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <button class="btn btn-theme btn-wrap">
                                    <i class="fa fa-mail-forward"></i>
                                    <?=_('Follow this theme')?>
                                </button>
                                    <a class="note" href="#"><?=_('See your following preferences')?></a>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title"><?=_('Popularity')?></h4>
                            </div>
                            <div class="widget google-map-widget">
                                <div class="google-map1">
                                    <div id="map-canvas1"></div>
                                </div>
                            </div>
                        </div>

                        @if ($speakers)
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><?=_('Popular speakers')?></h4>
                                </div>
                                <div class="panel-body">
                                    <ul class="speakers">
                                        @foreach ($speakers as $speaker)
                                            <li>
                                                <img src="{{$speaker[0]}}" alt="{{$speaker[1]}} <?=_('on Konato')?>" />
                                                <div class="speaker-details">
                                                    <a href="#">{{$speaker[1]}}</a>
                                                    <span><?=__('%d event on theme', '%d events on theme', $speaker[2])?></span>
                                                    <span><?=__('%d event total', '%d events total', $speaker[3])?></span>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <a href="{{act('speaker@theme', '1-'.Str::slug($theme))}}" class="see-more"><?=_r('See all speakers on %s', $theme)?></a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </aside>
        </div>
    </div>
</section>
@endsection
