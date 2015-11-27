<?php
/** @var \App\Models\Event $event */
/** @var \Illuminate\Support\MessageBag $errors */
$title     = _('Submit a new event');
$header    = $title;
$subheader = _('Help the community grow, telling us about a new event');
const FORM_ID = 'submit';
?>
@extends('auth._form')
@section('title', $title)

@section('js')
    <script type="text/javascript" src="/js/jquery.validate-1.14.0.js"></script>
    <?=Form::validationScript(FORM_ID)?>
@endsection

@section('header-title', $header)
@section('header-subtitle', $subheader)

@section('form')
    <?=Form::model($event, ['action' => 'EventController@postSubmit', 'id' => FORM_ID])?>

    @include('components.form_errors')

    <?=Form::labelInput('title', _('Title'), 'text', null, [
        'input' => ['autofocus'],
        'help' => _("What's the event name? Probably something like 'React.js Conf' or 'International Congress of Mathematicians'?") //TODO: this would better fit a placeholder, but the placeholder style is... weirdly similar to final input
    ])?>

    <?=Form::labelInput('location', _('City'), 'text')?>

    <?=Form::labelCheckbox('free', _('This is a free event'), null, [
        'help' => _('Tell users if they have to pay to get in or not. In both cases you\'ll be able to provide a page for participants to register or buy tickets.')
    ])?>
    <?=Form::labelCheckbox('closed', _('This is a closed-doors / invite-only event'), null, [
        'help' => _('You can inform users they cannot buy entrances to this event. Some examples: event open to institution students only; employees company meeting; etc. This is only informational: if this is a private event, you should check the next box as well.')
    ])?>
    <?=Form::labelCheckbox('hidden', _('This event should be kept hidden for now'), null, [
        'help' => _('This can be used if it\'s private, or you\'re still planning it and don\'t want the general public to see it. It will be hidden from searches and only accessible through the URL.')
    ])?>

    <div class="row">
        <div class="col-xs-8">
            <?=Form::submit(_('Submit it'), ['class' => 'btn btn-theme btn-theme-lg'])?>
        </div>
    </div>

    <?=Form::close()?>
@endsection
