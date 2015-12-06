<?php
/** @var \App\Models\Event $event */
Form::model($event); //TODO: find a better way to share the model through partials of forms
?>
@extends('event.forms.edit_common')

@section('form_content')
<div class="row">

    <section id="content" class="content col-sm-12 col-md-8 col-lg-9">

        @include('components.form_errors')

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title"><?=_('Basic information')?></h4>
            </div>
            <div class="panel-body">
                @include('event.forms._basic_fields', ['fields' => ['title', 'event_type_id']])

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

                        @include('event.forms._basic_fields', ['fields' => ['location', 'begin', 'end']])
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><?=_('Additional options')?></h4>
                    </div>
                    <div class="panel-body">
                        @include('event.forms._checkboxes')
                    </div>
                </div>
            </div>
        </div>

    </aside>

</div>
@endsection
