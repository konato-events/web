<?php
/** @var \App\Models\User $user */
$title     = _('Sign Up');
$header    = _('Create your account');
$subheader = _('Join the events community now!');
?>
@extends('layout-header')
@section('title', $title)

@section('js')
    <script type="text/javascript" src="/js/jquery.validate-1.14.0.js"></script>
    <script type="text/javascript" src="/laravalid/jquery.validate.laravalid.js"></script>
    <script type="text/javascript">
        $('form#signup').validate();

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

@section('content')
<section class="page-section first-section">
<div class="container">

    <div class="row">
    <div class="col-xs-12   col-sm-8 col-sm-offset-2   col-md-6 col-md-offset-3   col-lg-4 col-lg-offset-4">
        <?=Form::model($user, ['action' => 'UserController@postSignUp', 'id' => 'signup'])?>

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
    </div>
    </div>

</div>
</section>

@endsection
