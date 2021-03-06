<?php
/** @var string $query */
/** @var array $types */

//FIXME: forcing gettext to find those strings, that are used inside blade code
_('Search terms'); _('Event types'); _('Free'); _('Both'); _('Paid'); _('Theme'); _('Date'); _('Begin'); _('End');
$title = sprintf(_('"%s" events search'), $query); //FIXME: fix title, given not always we will have a $query!
?>
@extends('layout-master')
@section('title', $title)

@section('js')
    <script type="text/javascript">
        "use strict";
        jQuery(document).ready(function () {
            theme.init();
//            theme.initGoogleMap();
        });

        jQuery(window).load(function () {
            var $body = jQuery('body');

            $body.scrollspy({offset: 100, target: '.navigation'});
            $body.scrollspy('refresh');

            if (location.hash != '') {
                var hash = '#' + window.location.hash.substr(1);
                if (hash.length) {
                    jQuery('html,body').delay(0).animate({
                        scrollTop: jQuery(hash).offset().top - 55 + 'px'
                    });
                }
            }
        });

        jQuery(window).resize(function () {
            jQuery('body').scrollspy('refresh');
        });
    </script>
@endsection

@section('content')
<section class="page-section with-sidebar first-section">
    <div class="container">

        <aside id="sidebar" class="sidebar col-sm-4 col-md-3">
        <form method="get" action="<?=act('event@search')?>">

            <? /*
            <div class="widget google-map-widget">
                <div class="google-map1">
                    <div id="map-canvas1"></div>
                    <?php //TODO: get user location through the IP to customize location search. we might ask for JS location to improve further queries ?>
                </div>
                <span class="link form-group">
                    <span class="input-group">
                        <label for="place_field" class="input-group-addon"><i class="fa fa-compass"></i></label>
                        <input type="text" name="place" id="place_field" class="form-control" value="{{$place}}" />
                    </span>
                </span>
            </div>
            */?>

            <div class="widget">
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

                    <?php //TODO: take a look at the categories list from the blog page and see if it fits better here ?>
                    @include('components.accordion_panel', [
                        'title'      => _('Event types'),
                        'open'       => true,
                        'checklist'  => [$all_types, $types],
                        'name'       => 'types[]',
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

                    {{--@include('components.accordion_panel', ['title' => _('Theme'),--}}
                        {{--'name'      => 'theme',--}}
                        {{--'checklist' => [$themes, $selected_themes],--}}
                        {{--'checklist_buttons' => true])--}}

                    {{--@include('components.accordion_panel', ['title' => _('Date'),--}}
                        {{--'content' => '--}}
                            {{--<label>'._('Begin').': <input type="date" class="form-control" name="begin"></label>--}}
                            {{--<label>'._('End').':   <input type="date" class="form-control" name="end">  </label>--}}
                        {{--'])--}}
                </div>

                <button class="btn btn-theme btn-theme-md">
                    <i class="fa fa-search"></i> <?=_('Update search')?>
                </button>
            </div>

        </form>
        </aside>

        <hr class="page-divider transparent visible-xs"/>

        <section id="content" class="content col-sm-8 col-md-9">

            <div class="listing-meta">

                <? //TIP: here used to be some tags with an X button ?>

                <div class="options">
                    <a class="byrevelance" href="#"><?=_('Relevance')?></a>
                    <a class="bydate active" href="#"><?=_('Date')?></a>
                </div>

            </div>

            <div class="tab-content">
                <div id="list-view" class="tab-pane fade active in" role="tabpanel">
                    <div class="thumbnails events vertical">
                        <?php $date_fmt = _('m/d/Y') ?>
                        @forelse($events as $id => $event)
                            @include('event._event_block', compact('date_fmt', 'id', 'event'))
                            <hr class="page-divider half"/>
                        @empty
                            <div class="text-center empty-block">
                                <p>
                                    <i class="fa fa-calendar-o"></i>
                                    <?=_('We found no event with the criteria you gave us. Maybe you could try to be a little broader?')?>
                                </p>

                                <p><?=_('If the event really doesn\'t exist, and you know a few details, you can easily create it:')?></p>
                                <a href="<?=act('event@submit')?>" class="btn btn-theme">
                                    <i class="fa fa-calendar-plus-o"></i> <?=_('Submit a new event')?>
                                </a>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination
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
                    /Pagination -->
                </div>
            </div>
        </section>
    </div>
</section>
@endsection
