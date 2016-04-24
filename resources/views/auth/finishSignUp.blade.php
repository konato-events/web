<?php
/** @var \App\Models\User $user */
/** @var \Illuminate\Support\MessageBag $errors */
/** @var string $provider */
/** @var string $provider_id */
$title     = _('Social Sign Up');
$header    = _('Finish creating your account');
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
    </script>
@endsection

@section('header-title', $header)
@section('header-subtitle', $subheader)

@section('form')
<?=Form::model($user, ['action' => 'AuthController@postFinishSignUp', 'id' => FORM_ID])?>
    <?=Form::hidden('provider', $provider)?>

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

    <? if ($provider == 'twitter'): ?>
        <?=Form::labelInput('email', _('E-mail'), 'email')?>
    <? endif ?>

    <?=Form::labelInput('username', _('Username'), 'text', null, [
        'input' => [
            'data-unset' => 'true',
            'prefix' => preg_replace('|https?://|', '', act('user@profile', ['id_slug' => '123']).'-')
        ],
        'help'  => _('Use a uniquely identifying name for you. This will also help you to be found in the search. Use only letters, numbers and underlines, from 4 to 30 chars.')
    ])?>

    <div class="row">
        <div class="col-xs-8">
            <?=Form::submit(_('Go to my profile'), ['class' => 'btn btn-theme btn-theme-lg'])?>
        </div>
    </div>

<?=Form::close()?>
@endsection
