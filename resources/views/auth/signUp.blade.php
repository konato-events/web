<?php
/** @var \App\Models\User $user */
/** @var \Illuminate\Support\MessageBag $errors */
$title     = _('Sign Up');
$header    = _('Create your account');
$subheader = _('Join the events community now!');
const FORM_ID = 'signup';
?>
@extends('auth._form')
@section('title', $title)

@section('js')
    <script type="text/javascript" src="/js/jquery.validate-1.14.0.js"></script>
    <?=Form::validationScript(FORM_ID)?>
    <script type="text/javascript">
        $username = $('#username');
        $('#email').on('keyup', function() {
            if ($username.attr('data-unset') == 'true') {
                var pos = this.value.indexOf('@');
                $username.val(this.value.substr(0, (pos >= 0)?  pos : this.value.length));
            }
        });
        $('#signup').on('keyup change', '#username[data-unset=true]', function(e) {
            if (e.type == 'change' || [9, 38, 40].indexOf(e.keyCode) == -1) { //Tab, down & up arrows (for completion)
                $username.attr('data-unset', 'false');
            }
        });
    </script>
@endsection

@section('header-title', $header)
@section('header-subtitle', $subheader)

@section('form')
<? if (session('social_error')): ?>
<div class="well alert-danger">
    <?=_r('There was an error with the %s authentication. Could you try again, please?', ucfirst(session('provider')))?>
</div>
<? endif ?>

<? $intro = _('You can also sign up using one of the following websites, if you have a profile there:') ?>
@include('auth._providers_list', ['intro' => $intro])

<?=Form::model($user, ['action' => 'AuthController@postSignUp', 'id' => FORM_ID])?>

    <? if ($errors->any()): ?>
        <div class="well alert-danger">
            <p><?=_('Whoops! Some errors were found. Could you fix them before proceeding?')?></p>
            <ul>
                <? foreach($errors->toArray() as $field => $msgs): ?>
                    <? foreach($msgs as $msg): ?>
                        <li><?=trans($msg, ['attribute' => _($field)])?></li>
                    <? endforeach ?>
                <? endforeach ?>
            </ul>
        </div>
    <? endif ?>

    <?=Form::labelInput('name', _('Name'), 'text', null, ['input' => ['autofocus']])?>

    <?=Form::labelInput('email', _('E-mail'), 'email')?>

    <?=Form::labelInput('username', _('Username'), 'text', null, [
        'input' => [
            'data-unset' => 'true',
            'prefix' => preg_replace('|https?://|', '', act('user@profile', ['id_slug' => '123']).'-')
        ],
        'help'  => _('Use a uniquely identifying name for you. This will also help you to be found in the search. Use only letters, numbers and underlines, from 4 to 30 chars.')
    ])?>

<?=Form::labelInput('password', _('Choose a password'), 'password', null, [
    'help' => _('Use at least 6 chars here. Preferably, with numbers and letters! Bonus points if you include lower-case and upper-case letters, as well as symbols.')
])?>

<?=Form::labelInput('password_confirmation', _('Confirm the password'), 'password', null, [
    'help' => _('Just to be sure there\'s no typo, could you please repeat that password?')
])?>

<!-- Hidden to get out of the way of our new user!
    <?=Form::labelInput('tagline', _('Tagline'), 'text', null, [
        'input' => ['placeholder' => 'Example: Job at Acme Inc.'],
        'help'  => _('Describe your professional self in a phrase. What you do for a living?')
    ])?>

    <?=Form::labelInput('bio', _('Short bio'), 'text', null, [
        'input' => ['placeholder' => 'Example: Job at Acme Inc.'],
        'help'  => _('Introduce yourself to the community! Write a couple of words to help others understand who you are.')
    ])?>
-->

<div class="row">
    <div class="col-xs-8">
        <?=Form::submit(_('Go to my profile'), ['class' => 'btn btn-theme btn-theme-lg'])?>
    </div>
</div>

<?=Form::close()?>
@endsection
