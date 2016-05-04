<?php
/** @var string|bool $default */
/** @var string $size */
/** @var array|null $used_providers */
use Illuminate\Support\Arr;
$providers = [
    'facebook'  => ['facebook', 'Facebook'],
    'twitter'   => ['twitter', 'Twitter'],
    'linkedin'  => ['linkedin', 'LinkedIn'],
    'google'    => ['google-plus', 'Google'],
    'live'      => ['windows', 'Microsoft Live'],
    'github'    => ['github', 'Github'],
    'bitbucket' => ['bitbucket', 'Bitbucket'],
];

//see AuthController::loginAfterSignUp()
$default        = isset($default)? $default : ($_COOKIE['last_login_provider']?? false);
$size           = $size?? 'md';
$used_providers = $used_providers?? [];
?>

<div class="btn-group">
    <? if ($default): ?>
        <a class="btn btn-default btn-<?=$size?>" href="<?=act('auth@provider', ['provider' => $default])?>">
            <i class="fa fa-<?=$providers[$default][0]?> fa-<?=$size?> <?=$default?>-color"></i>
            <?=$providers[$default][1]?>
        </a>
    <? endif ?>

    <button class="btn btn-default btn-<?=$size?> dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="sr-only"><?=_('Open login networks list')?></span>
        <? if (!$default): ?>
            <? foreach (['facebook','twitter','linkedin','github'] as $key): ?>
                <i class="fa fa-<?=$size?> <?=$key?>-color fa-<?=$key?>-square"></i>
            <? endforeach ?>
            <i class="fa fa-ellipsis-h"></i>
        <? endif ?>
        <span class="caret"></span>
    </button>

    <ul class="dropdown-menu">
        <? foreach (Arr::except($providers, array_merge($used_providers, (array)$default)) as $provider => $data): ?>
        <li>
            <a href="<?=act('auth@provider', compact('provider'))?>">
                <i class="fa fa-fw fa-<?=$size?> fa-<?=$data[0]?> <?=$provider?>-color"></i>
                <?=$data[1]?>
            </a>
        </li>
        <? endforeach ?>
    </ul>
</div>
