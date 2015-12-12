<?php
/** @var \App\Models\Event $event */
$title    = _r('Edit event - %s', $event->title);
$subtitle = _('Editing event information');
const FORM_ID = 'submit';
?>
@extends('layout-header')
@section('title', $title)
@section('header-bg', '/img/bg-event.jpg')
@section('header-title')
    <?//TODO: include a warning "are you sure you want to leave the page" when items were edited ?>
    <a href="<?=act('event@details', $event->slug)?>" title="<?=_('Go back')?>" data-toggle="tooltip">
        <?=$event->title?>
    </a>
@endsection
@section('header-subtitle', $subtitle)

@section('js')
    <script type="text/javascript" src="/js/jquery.validate-1.14.0.js"></script>
    <?=Form::validationScript(FORM_ID)?>
    @yield('form-js')
@endsection

@section('content')
    <section class="page-section with-sidebar sidebar-right first-section">
        <div class="container">

            <ul class="nav nav-tabs">
                <?=activableLink(_('General information'), 'event@edit', [$event->id])?>
                <?=activableLink(_('Themes').' & '._('Speakers'), 'event@editThemesSpeakers', [$event->id])?>
                <!--<?=activableLink(_('Materials'), 'event@editMaterials', [$event->id])?>-->
                <?=activableLink(_('Schedule'), 'event@editSchedule', [$event->id])?>
            </ul>

            <?=Form::model($event, ['id' => FORM_ID, 'files' => true])?>

                <?=Form::hidden('id')?>

                @yield('form_content')

                <div class="row buttons-row text-center">
                    <a href="<?=act('event@details', $event->id)?>" class="btn btn-theme btn-theme-lg btn-theme-grey-dark"><?=_('Go back')?></a>
                    <?=Form::submit(_('Save'), ['class' => 'btn btn-theme btn-theme-lg'])?>
                </div>

            <?=Form::close()?>

        </div>
    </section>
@endsection
