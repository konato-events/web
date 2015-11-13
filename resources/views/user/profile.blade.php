<?php
use App\Http\Controllers\UserController as Controller;
use App\Models\User;

/** @var string $user->name_slug */
/** @var int    $id */
/** @var array  $speakers */
/** @var array  $events */
/** @var User   $user */
/** @var int    $type */

$participations = [
    User::PARTICIPANT => _('participant'),
    User::SPEAKER     => _('speaker'),
    User::INVOLVED    => _('involved'),
    User::STAFF       => _('staff')
];
if ($type != Controller::TYPE_SPEAKER) {
    unset($participations[User::SPEAKER]);
}
$male = ($user->gender == 'M');

$participation = [];
$stats = [];
foreach ($participations as $part => $xxx) {
    $stats[$part] = 0;
}
foreach ($events as $id => $event) {
    $participation[$id] = array_rand($participations);
    ++$stats[$participation[$id]];
}
$stats = array_filter($stats);

switch ($type) {
    case Controller::TYPE_SPEAKER:  $type_str = _('speaker profile'); break;
    default:
    case Controller::TYPE_USER:     $type_str = _('profile');         break;
}
$title = "$user->name - $type_str";

$avatar_height = getimagesize($user->picture)[1];
$avatar_height = ($avatar_height > 250? 250 : $avatar_height);
$date_fmt   = _('m/d/Y');
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
        <img src="<?=$user->picture?>" alt="<?=_r('%s on Konato', $user->name)?>" />
    </div>

    <?//TODO: this height should be defined though JS, so we can save network trips inside the server ?>
    <div class="details col-md-8 col-sm-8 col-xs-12" style="height: <?=$avatar_height?>px">

        <h1><?=$user->name?></h1>

        <? if($user->location): ?>
            <a class="place" href="<?=act('event@search', ['place' => $user->location->name])?>">
                <?=nbsp($user->location->name)?>
            </a>
        <? endif ?>

        <p class="function">
            <?php if($type == Controller::TYPE_SPEAKER): ?>
                <i class="fa part-speaker inverted" data-toggle="tooltip"
                   title="<?=ucfirst(_r('%s has participated in events as a speaker', $male? _('he') : _('she')))?>"></i>
            <?php endif ?>
            <?=$user->tagline?>
        </p>
        <p class="bio"><?=$user->bio?></p>
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
        <ul class="user-stats">
            <?php foreach($stats as $id => $stat): ?>
                <li class="part-{{$id}}">
                    <i class="fa"></i>
                    {{$stat}}x {{$participations[$id]}}
                </li>
            <?php endforeach ?>
        </ul>

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
                                    'participant' => $participation[$id],
                                    'participant_gender' => $user->gender
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
                        <?php //TODO: display here even themes that there was no talk on it; sort by number of talks given ?>
                        @include('components.themes_list', ['speaker' => ($type == Controller::TYPE_SPEAKER), 'gender' => $user->gender])
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><?=_('Most visited places')?></h4>
                    </div>
                    <div class="panel-body">
                        <ul>
                            <?php foreach(['Rio de Janeiro, Brazil','São Paulo, Brazil','Halifax, Canada'] as $place):?>
                                <li><a href="<?=act('event@search', ['place' => $place])?>"><?=$place?></a></li>
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
