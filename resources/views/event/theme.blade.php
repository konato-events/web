<?php
/** @var string   $theme
  * @var int      $paid
  * @var string[] $types
  * @var int[]    $selected_types */

use Illuminate\Support\Str;

$title = sprintf(_('Events about %s'), $theme);
?>
@extends('layout-master')
@section('title', $title)

@section('content')
<section class="page-section image breadcrumbs overlay small" style="background-image: url(/img/theme-sample1.jpg)">
    <div class="container">
        <h1>{{$theme}}</h1>
        <ul class="breadcrumb">
            <li><a href="#">IT (Information Technologies)</a></li>
            <li><a href="#">Languages</a></li>
            <li class="active">{{$theme}}</li>
        </ul>
    </div>
</section>

<section class="page-section with-sidebar first-section">
    <div class="container">

        <aside id="sidebar" class="sidebar col-md-3">

            <form class="widget">
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><?=_('Event types')?></h4>
                        </div>
                        <div class="panel-body">
                            <div class="checkbox">
                                <?php foreach($types as $id => $value):
                                $check = in_array($id, $selected_types); ?>
                                <label>
                                    <input type="checkbox" name="theme" value="{{$id}}" <?=$check? 'checked':''?>> {{$value}}
                                </label>
                                <?php endforeach ?>
                            </div>

                            <div class="row" id="paid_select">
                                <div class="col-xs-12">
                                    <input type="range" min="-1" max="1" value="<?=$paid?>">
                                </div>
                                <div class="col-xs-4 text-left">  <?=_('Free')?></div>
                                <div class="col-xs-4 text-center"><?=_('Both')?></div>
                                <div class="col-xs-4 text-right"> <?=_('Paid')?></div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><?=_('Related themes')?></h4>
                        </div>
                        <div class="panel-body">
                            <ul>
                                @foreach($themes as $id => $name)
                                    <li>
                                        <a href="{{action('EventController@getTheme', "$id-".Str::slug($name))}}">
                                            {{$name}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </form>

        </aside>

        <hr class="page-divider transparent visible-xs">

        <section id="content" class="content col-md-7">

            <div class="listing-meta">

                <div class="options">
                    <a class="byrevelance" href="#"><?=_('Relevance')?></a>
                    <a class="bydate active" href="#"><?=_('Date')?></a>
                </div>

            </div>

            <?php //TODO: see if this block is repeatable enough to become a component as well ?>
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

        <hr class="page-divider transparent visible-xs"/>

        <aside id="sidebar-info" class="sidebar col-md-2">

            <div class="widget">
                xxxx
            </div>

        </aside>
    </div>
</section>
@endsection