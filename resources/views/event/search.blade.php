@extends('layout-master')
@section('title' , "\"$query\" events search")

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

@section('css')
    <style type="text/css">
        #paid_select .text-left   { padding-right: 0; }
        #paid_select .text-center { padding: 0; }
        #paid_select .text-right  { padding-left: 0; }
        #list-view .thumbnails.events .caption-title {
            margin-bottom: 5px;
        }
        #list-view .thumbnails.events .caption-category {
            line-height: 22px;
            margin-bottom: 10px;
        }
    </style>
@endsection

@section('content')
    {{-- TIP: here was a big page title with breadcrumbs --}}

    <?php
        //FIXME: forcing gettext to find those strings, that are used inside blade code
        _('Search terms'); _('Event type'); _('Free'); _('Both'); _('Paid'); _('Theme'); _('Date'); _('Begin'); _('End');
    ?>
    <section class="page-section with-sidebar sidebar-right first-section">
        <div class="container">

            <aside id="sidebar" class="sidebar col-sm-4 col-md-3">

                <div class="widget google-map-widget">
                    <div class="google-map1">
                        <div id="map-canvas1"></div>
                        <!-- TODO: get user location through the IP to customize location search. we might ask for JS location to improve further queries -->
                    </div>
                    <a href="#" class="link"><i class="fa fa-compass"></i> Rio de Janeiro, Brazil</a>
                </div>

                <div class="widget">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <?php //TODO add to free/paid text a behaviour to change the range when clicked (as labels for checkboxes)?>
                        @include('components.accordion_panel', [
                            'title' => _('Search terms'),
                            'open'  => true,
                            'field'      => $query,
                            'field_attr' => [
                                'name'  => 'q',
                                'type'  => 'search',
                                'class' => 'form-control'
                            ]])

                        @include('components.accordion_panel', [
                            'title'     => _('Event type'),
                            'open'      => true,
                            'checklist' => [$types, $selected_types],
                            'name'      => 'type',
                            'field'       => $paid,
                            'field_attr'  => [
                                'type' => 'range',
                                'min'  => -1,
                                'max'  => 1
                            ],
                            'content' => '
                                <div class="row" id="paid_select">
                                    <div class="col-xs-4 text-left">  '._('Free').'</div>
                                    <div class="col-xs-4 text-center">'._('Both').'</div>
                                    <div class="col-xs-4 text-right"> '._('Paid').'</div>
                                </div>'])

                        @include('components.accordion_panel', ['title' => _('Theme'),
                            'name'      => 'theme',
                            'checklist' => [$themes, $selected_themes],
                            'checklist_buttons' => true])

                        @include('components.accordion_panel', ['title' => _('Date'),
                            'content' => '
                                <label>'._('Begin').': <input type="date" class="form-control" name="begin"></label>
                                <label>'._('End').':   <input type="date" class="form-control" name="end">  </label>
                            '])
                    </div>
                </div>

            </aside>

            <hr class="page-divider transparent visible-xs"/>

            <section id="content" class="content col-sm-8 col-md-9">

                <div class="listing-meta">

                    <div class="filters">
                        @foreach ($themes as $id => $theme)
                            @if (in_array($id, $selected_themes))
                                <a href="#">{{$theme}} <i class="fa fa-times"></i></a>
                            @endif
                        @endforeach
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
                                            <h3 class="caption-title"><a href="<?=$link?>"><?=$title?></a></h3>

                                            <p class="caption-category">
                                                <i class="fa fa-calendar"></i>
                                                <?=date($date_fmt, $begin)?> <?=($end)? ' ~ '.date($date_fmt, $end) : '' ?>
                                                <br/>
                                                <i class="fa fa-map-marker"></i> <?=$place?>
                                            </p>

                                            {{--<p class="caption-price">Tickets from $49,99</p>--}}
                                            <p class="caption-text"><?=partial_text($desc, 35)?></p>
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