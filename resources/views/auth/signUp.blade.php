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

<? $intro = _('You can sign up using an account from:') //it's a var because of gettext ?>
@include('auth._providers_list', ['intro' => $intro])

<?=Form::model($user, ['action' => 'AuthController@postSignUp', 'id' => FORM_ID])?>

    @include('components.form_errors')

    @include('user._common_fields', ['signup' => true])

    <div class="row">
        <div class="col-xs-8">
            <?=Form::submit(_('Go to my profile'), ['class' => 'btn btn-theme btn-theme-lg'])?>
        </div>
    </div>

<?=Form::close()?>
@endsection
