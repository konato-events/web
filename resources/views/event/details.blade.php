<?php
use App\Http\Controllers\UserController as Controller;

/** @var string $name_slug */
/** @var int    $id */
/** @var array  $events */
/** @var array  $materials */
/** @var array  $speakers */
/** @var int    $type */

$event = current(array_filter($events, function($event) use ($name_slug) {
    return str_slug($event[1], '_') == $name_slug;
}));
list($img, $name, $place, $begin, $end, $desc, $status, $url, $twitter, $hashtag) = $event;

$title   = _r('%s - event', $name);
$tagline = 'A tagline do evento vai aqui';

$img_height = getimagesize(APP_ROOT.'/public/'.$img)[1];
$img_height = ($img_height > 250? 250 : $img_height);
$date_fmt   = _('m/d/Y');
$date_fmt_lg= _('l, F j, Y');

function url_main_part(string $url):string {
    preg_match('|^https?://(www.)?([\w\.]+)/?|', $url, $parts);
    return (array_key_exists(2, $parts))? $parts[2] : $url;
}

function section_title(string $icon, string $title, string $subtitle = null):string {
    $tagline = $subtitle? "<small> | $subtitle</small>" : '';
    return <<<SECTION
<h2 class="section-title">
    <span class="icon-inner">
        <span class="fa-stack">
            <i class="fa rhex fa-stack-2x"></i>
            <i class="fa fa-$icon fa-stack-1x"></i>
        </span>
    </span>
    <span class="title-inner">$title $tagline</span>
</h2>
SECTION;
}

//TODO: cache this in memcache
//TODO: here we can include later on more information on the days, such as: do we need to display month/year, or only the day would suffice? this could be done turning the array into: ['structure' => ['show_month' => true], 'days' => [timestamps] ]
function get_days(int $begin, int $end = null):array {
    $end = $end ?? $begin;

    $begin   = new DateTime("@$begin");
    $end     = new DateTime("@$end");
    $diff    = $begin->diff($end);
    $one_day = new DateInterval('P1D');
    $days    = [];
    for($i = 1; $i <= $diff->days; $i++) {
        $days[] = $begin->add($one_day)->getTimestamp();
    }
    return $days;
}
$days = get_days($begin, $end);
$editions = [2015, 2012, 2011];

$dates_str = function(bool $compact = false) use ($begin, $end, $date_fmt):string {
    if ($compact) {
        $date_fmt = substr($date_fmt, 0, -2);
    }
    $str = date($date_fmt, $begin);
    if ($end) {
        $str .= ' ~ '.date($date_fmt, $end);
    }
    return $str;
}
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

@section('header-bg', '/img/bg-event.jpg')
@section('header-content')
    <div class="row">
        <div class="details col-md-7 col-sm-7">
            <h1><?=$name?></h1>
            <? if (false): ?>
                <span class="status" data-toggle="tooltip" title="<?=_('This is a private event - acessible only by a group of selected people')?>"><?=_('Closed')?></span>
            <? endif ?>
            <p class="date"><?=$dates_str()?></p>
            <p class="links">
                <a href="<?=$url?>"><i class="fa fa-globe"></i> <?=url_main_part($url)?></a>
                <a href="https://twitter.com/hashtag/<?=$hashtag?>"><i class="fa fa-quote-left"></i> #<?=$hashtag?></a>
                <a href="https://twitter.com/<?=$twitter?>"><i class="fa fa-twitter"></i> @<?=$twitter?></a>
                <a href="https://facebook.com/<?=$twitter?>"><i class="fa fa-facebook"></i> <?=$twitter?> </a>
            </p>
        </div>


        <div class="stats col-sm-5">
            <p><?=_r('%s&nbsp;speakers on %s&nbsp;sessions and %s&nbsp;cases', '<strong>'.rand(5,50).'</strong>', '<strong>'.rand(20,30).'</strong>', '<strong>'.rand(5,10).'</strong>')?></p>
            <p><?=_r('%s&nbsp;resumes and %s&nbsp;articles submitted', '<strong>'.rand(5,50).'</strong>', '<strong>'.rand(20,30).'</strong>')?></p>
            <hr/>
            <p><?=_r('%s&nbsp;of&nbsp;%s known participants', '<strong>'.rand(5,50), rand(20,30).'</strong>')?></p>
            <p><strong><?=rand(5,50)?></strong> <?=_('followers')?></p>
        </div>
    </div>
@endsection

@section('content')
<ul class="container nav nav-tabs nav-tabs-bottom" role="tablist">
    <a href="#"><?=_('Editions')?>:</a>
    <? foreach($editions as $i => $edition): ?>
        <li role="presentation" <? if ($i == 0): ?>class="active"<? endif ?>>
            <a role="tab" href="#"><?=$edition?></a>
        </li>
    <? endforeach ?>
</ul>

<section class="page-section with-sidebar sidebar-right first-section">
<div class="container"><div class="row">
    <section id="content" class="content col-sm-12 col-md-8 col-lg-9">

        <div class="row">
            <div class="col-md-12 col-lg-5 pull-left">
                <div>
                    <?=section_title('institution', _('The Event'), $tagline)?>
                    <p class="basic-text">{!! strtr(e($desc), ["\n" => '</p><p class="basic-text">']) !!}</p>
                </div>

                {{--<p class="btn-row">--}}
                    {{--<a href="#" class="btn btn-theme btn-theme-lg scroll-to">Register <i class="fa fa-arrow-circle-right"></i></a>--}}
                    {{--<a href="#" class="btn btn-theme btn-theme-lg btn-theme-transparent">Watch video</a>--}}
                {{--</p>--}}
            </div>

            <hr class="page-divider transparent visible-md"/>

            <div class="col-md-12 col-lg-7 pull-right">
                <?=section_title('calendar-check-o', _('Schedule'), $dates_str(true))?>
                <? if (sizeof($days > 1)): ?>
                    <ul class="nav nav-tabs" role="tablist">
                        <? foreach($days as $i => $day): ?>
                            <li role="presentation" <? if ($i == 0): ?>class="active"<? endif ?>>
                                <a data-toggle="tab" role="tab" aria-controls="day-<?=$i?>" href="#day-<?=$i?>">
                                    <?=date('d/m', $day)?>
                                </a>
                            </li>
                        <? endforeach ?>
                    </ul>
                <? endif ?>

                <div class="tab-content">
                    <? foreach ($days as $d => $day): ?>
                        <? $rooms = ['Grand Hall', 'Room A', 'Room B'] ?>
                        <div role="tabpanel" class="tab-pane fade<? if ($d == 0): ?> in active<? endif ?>" id="day-<?=$d?>">
                            <div class="panel panel-default">
                                <ul class="nav nav-pills nav-justified" role="tablist">
                                    <? foreach($rooms as $r => $room): ?>
                                        <li role="presentation" <? if ($r == 0): ?>class="active"<? endif ?>>
                                            <a data-toggle="tab" role="tab" aria-controls="room-<?="$d-$r"?>" href="#room-<?="$d-$r"?>">
                                                <?=$room?>
                                            </a>
                                        </li>
                                    <? endforeach ?>
                                </ul>

                                <div class="tab-content">
                                    <? foreach($rooms as $r => $room): ?>
                                        <div role="tabpanel" class="tab-pane fade<? if ($r == 0): ?> in active<? endif ?>" id="room-<?="$d-$r"?>">
                                        <div class="timeline">

                                            <? for($p = 1; $p <= 4; $p++): ?>
                                                <article class="post-wrap">
                                                <div class="media">

                                                    <div class="media-body">
                                                        <div class="post-header">
                                                            <div class="post-meta">
                                                                <span class="post-date">
                                                                    <i class="fa fa-clock-o"></i> 08:00 - 08:45
                                                                </span>
                                                            </div>
                                                            <h2 class="post-title"><a href="#">Speaker Content Header Is Header</a></h2>
                                                        </div>
                                                        <div class="post-body">
                                                            <div class="post-excerpt">
                                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vitae diam metus. Donec cursus magna eget sem convallis facilisis. Vestibulum dictum nibh at ullamcorper tincidunt. Phasellus scelerisque nisl non ullamcorper pellentesque. Nunc sagittis, felis in feugiat mollis, libero eros consectetur elit non cursus lacus nisl at dolor.</p>
                                                            </div>
                                                        </div>
                                                        <div class="post-footer">
                                                            <span class="post-readmore">
                                                                <? $spk = $speakers[array_rand($speakers)] ?>
                                                                <a href="<?=act('user@speaker', slugify(0, $spk[1]))?>">
                                                                    <i class="fa part-speaker"></i>
                                                                    <?=$spk[1]?> / CEO at Crown.io
                                                                </a>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                </article>
                                            <? endfor ?>
                                        </div>
                                        </div>
                                    <? endforeach ?>
                                </div>
                            </div>
                        </div>
                    <? endforeach ?>
                </div>
            </div>

            <hr class="page-divider transparent visible-md"/>

            <div class="col-md-12 col-lg-5 pull-left">
                <?=section_title('microphone', _('The speakers'))?>
                @include('components.speakers_list', ['speakers' => $speakers, 'columns' => true])
            </div>

            <hr class="page-divider transparent visible-md"/>

            <div class="col-md-12 col-lg-5 pull-left">
                <?=section_title('microphone', _('Materials'))?>
                <ul class="materials">
                    <? foreach ($materials as $material): ?>
                        <li class="<?=$material[2]?>">
                            <a href="<?=$material[0]?>" target="_blank" class="title"><?=$material[1]?></a>,
                            <?=_('by')?> <a href="<?=act('user@speaker', slugify(0, $material[3][1]))?>" class="speaker"><?=$material[3][1]?></a>
                        </li>
                    <?php endforeach ?>
                </ul>
            </div>

            {{--<hr class="page-divider transparent visible-md"/>--}}

            <!--<div class="col-md-12 col-lg-5 pull-left">
                <?=section_title('thumbs-up', _('Event sponsors'))?>
                <p class="basic-text">ADICIONAR AQUI A LISTA DE PATROCINADORES</p>
            </div>-->
        </div>

    </section>

    <hr class="page-divider transparent visible-xs"/>

    <aside id="sidebar-info" class="sidebar col-sm-12 col-md-4 col-lg-3">
        <div class="widget widget-sm">
            <button class="btn btn-theme btn-theme-light btn-wrap btn-md">
                <i class="fa fa-ticket"></i> <?=_('Buy ticket')?>
            </button>

            <button class="btn btn-theme btn-wrap btn-sm">
                <i class="fa fa-hand-o-up"></i> <?=_('I\'m going!')?>
            </button>

            <button class="btn btn-theme btn-wrap btn-sm">
                <i class="fa fa-mail-forward"></i> <?=_('Follow this event')?>
            </button>
            <a class="note" href="#"><?=_('See my following preferences')?></a>
        </div>

        <?php //todo: make this sidebar more mobile-friendly, with blocks staying side by side if they have little information to make a full 12 column block ?>
        <div class="widget">
            <div class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><?=_('When & Where')?></h4>
                    </div>
                    <div class="panel-body">
                        <p>
                            NYC - Financial Freedom Investor<br>
                            Madison Ave<br>
                            New York, NY 10010<br>
                            <a href="#"><i class="fa fa-map"></i> <?=_('See on a map')?></a><br>
                            <a href="#"><i class="fa fa-map-signs"></i> <?=nbsp(_('Get directions'))?></a>
                        </p>
                        <p>
                            <? if ($end): ?><strong><?=_('Begin')?>:</strong> <? endif ?><?=date($date_fmt_lg, $begin)?><br>
                            <? if ($end): ?><strong><?=_('End')?>:</strong> <?=date($date_fmt_lg, $end)?><br><? endif ?>
                            from 9:00 AM to 6:30 PM<br>
                            <a href="#"><i class="fa fa-calendar-plus-o"></i> <?=_('Add to My Calendar')?></a>
                        </p>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><?=_('Main themes')?></h4>
                    </div>
                    <div class="panel-body">
                        <? //TODO: display here even themes that there was no talk on it; sort by number of talks given ?>
                        @include('components.themes_list')
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><?=_('Organization')?></h4>
                    </div>
                    <div class="panel-body">
                        <h5>Organizer X</h5>
                        <p>Fusce pellentesque velvitae tincidunt egestas. Pellentesque habitant morbi.Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis.</p>
                        <ul>
                            <li><a href="#"></a><i class="fa fa-facebook-square"></i> OrganizerX</li>
                            <li><a href="#"></a><i class="fa fa-twitter-square"></i> @OrganizerX</li>
                            <li><a href="#"></a><i class="fa fa-globe"></i> organizerx.com</li>
                        </ul>
                        <a href="#" class="btn btn-theme btn-theme-grey-dark btn-theme-sm">
                            <i class="fa fa-envelope"></i> <?=_('Send a message')?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </aside>
</div></div>
</section>
@endsection
