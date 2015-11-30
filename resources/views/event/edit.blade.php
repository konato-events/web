<?php
/** @var \App\Models\Event $event */
$title    = _r('Edit event - %s', $event->title);
$subtitle = _('Editing event information');
const FORM_ID = 'submit';


function icon(string $name) {
    return " <i class='fa fa-$name'></i> ";
}
?>
@extends('layout-header')
@section('title', $title)
@section('header-bg', '/img/bg-event.jpg')
@section('header-title', $event->title)
@section('header-subtitle', $subtitle)

@section('js')
    <script type="text/javascript" src="/js/jquery.validate-1.14.0.js"></script>
    <?=Form::validationScript(FORM_ID)?>
@endsection

@section('content')
<section class="page-section with-sidebar sidebar-right first-section">
<div class="container">

<?=Form::model($event, ['action' => 'EventController@postEdit', 'id' => FORM_ID])?>
<?=Form::hidden('id')?>
<div class="row">

    <section id="content" class="content col-sm-12 col-md-8 col-lg-9">

        @include('components.form_errors')

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title"><?=_('Basic information')?></h4>
            </div>
            <div class="panel-body">
                @include('event._form_basic_fields', ['fields' => ['title', 'event_type_id']])

                <?=Form::labelInput('description', _('Description'), 'textarea', null, ['input' => ['rows' => 5]])?>

                <?=Form::labelInput('tagline', _('Tagline'), 'text', null, ['help' => _('Describe it in a few words. This will appear above the description in the event page, and in some other places where we need a smaller piece of text.')])?>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title"><?=_('External pages')?></h4>
            </div>
            <div class="panel-body">
                <?=Form::labelInput('website', icon('globe')._('Event website'), 'url')?>

                <?=Form::labelInput('tickets_url', icon('ticket')._('Tickets page'), 'url')?>

                <?=Form::labelInput('twitter', icon('twitter')._('Twitter handle'), 'text', null, ['input' => ['prefix' => '@']])?>
                <?=Form::labelInput('hashtag', icon('quote-left')._('Event hashtag'), 'text', null, [
                    'input' => ['prefix' => '#'],
                    'help' => _('This will suggest participants to post using this hashtag, helping to find what\'s being said about the event and increasing the buzz.')
                ])?>

                <?=Form::labelInput('facebook', icon('facebook')._('Facebook page'), 'url', null, [
                    //TODO: enable this help when we create organization profiles (#64 / #89)
        //            'help' => _('This is the event\'s Facebook page, not the organization one!')
                ])?>
                <?=Form::labelInput('facebook_event', icon('facebook')._('Facebook Event'), 'url', null, [
                    'help' => _('This can help your users spread the word through Facebook, and it\'s another channel to get in touch with the public.')
                ])?>
            </div>
        </div>
    </section>

    <hr class="page-divider transparent visible-xs"/>

    <aside id="sidebar-info" class="sidebar col-sm-12 col-md-4 col-lg-3">

        <div class="widget">
            <div class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><?=_('Where & When')?></h4>
                    </div>
                    <div class="panel-body">
                        <?=Form::labelInput('address', _('Address'), 'textarea', null, ['input' => ['rows' => 2]])?>

                        <?=Form::labelInput('postal_code', _('Postal code'))?>

                        @include('event._form_basic_fields', ['fields' => ['location']])

                        <?=Form::labelInput('begin', _('Begin'), 'date', $event->begin->format('Y-m-d'))?>

                        <?=Form::labelInput('end', _('End'), 'date', $event->end? $event->end->format('Y-m-d') : null)?>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><?=_('Additional options')?></h4>
                    </div>
                    <div class="panel-body">
                        @include('event._form_checkboxes')
                    </div>
                </div>
            </div>
        </div>

    </aside>

</div>

<div class="row text-center">
    <a href="<?=act('event@details', $event->id)?>" class="btn btn-theme btn-theme-lg btn-theme-grey-dark"><?=_('Go back')?></a>
    <?=Form::submit(_('Save'), ['class' => 'btn btn-theme btn-theme-lg'])?>
</div>
<?=Form::close()?>

</div>
</section>
@endsection
