<?php
/** @var \App\Models\User $user */
$title  = _('Edit your profile');
$subtitle = _('Editing your profile');
const FORM_ID = 'submit';
?>
@extends('layout-header')
@section('title', $title)
@section('header-bg', '/img/bg-event.jpg')
@section('header-title', $user->name)
@section('header-subtitle', $subtitle)

@section('css')
  <style type="text/css">
    img.picture {
      width: 100%;
    }
    input[name=picture] {
      margin: 10px 0;
    }
  </style>
@endsection

@section('js')
  <script type="text/javascript" src="/js/jquery.validate-1.14.0.js"></script>
  <?=Form::validationScript(FORM_ID)?>
  @yield('form-js')
@endsection

@section('content')
  <section class="page-section with-sidebar sidebar-right first-section">
    <div class="container">
    <div class="row">
    <?=Form::model($user, ['id' => FORM_ID, 'files' => true])?>
      <div class="col-md-8">

        @include('components.form_errors')

          <div class="row">
            <div class="col-xs-3 col-sm-2">
              <?=Form::label(_('Photo'))?><br/>
              <img src="<?=$user->picture?>" alt="avatar" class="picture" />
              <?=Form::input('file', 'picture', '')?>
            </div>

            <div class="col-xs-9 col-sm-10">
              <?=Form::labelInput('tagline', _('Tagline'), 'text', null, [
                'input' => ['placeholder' => _('Example: Analyst at Acme Inc.')],
                'help'  => _('Describe your professional self in a phrase. What you do for a living?')
              ])?>
            </div>
          </div>

        <?=Form::labelInput('bio', _('Short bio'), 'textarea', null, [
          'help' => _('Introduce yourself to the community! Write a couple of words to help others understand who you are.'),
          'input' => ['rows' => 3, 'placeholder' => _('Example: I\'m a chemical analyst with experience in catalysis.')]
        ])?>

          <div class="panel panel-default" id="social-networks">
            <div class="panel-heading">
              <h4 class="panel-title">
                <?=_('Social networks and external links')?>
                <span class="badge"><?=sizeof($user->links)?:''?></span>
              </h4>
            </div>

            <div class="panel-body">
              <p class="help-block"><?=_('Here you can include links to who you are and your work in the outer world.')?></p>

              <div class="row">
                <? $used_providers = []; ?>
                <? foreach ($user->links(true)->getResults() as $link): ?>
                  <? $used_providers[] = strtolower($link->name) //FIXME: not enough for Live ?>
                  <div class="col-md-3 col-xs-4">
                    <a href="{{$link->url.$link->username}}" class="social-link-block">
                      <?//FIXME: "-square" should not be stored in the db; stacking should be used when needed ?>
                      <i class="<?=strtr($link->icon, ['-square' => ''])?> fa-3x"></i><br/>
                      <span class="sr-only">{{$link->name}}</span>
                      {{ltrim($link->username,'://')}}
                    </a>
                  </div>
                <? endforeach ?>
              </div>

              <?//=Form::labelInput('link', _('You can include a new URL here:'), 'url')?>

              <p class="help-block">
                <?=_('You can also associate your account to a network. Not all of them will appear in your profile, but they all can be used to login the next time you come back:')?>
              </p>
                <div class="form-group text-center">
                    @include('auth._providers_button', ['default' => false, 'size' => 'lg', 'except' => $used_providers])
                </div>
            </div>
          </div>
      </div>

      <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-body">
            @include('user._common_fields')

            <?=Form::labelSelect('gender', _('Gender'), [
              'M' => _('Male'),
              'F' => _('Female'),
              ''  => _('Not informed')
            ]) ?>

            <?=Form::labelInput('birthday', _('Birthday'), 'date', $user->birthday? $user->birthday->format('Y-m-d') : null)?>
          </div>
        </div>
      </div>

      <div class="col-md-12">
        <div class="row buttons-row text-center">
          <a href="javascript:history.back()" class="btn btn-theme btn-theme-lg btn-theme-grey-dark"><?=_('Go back')?></a>
          <?=Form::submit(_('Save'), ['class' => 'btn btn-theme btn-theme-lg'])?>
        </div>
      </div>
    <?=Form::close()?>
    </div>
    </div>
  </section>
@endsection
