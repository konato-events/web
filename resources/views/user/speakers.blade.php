<?php
/** @var App\Models\Theme $theme */
/** @var bool $themed_speakers */
/** @var bool $single_theme */
/** @var App\Models\Theme[] $themes */
/** @var App\Models\User[] $speakers */

if ($theme) {
    $title = _r('Speakers on %s', $theme->name);
    $panel = _('Related themes');
} else {
    if (\Auth::check()) {
        $title = _('Speakers on your themes of interest');
        $panel = _('Themes of interest');
    } else {
        $title = _('Speakers on the most frequent themes');
        $panel = _('Most common themes');
    }
}
?>
@extends('layout-header')
@section('title', $title)

@section('js')
    <script type="text/javascript">
        "use strict";
        jQuery(document).ready(function () {
            theme.init();
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

@section('header-title', $title)
@section('header-bg', '/img/theme-sample1.jpg')
@section('header-breadcrumbs')
    @if ($theme)
        <ul class="breadcrumb">
            {{--<li><a href="#">IT (Information Technologies)</a></li>--}}
            {{--<li><a href="#">Languages</a></li>--}}
            <li><a href="<?=act('theme@events', $theme->slug)?>"><?=$theme->name?></a></li>
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
                                <h4 class="panel-title"><?=$panel?></h4>
                            </div>
                            <div class="panel-body">
                                <? if (sizeof($themes)): ?>
                                    @include('components.themes_list', [ 'link_speakers' => true ])
                                <? else: ?>
                                    <div class="text-center empty-block">
                                        <p>
                                            <?=_r('Hmmm... Looking in our archives about you, there still no themes of interest.')?>
                                            <i class="fa fa-folder-open-o"></i>
                                        </p>
                                    </div>
                                <? endif ?>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>

            <hr class="page-divider small transparent visible-xs"/>

            <section id="content" class="content col-sm-8 col-md-9">

                {{-- TIP: Here was a line with selected tags that could be removed, and relevante/date filters --}}

                <div class="tab-content">
                    <div id="grid-view" class="tab-pane fade active in" role="tabpanel">

                        <? if (!$themed_speakers): ?>
                            <div class="row">
                                <div class="col-xs-10 col-xs-push-1 col-xs-pull-1 text-center empty-block">
                                    <p><?=__('Hmmm... This is awkward, but it seems we still have no speakers on this theme. Meanwhile, these are our most frequent speakers:', 'Hmmm... This is awkward, but it seems we still have no speakers on these themes. Meanwhile, these are our most frequent speakers:', $single_theme? 1 : 2)?></p>
                                    {{--<i class="fa fa-flag-o"></i>--}}
                                </div>
                            </div>
                        <? endif ?>

                        <div class="row thumbnails events">

                            <? $columns = ['lg' => 3, 'md' => 4, 'sm' => 6, 'xs' => 6] ?>
                            <? foreach($speakers as $id => $speaker): ?>
                            <? $link = act('user@profile', $speaker->slug) ?> <?//FIXME: user@speaker is not working ?>
                                <div class="<? foreach ($columns as $sign => $size) echo "col-$sign-$size " ?> isotype-item festival">
                                    <div class="thumbnail no-border no-padding">
                                        <div class="media">
                                            {{--<a href="#" class="like"><i class="fa fa-heart-o"></i></a>--}}
                                            <img src="<?=$speaker->picture?>" alt="<?=_r('%s on Konato', $speaker->name)?>">
                                            <? //TODO: provide here a srcset with the two pictures ?>
                                        </div>
                                        <div class="caption">
                                            <h3 class="caption-title">
                                                <a href="<?=$link?>"><?=$speaker->name?></a>
                                            </h3>
                                            <? if ($speaker->location): ?>
                                                <div class="caption-category">
                                                    <i class="fa fa-map-marker"></i> <?=$speaker->location?> <br>
                                                    {{--@include('components.themes_list')--}}
                                                </div>
                                            <? endif ?>
                                            {{--<p class="caption-price">Tickets from $49,99</p>--}}
                                            <p class="caption-text"><?=$speaker->tagline?></p>
                                            <p class="caption-more">
                                                <a href="<?=$link?>" class="btn btn-theme"><?=_('See full profile')?></a>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                @foreach($columns as $sign => $size)
                                    @if (($id+1) % (12/$size) == 0)
                                        <div class="cleafix col-{{$sign}}-12 visible-{{$sign}}"></div>
                                    @endif
                                @endforeach
                            <? endforeach ?>

                        </div>

                        <!-- Pagination
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
                        /Pagination -->
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>

@endsection
