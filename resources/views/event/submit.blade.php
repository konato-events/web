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
        @include('event._form_basic_fields')
        @include('event._form_checkboxes')

        <div class="row">
            <div class="col-xs-8">
                <?=Form::submit(_('Submit it'), ['class' => 'btn btn-theme btn-theme-lg'])?>
            </div>
        </div>

    <?=Form::close()?>
@endsection
