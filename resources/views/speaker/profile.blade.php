<?php
/** @var string $name_slug */
/** @var int    $id */
/** @var array  $speakers */

const PART_ATTEND   = 1;
const PART_INVOLVED = 2;
const PART_SPOKE    = 3;
const PART_STAFF    = 4;

$speaker = current(array_filter($speakers, function($speaker) use ($name_slug) {
    return str_slug($speaker[1]) == $name_slug;
}));
list($img, $name, $place, $spk_themes, $on_theme, $total, $bio, $gender) = $speaker;
$male       = $gender == 'M';

$title      = sprintf(_('%s - speaker'), $name);
$function   = 'Web developer at InEvent; Student at Estácio de Sá';

$img_height = getimagesize(APP_ROOT.'/public/'.$img)[1];
$img_height = ($img_height > 250? 250 : $img_height);
$date_fmt   = _('d/m/Y');
?>
@extends('layout-header')
@section('title', $title)

@section('js')
    {{--<script src="assets/plugins/owlcarousel2/owl.carousel.min.js"></script>--}}
    <script src="/assets/plugins/waypoints/waypoints.min.js"></script>
    <script src="/assets/plugins/countdown/jquery.plugin.min.js"></script>
    {{--<script src="/assets/plugins/countdown/jquery.countdown.min.js"></script>--}}
    <script src="/assets/plugins/isotope/jquery.isotope.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>

    <script src="/assets/js/theme.js"></script>
    <script src="/assets/js/custom.js"></script>

    <script type="text/javascript">
        "use strict";

        $('[data-toggle=tooltip]').tooltip();

        jQuery(document).ready(function () {
            theme.init();
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

@section('header-bg', '/img/bg-speaker.jpeg')
@section('header-content')
        <div class="row">
            <div class="photo col-md-4 col-sm-4 col-sm-offset-0 col-xs-4 col-xs-offset-4">
                <img src="<?=$img?>" alt="<?=_r('%s on Konato', $name)?>" />
            </div>

            <div class="details col-md-8 col-sm-8 col-xs-12" style="height: <?=$img_height?>px">
                <h1><?=$name?></h1>
                <a class="place" href="<?=search_url(['place' => $place])?>"><?=nbsp($place)?></a>
                <p class="function"><?=$function?></p>
                <p class="bio"><?=$bio?></p>
                <div class="social-profiles float-bottom">
                    <h2><?=($male)? _('Him elsewhere:') : _('Her elsewhere:')?></h2>
                    <?php
                    $profiles = [
                        'LinkedIn'         => 'fa fa-linkedin-square',
                        'Facebook'         => 'fa fa-facebook-square',
                        'Twitter'          => 'fa fa-twitter-square',
                        'ResearchGate'     => 'icon-site-researchgate',
                        'Currículo Lattes' => 'icon-site-lattes',
                        'Flickr'           => 'fa fa-flickr',
                        'Behance'          => 'fa fa-behance-square',
                        'GitHub'           => 'fa fa-github-square',
                        'Bitbucket'        => 'fa fa-bitbucket-square',
                        'Speaker Deck'     => 'icon-site-speaker-deck',
                        'Slideshare'       => 'fa fa-slideshare',
                        'Website'          => 'fa fa-globe'
                    ];
                    foreach($profiles as $profile => $class):
                        if (is_numeric($profile)) {
                            $profile = $class;
                            $class   = str_slug($class);
                        }
                    ?>
                        <a class="<?=$class?>" target="_blank" href="#" data-toggle="tooltip" data-trigger="hover focus click" data-placement="top" title="<?=$profile?>"></a>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
@endsection

@section('content')
<section class="page-section with-sidebar first-section">
<div class="container-fluid">
    <section id="content" class="content col-sm-8 col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2 class="panel-title"><?=($male)? _('Him in events') : _('Her in events')?></h2>
            </div>
            <div id="grid-view" class="panel-body">
                <div class="thumbnails events">
                    <div class="container-fluid">
                        <div class="row">
                        @foreach($events as $id => $event)
                            @include('event._event_block', array_merge(compact('date_fmt', 'id', 'event'), [
                                'compact'     => true,
                                'participant' => rand(PART_ATTEND, PART_STAFF),
                                'participant_gender' => $gender
                            ]))
                            @if (($id+1) % 2 == 0)
                                </div><div class="row">
                            @endif
                        @endforeach <?php //TODO: use a forelse instead, this needs an empty clause ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr class="page-divider transparent visible-xs"/>

    <aside id="sidebar-info" class="sidebar col-sm-4 col-md-3">
        <div class="widget widget-sm">
            <button class="btn btn-theme btn-wrap btn-sm">
                <i class="fa fa-user-plus"></i> <?=_('Add as a connection')?>
            </button>
            <a class="note" href="#"><?=_('See my connections')?></a>
        </div>

        <div class="widget widget-sm">
            <button class="btn btn-theme btn-wrap btn-sm">
                <i class="fa fa-mail-forward"></i> <?=($male)? _('Follow him') : _('Follow her')?>
            </button>
            <a class="note" href="#"><?=_('See my following preferences')?></a>
        </div>

        <div class="widget">
            <div class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><?=($male)? _('His themes of interest') : _('Her themes of interest')?></h4>
                    </div>
                    <div class="panel-body">
                        @include('components.themes_list', [ 'link_speakers' => true ])
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><?=_('Most visited places')?></h4>
                    </div>
                    <div class="panel-body">
                        <ul>
                            <?php foreach(['Rio de Janeiro, Brazil','São Paulo, Brazil','Halifax, Canada'] as $place):?>
                                <li><a href="<?=search_url(['place' => $place])?>"><?=$place?></a></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </aside>
</div>
</section>
@endsection
