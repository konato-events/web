<?php
/** @var string $intro */
use Illuminate\Support\Arr;
$providers = [
    'facebook'  => ['facebook-square', 'Facebook'],
    'twitter'   => ['twitter-square', 'Twitter'],
    'linkedin'  => ['linkedin-square', 'LinkedIn'],
    'google'    => ['google-plus-square', 'Google'],
    'live'      => ['windows', 'Microsoft Live'],
    'github'    => ['github-square', 'Github'],
    'bitbucket' => ['bitbucket-square', 'Bitbucket'],
];
$default_provider = $_COOKIE['last_login_provider']?? false; //see AuthController::loginAfterSignUp()
?>

<div class="well text-center alert-primary" id="social-login">
    <?=_('You can also use an account from:')?>

    <div class="btn-group">
        <? if ($default_provider): ?>
            <a class="btn btn-default" href="<?=act('auth@provider', ['provider' => $default_provider])?>">
                <i class="fa fa-<?=$providers[$default_provider][0]?> <?=$default_provider?>-color"></i>
                <?=$providers[$default_provider][1]?>
            </a>
        <? endif ?>

        <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="sr-only"><?=_('Open login networks list')?></span>
            <? if (!$default_provider): ?>
                <? foreach (['facebook','twitter','linkedin','github'] as $key): ?>
                    <i class="fa fa-<?=$providers[$key][0]?> <?=$key?>-color"></i>
                <? endforeach ?>
                <i class="fa fa-ellipsis-h"></i>
            <? endif ?>
            <span class="caret"></span>
        </button>

        <ul class="dropdown-menu">
            <? foreach (Arr::except($providers, $default_provider) as $provider => $data): ?>
                <li>
                    <a href="<?=act('auth@provider', compact('provider'))?>">
                        <i class="fa fa-<?=$data[0]?> <?=$provider?>-color"></i> <?=$data[1]?>
                    </a>
                </li>
            <? endforeach ?>
        </ul>
    </div>
</div>
