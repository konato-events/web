<? /** @var string $intro */ ?>
<? $providers = [
    'facebook'  => ['facebook-square', 'Facebook'],
    'twitter'   => ['twitter-square', 'Twitter'],
    'linkedin'  => ['linkedin-square', 'LinkedIn'],
    'google'    => ['google-plus-square', 'Google / Google+'],
    'github'    => ['github-square', 'Github'],
    'bitbucket' => ['bitbucket-square', 'Bitbucket'],
]; ?>

<div class="well alert-primary" id="social-login">
    <?=$intro?>
    <div class="btn-group">
        <button class="btn btn-default btn-lg dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <? foreach (['facebook','twitter','linkedin','github'] as $key): ?>
                <i class="fa fa-<?=$providers[$key][0]?> <?=$key?>-color"></i>
            <? endforeach ?>
            <i class="fa fa-ellipsis-h"></i>
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <? foreach ($providers as $provider => $data): ?>
                <li>
                    <a href="<?=act('auth@provider', compact('provider'))?>">
                        <i class="fa fa-<?=$data[0]?> <?=$provider?>-color"></i> <?=$data[1]?>
                    </a>
                </li>
            <? endforeach ?>
        </ul>
    </div>
</div>
