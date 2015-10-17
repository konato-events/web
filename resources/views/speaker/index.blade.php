<?php
/** @var string $theme */
/** @var array $speakers */

$theme = $theme ?? null;
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
@section('header-bg', '/img/theme-sample1.jpg')
@section('header-breadcrumbs')
    @if ($theme)
        <ul class="breadcrumb">
            <li><a href="#">IT (Information Technologies)</a></li>
            <li><a href="#">Languages</a></li>
            <li><a href="<?=act('event@theme', slugify(1, $theme))?>"><?=$theme?></a></li>
            <li class="active"><?=_('Speakers')?></li>
        </ul>
    @endif
@endsection

@section('content')
<section class="page-section with-sidebar first-section">
    <div class="container-fluid">
        <div class="row">
            <aside id="sidebar" class="sidebar col-sm-4 col-md-3">
                <div class="widget">
                    <div class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title"><?=$theme? _('Related themes') : _('Most common themes')?></h4>
                            </div>
                            <div class="panel-body">
                                @include('components.themes_list', [ 'link_speakers' => true ])
                            </div>
                        </div>
                    </div>
                </div>
            </aside>

            <hr class="page-divider small transparent visible-xs"/>

            <section id="content" class="content col-sm-8 col-md-9">

                {{-- TIP: Here was a line with selected tags that could be removed, and relevante/date filters --}}

                <div class="tab-content">
                    <div id="grid-view"  class="tab-pane fade active in" role="tabpanel">
                        <div class="row thumbnails events">

                            <?php foreach($speakers as $speaker):
                                list($img, $name, $place, $themes, $on_theme, $total, $bio) = $speaker ?>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 isotope-item festival">
                                    <div class="thumbnail no-border no-padding">
                                        <div class="media">
                                            <a href="#" class="like"><i class="fa fa-heart-o"></i></a>
                                            <img src="<?=$img?>" alt="<?=_r('%s on Konato', $name)?>">
                                        </div>
                                        <div class="caption">
                                            <h3 class="caption-title">
                                                <a href="#"><?=$name?></a>
                                            </h3>
                                            <div class="caption-category">
                                                <i class="fa fa-map-marker"></i> <?=$place?> <br>
                                                @include('components.themes_list')
                                            </div>
                                            {{--<p class="caption-price">Tickets from $49,99</p>--}}
                                            <p class="caption-text"><?=$bio?></p>
                                            <p class="caption-more"><a href="#" class="btn btn-theme">See full profile</a></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>

                        </div>

                        <!-- Pagination -->
                        <div class="pagination-wrapper">
                            <ul class="pagination">
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
        </div>
    </div>
</section>

@endsection
