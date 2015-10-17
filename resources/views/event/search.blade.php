<?php
/** @var string $query */

//FIXME: forcing gettext to find those strings, that are used inside blade code
_('Search terms'); _('Event types'); _('Free'); _('Both'); _('Paid'); _('Theme'); _('Date'); _('Begin'); _('End');
$title = sprintf(_('"%s" events search'), $query);
?>
@extends('layout-master')
@section('title' , $title)

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
                        easing: "easeInOutExpo"
                    });
                }
            }
        });
    </script>
@endsection

@section('content')
<section class="page-section with-sidebar first-section">
    <div class="container">

        <aside id="sidebar" class="sidebar col-sm-4 col-md-3">

            <div class="widget google-map-widget">
                <div class="google-map1">
                    <div id="map-canvas1"></div>
                    <?php //TODO: get user location through the IP to customize location search. we might ask for JS location to improve further queries ?>
                </div>
                <a href="#" class="link"><i class="fa fa-compass"></i> Rio de Janeiro, Brazil</a>
            </div>

            <form class="widget">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <?php //TODO: add to free/paid text a behaviour to change the range when clicked (as labels for checkboxes)?>
                    @include('components.accordion_panel', [
                        'title' => _('Search terms'),
                        'open'  => true,
                        'field'      => $query,
                        'field_attr' => [
                            'name'   => 'q',
                            'type'   => 'search',
                            'class'  => 'form-control'
                        ]])

                    @include('components.accordion_panel', [
                        'title'      => _('Event types'),
                        'open'       => true,
                        'checklist'  => [$types, $selected_types],
                        'name'       => 'type',
                        'content' => '
                            <div class="row" id="paid_select">
                                <div class="col-xs-12">
                                    <input type="range" name="paid" min="-1" max="1" id="range_paid" value="'.$paid.'">
                                </div>
                                <label for="range_paid">
                                    <span class="col-xs-4 text-left" data-value="-1"> '._('Free').'</span>
                                    <span class="col-xs-4 text-center" data-value="0">'._('Both').'</span>
                                    <span class="col-xs-4 text-right" data-value="1"> '._('Paid').'</span>
                                </label>
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
            </form>

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
    </div>
</section>
@endsection
