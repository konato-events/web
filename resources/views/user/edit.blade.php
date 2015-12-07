<?php
/** @var \App\Models\User $user */
$title    = _('Edit your profile');
$subtitle = _('Editing your profile');
const FORM_ID = 'submit';
?>
@extends('layout-header')
@section('title', $title)
@section('header-bg', '/img/bg-event.jpg')
@section('header-title', $user->name)
@section('header-subtitle', $subtitle)

@section('js')
    <script type="text/javascript" src="/js/jquery.validate-1.14.0.js"></script>
    <?=Form::validationScript(FORM_ID)?>
    @yield('form-js')
@endsection

@section('content')
    <section class="page-section with-sidebar sidebar-right first-section">
        <div class="container">
        <div class="row">
        <div class="col-xs-12   col-sm-10 col-sm-offset-1   col-md-8 col-md-offset-2   col-lg-6 col-lg-offset-3">
            <?=Form::model($user, ['id' => FORM_ID])?>

            @include('components.form_errors')

            @include('user._common_fields')

            <?=Form::labelInput('tagline', _('Tagline'), 'text', null, [
                'input' => ['placeholder' => _('Example: Analyst at Acme Inc.')],
                'help'  => _('Describe your professional self in a phrase. What you do for a living?')
            ])?>

            <?=Form::labelInput('bio', _('Short bio'), 'textarea', null, [
                'input' => [
                    'placeholder' => _('Example: I\'m a chemical analyst with experience in catalysis.'),
                    'rows' => 2,
                ],
                'help'  => _('Introduce yourself to the community! Write a couple of words to help others understand who you are.')
            ])?>

            <?//FIXME: those smaller fields should be left in a sidebar ?>
            <?=Form::labelInput('birthday', _('Birthday'), 'date', $user->birthday? $user->birthday->format('Y-m-d') : null)?>

            <?=Form::labelSelect('gender', _('Gender'), ['M' => _('Male'), 'F' => _('Female')]) //TODO: use radios ?>

            <div class="row buttons-row text-center">
                <a href="javascript:history.back()" class="btn btn-theme btn-theme-lg btn-theme-grey-dark"><?=_('Go back')?></a>
                <?=Form::submit(_('Save'), ['class' => 'btn btn-theme btn-theme-lg'])?>
            </div>

            <?//TODO: Include a picture uploader ?>

            <?=Form::close()?>
        </div>
        </div>
        </div>
    </section>
@endsection
