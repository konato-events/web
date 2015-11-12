<?php
/** @var \App\Models\User $user */
/** @var \Illuminate\Support\MessageBag $errors */
$title     = _('Login');
$header    = _('Who\'s there?');
$subheader = _('Identify yourself to get access to the platform');
?>
@extends('auth._form')
@section('title', $title)
@section('header-title', $header)
@section('header-subtitle', $subheader)

@section('form')
<? $intro = _('You can also login using one of the following providers:') ?>
@include('auth._providers_list', ['intro' => $intro])

<?=Form::model(new \App\Models\User, ['action' => 'AuthController@postLogin', 'novalidate' => true])?>
    @include('components.form_errors')
    <?=Form::labelInput('email', _('Username').' / '._('E-mail'), 'email', null, [
            'help' => _('Here you can use either your username or your e-mail: both works!')
    ])?>
    <?=Form::labelInput('password', _('Password'), 'password')?>

    <div class="row">
        <div class="col-xs-8">
            <?=Form::submit(_('Let me in'), ['class' => 'btn btn-theme btn-theme-lg'])?>
        </div>
    </div>

<?=Form::close()?>
@endsection
