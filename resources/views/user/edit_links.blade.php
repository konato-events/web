<?php
/** @var \App\Models\User $user */
const FORM_ID = 'links';
$links = $user->socialLinks(true)->get();
?>
@extends('user.edit_common')


@section('js')
    <script type="text/javascript" src="/js/jquery.validate-1.14.0.js"></script>
    <script type="text/javascript" src="/js/method-links.js"></script>
    <?=Form::validationScript(FORM_ID)?>
    @yield('form-js')
@endsection

@section('form_content')
<?=Form::open()?>
<div class="row">
<div class="col-md-8">

    @include('components.form_errors')

    <div class="panel panel-default" id="social-networks">
        <div class="panel-heading">
            <h4 class="panel-title"><?=_('Connected networks and links')?></h4>
        </div>

        <div class="panel-body">
            <div class="row">
                <? $used_providers = []; ?>
                <? foreach ($links as $link): ?>
                    <? $used_providers[] = strtolower($link->name) ?>
                    <div class="col-md-3 col-xs-4">
                        <div class="social-link-block">
                            <?//FIXME: "-square" should not be stored in the db; stacking should be used when needed ?>
                            <a href="{{$link->url}}">
                                <i class="<?=strtr($link->icon, ['-square' => ''])?> fa-3x"></i>
                                <span title="<?=_('network')?>" class="sr-only">{{$link->name}}</span>
                                <span title="<?=_('username')?>">{{ltrim($link->username,'://')}}</span>
                            </a>
                            <a href="<?=act('user@deleteLink', [$link->id])?>" class="text-muted social-link-remove"
                               data-method="delete" data-token="{{csrf_token()}}">
                                <i class="fa fa-times"></i> <span class="sr-only"><?=_('Remove this link')?></span>
                            </a>
                        </div>
                    </div>
                <? endforeach ?>
            </div>
        </div>
    </div>
</div>

<hr class="page-divider transparent visible-xs" />

<div class="col-md-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title"><?=sizeof($links)? _('Add another one') : _('Add the first one')?></h4>
        </div>

        <div class="panel-body">
            <?=Form::labelInput('link', _('New URL:'), 'url')?>
            <div class="form-group text-center">
                <?=Form::submit(_('Add link'), ['class' => 'btn btn-theme btn-theme-sm'])?>
            </div>

            <hr/>

            <? //TODO: in case the user adds all networks, the button will appear empty. Instead, there should be a message thanking for the user having added all available networks ?>
            <p class="help-block">
                <?=_('You can also associate your account to a network. Not all of them will appear in your profile, but they all can be used to login the next time you come back:')?>
            </p>

            <div class="form-group text-center">
                @include('auth._providers_button', ['default' => false, 'size' => 'lg', 'except' => $used_providers])
            </div>
        </div>
    </div>
</div>
</div>
<?=Form::close()?>
@endsection('form_content')
