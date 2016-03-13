<?php
/** @var bool $signup */
/** @var \App\Models\User $user */
$signup = $signup ?? false;
Form::model($user); //TODO: find a better way to share form fields
?>

<?=Form::labelInput('name', _('Name'), 'text', null, ['input' => ['autofocus']])?>

<?=Form::labelInput('email', _('E-mail'), 'email')?>

<?=Form::labelInput('username', _('Username'), 'text', null, [
    'input' => [
        'data-unset' => 'true',
        'prefix'     => preg_replace('|https?://|', '', act('user@profile', ['id_slug' => '123']).'-')
    ],
    'help'  => _('Use a uniquely identifying name for you. This will also help you to be found in the search. Use only letters, numbers and underlines, from 4 to 30 chars.')
])?>

<? if ($signup): ?>
    <?=Form::labelInput('password', _('Choose a password'), 'password', null, [
        'help' => _('Use at least 6 chars here. Preferably, with numbers and letters! Bonus points if you include lower-case and upper-case letters, as well as symbols.')
    ])?>

    <?=Form::labelInput('password_confirmation', _('Confirm the password'), 'password', null, ['help' => _('Just to be sure there\'s no typo, could you please repeat that password?')])?>
<? endif ?>
