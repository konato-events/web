<?php
/** @var string $name_slug */
/** @var int    $id */
/** @var array  $speakers */

//$speaker = array_filter($speakers, function($speaker) use ($name_slug) {
//    return str_slug($speaker[1]) == $name_slug;
//})[0];
$speaker = $speakers[1];
list($img, $name, $place, $themes, $on_theme, $total, $bio) = $speaker;
$title      = sprintf(_('%s - speaker'), $name);
$function   = 'Web developer at InEvent; Student at Estácio de Sá';

$img_height = getimagesize(APP_ROOT.'/public/'.$img)[1];
$img_height = $img_height > 250? 250 : $img_height;
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
            <div class="photo col-md-4">
                <img src="<?=$img?>" alt="<?=_r('%s on Konato', $name)?>" />
            </div>

            <div class="details col-md-8" style="height: <?=$img_height?>px">
                <h1><?=$name?></h1>
                <p class="function"><?=$function?></p>
                <p class="bio"><?=$bio?></p>
                <div class="social-profiles">
                    <h2><?=_('Him elsewhere:')?></h2><?php //TODO: fix sex here! ?>
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
                    <a class="<?=$class?>" target="_blank" href="#" data-toggle="tooltip" data-trigger="hover focus click" data-placement="bottom" title="<?=$profile?>"></a>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
@endsection

@section('content')
    
@endsection
