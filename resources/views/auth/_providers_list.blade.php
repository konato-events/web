<? /** @var string|bool $intro */ $intro = $intro?? ''; ?>

<div class="well text-center alert-primary" id="social-login">
    <? if ($intro !== false): ?>
        <?=$intro?: _('You can also use an account from:')?>
    <? endif ?>

    @include('auth._providers_button')
</div>
