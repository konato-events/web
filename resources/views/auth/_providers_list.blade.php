<? /** @var string $intro */ ?>

<div class="well alert-info">
    <p><?=$intro?></p>
    <ul>
        <li>
            <a href="<?=act('auth@provider', ['provider' => 'facebook'])?>">
                <i class="fa fa-facebook-square"></i> Facebook
            </a>
        </li>
        <li>
            <a href="<?=act('auth@provider', ['provider' => 'twitter'])?>">
                <span class="fa fa-twitter-square"></span> Twitter
            </a>
        </li>
        <!--
        <li>
            <a href="<?=act('auth@provider', ['provider' => 'linkedin'])?>">
                <i class="fa fa-linkedin-square"></i> LinkedIn
            </a>
        </li>
        <li>
            <a href="<?=act('auth@provider', ['provider' => 'google'])?>">
                <i class="fa fa-google-plus-square"></i> Google / Google+
            </a>
        </li>
        -->
        <li>
            <a href="<?=act('auth@provider', ['provider' => 'github'])?>">
                <i class="fa fa-github-square"></i> GitHub
            </a>
        </li>
        <li>
            <a href="<?=act('auth@provider', ['provider' => 'bitbucket'])?>">
                <i class="fa fa-bitbucket-square"></i> Bitbucket
            </a>
        </li>
    </ul>
</div>
