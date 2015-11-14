<?
use App\Http\Controllers\UserController as Controller;
use App\Models\User;

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
$female    = ($user->gender == 'F');
$pronoun   = $female? _('she') : _('he');

$participation = [];
$stats = [];
foreach ($participations as $part => $xxx) {
    $stats[$part] = 0;
}
foreach ($events as $ev_id => $event) {
    $participation[$ev_id] = array_rand($participations);
    ++$stats[$participation[$ev_id]];
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
        <? $pic_help = str_contains($user->picture, 'gravatar')? _r('%s still don\'t have a picture :(', ucfirst($pronoun)) : '' ?>
        <img src="<?=$user->picture?>" alt="<?=_r('%s on Konato', $user->name)?>"
             <? if ($pic_help): ?>data-toggle="tooltip" title="<?=$pic_help?>"<? endif ?> />
    </div>

    <?//TODO: this height should be defined though JS, so we can save network trips inside the server ?>
    <div class="details col-md-8 col-sm-8 col-xs-12" style="height: <?=$avatar_height?>px">

        <h1><?=$user->name?></h1>

        <? if($user->location): ?>
            <a class="place" href="<?=act('event@search', ['place' => $user->location->name])?>">
                <?=nbsp($user->location->name)?>
            </a>
        <? endif ?>

        <? if (!$user->tagline && !$user->bio): ?>
            <p class="mistery">
                <i class="fa fa-user-secret"></i>
                <span><?=_('There\'s nothing to say about this user...<br/> He prefers to keep an air of mistery about him, I guess.')?></span>
            </p>
        <? endif ?>

        <p class="function">
            <? if($type == Controller::TYPE_SPEAKER): ?>
                <i class="fa part-speaker inverted" data-toggle="tooltip"
                   title="<?=_r('%s has participated in events as a speaker', ucfirst($pronoun))?>"></i>
            <? endif ?>
            <?=$user->tagline?>
        </p>

        <p class="bio"><?=$user->bio?></p>

        <? if (sizeof($user->links)): ?>
            <div class="social-profiles float-bottom">
                <h2><?=($female)? _('Her elsewhere:') : _('Him elsewhere:')?></h2>
                <? foreach($user->links as $link): ?>
                    <a class="<?=$link->network->icon?>" target="_blank" href="<?=$link->url?>" title="<?=$link->network->name?>"
                       data-toggle="tooltip" data-trigger="hover focus click" data-placement="top"></a>
                <? endforeach ?>
            </div>
        <? endif ?>
    </div>
</div>
@endsection

@section('content')
<section class="page-section with-sidebar first-section">
<div class="container-fluid">
    <section id="content" class="content col-sm-8 col-md-9">
        <ul class="user-stats">
            <? foreach($stats as $st_id => $stat): ?>
                <li class="part-{{$st_id}}">
                    <i class="fa"></i>
                    {{$stat}}x {{$participations[$st_id]}}
                </li>
            <? endforeach ?>
        </ul>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h2 class="panel-title"><?=($female)? _('Her in events') : _('Him in events')?></h2>
            </div>
            <div id="grid-view" class="panel-body">
                <div class="thumbnails events">
                    <div class="container-fluid">
                        <div class="row">
                            @foreach($events as $ev_id => $event)
                                @include('event._event_block', array_merge(compact('date_fmt', 'id', 'event'), [
                                    'compact'     => true,
                                    'participant' => $participation[$ev_id],
                                    'participant_gender' => $user->gender
                                ]))
                                @if (($ev_id + 1) % 2 == 0)
                                    </div><div class="row">
                                @endif
                            @endforeach <? //TODO: use a forelse instead, this needs an empty clause ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr class="page-divider transparent visible-xs"/>

    <aside id="sidebar-info" class="sidebar col-sm-4 col-md-3">
        <? if (!$myself): ?>
        <!-- related to #92, #93
        <div class="widget widget-sm">
            <button class="btn btn-theme btn-wrap btn-sm">
                <i class="fa fa-user-plus"></i> <?=_('Add as a connection')?>
            </button>
            <a class="note" href="#"><?=_('See my connections')?></a>
        </div>
        -->

            <div class="widget widget-sm">
                <? if (\Auth::user()->follows()->where('user_id', $id)->count()): ?>
                    <a href="<?=act('user@unfollow', $id)?>" class="btn btn-theme btn-wrap btn-sm">
                        <i class="fa fa-chain-broken"></i> <?=($female)? _('Unfollow her') : _('Unfollow him')?>
                    </a>
                <? else: ?>
                    <a href="<?=act('user@follow', $id)?>" class="btn btn-theme btn-wrap btn-sm">
                        <i class="fa fa-chain"></i> <?=($female)? _('Follow her') : _('Follow him')?>
                    </a>
                <? endif ?>
                <!-- related to #94
                <a class="note" href="#"><?=_('See my following preferences')?></a>
                -->
            </div>
        <? endif ?>

        <div class="widget">
            <div class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><?=($female)? _('Her themes of interest') : _('His themes of interest')?></h4>
                    </div>
                    <div class="panel-body">
                        <? //TODO: display here even themes that there was no talk on it; sort by number of talks given ?>
                        @include('components.themes_list', ['speaker' => ($type == Controller::TYPE_SPEAKER), 'gender' => $user->gender])
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><?=_('Most visited places')?></h4>
                    </div>
                    <div class="panel-body">
                        <ul>
                            <? foreach(['Rio de Janeiro, Brazil','São Paulo, Brazil','Halifax, Canada'] as $place):?>
                                <li><a href="<?=act('event@search', ['place' => $place])?>"><?=$place?></a></li>
                            <? endforeach ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </aside>
</div>
</section>
@endsection
