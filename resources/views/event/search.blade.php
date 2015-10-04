@extends('layout-master')
@section('title' , "Events search: \"$query\"")

@section('js')
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

@section('content')
    {{-- TIP: here was a big page title with breadcrumbs --}}

    <section class="page-section with-sidebar sidebar-right first-section">
        <div class="container">

            <aside id="sidebar" class="sidebar col-sm-4 col-md-3">

                <div class="widget google-map-widget">
                    <div class="google-map1">
                        <div id="map-canvas1"></div>
                        <!-- TODO: get user location through the IP to customize location search. we might ask for JS location to improve further queries -->
                    </div>
                    <a href="#" class="link"><i class="fa fa-map-marker"></i> ISTANBUL, TURKEY</a>
                </div>

                <div class="widget">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        Category
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <p>Fusce pellentesque velvitae tincidunt egestas. Pellentesque habitant morbi.Proin gravida nibh vel velit auctor aliquet.</p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingTwo">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Event Type
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-body">
                                    <p>Fusce pellentesque velvitae tincidunt egestas. Pellentesque habitant morbi.Proin gravida nibh vel velit auctor aliquet.</p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingThree">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Date
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                <div class="panel-body">
                                    <p>Fusce pellentesque velvitae tincidunt egestas. Pellentesque habitant morbi.Proin gravida nibh vel velit auctor aliquet.</p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingFour">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                        Price
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                                <div class="panel-body">
                                    <p>Fusce pellentesque velvitae tincidunt egestas. Pellentesque habitant morbi.Proin gravida nibh vel velit auctor aliquet.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </aside>

            <hr class="page-divider transparent visible-xs"/>

            <section id="content" class="content col-sm-8 col-md-9">

                <div class="listing-meta">

                    <div class="filters">
                        <a href="#">Business <i class="fa fa-times"></i></a>
                        <a href="#">Networking <i class="fa fa-times"></i></a>
                        <a href="#">Free <i class="fa fa-times"></i></a>
                    </div>

                    <div class="options">
                        <a class="byrevelance" href="#"><?=_('Relevance')?></a>
                        <a class="bydate active" href="#"><?=_('Date')?></a>
                    </div>

                </div>

                <div class="tab-content">
                    <div id="list-view" class="tab-pane fade active in" role="tabpanel">
                        <div class="thumbnails events vertical">

                            <?php
                                $date_fmt = _('d/m/Y');
                                foreach($events as $id => $event):
                                    list($img, $title, $place, $begin, $end, $desc) = $event;
                                    $slug = \Illuminate\Support\Str::slug($title);
                                    $link = action('EventController@getDetails', ["$id-$slug"]);
                            ?>
                            <div class="thumbnail no-border no-padding">
                                <div class="row">
                                    <div class="col-md-3 col-sm-3 col-xs-4">
                                        <div class="media">
                                            <a href="<?=$link?>">
                                                <img src="<?=$img?>" alt="<?=$title?>"><!-- TODO: adding a link to this image wont work -->
                                            </a>

                                            <a href="#" class="like"><i class="fa fa-heart"></i></a>
                                            {{--<a href="#" class="like"><i class="fa fa-heart-o"></i></a>--}}
                                        </div>
                                    </div>
                                    <div class="col-md-9 col-sm-9 col-xs-8">
                                        <div class="caption">
                                            {{-- TIP: this is a share button... for what exactly? --}}
                                            {{--<a href="#" class="pull-right">--}}
                                                {{--<span class="fa-stack fa-lg">--}}
                                                    {{--<i class="fa fa-stack-2x fa-circle-thin"></i>--}}
                                                    {{--<i class="fa fa-stack-1x fa-share-alt"></i>--}}
                                                {{--</span>--}}
                                            {{--</a>--}}
                                            <h3 class="caption-title">
                                                <a href="<?=$link?>"><?=$title?></a>
                                            </h3>
                                            <p class="caption-category">
                                                <i class="fa fa-file-text-o"></i>
                                                <?=date($date_fmt, $begin)?>
                                                <?php if ($end) echo ' ~ '.date($date_fmt, $end) ?>
                                                - <?=$place?>
                                            </p>
                                            {{--<p class="caption-price">Tickets from $49,99</p>--}}
                                            <p class="caption-text"><?=$desc?>></p>
                                            <p class="caption-more">
                                                <a href="#" class="btn btn-theme"><?=_('See more details')?></a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="page-divider half"/>
                            <?php endforeach ?>
                        </div>

                        <!-- Pagination -->
                        <div class="pagination-wrapper">
                            <ul class="pagination">
                                <!-- TODO: improve styling for disabled buttons -->
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
            <!-- /Content -->

        </div>
    </section>
@endsection