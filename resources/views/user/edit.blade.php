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
            <div class="col-md-8">
                <?=Form::model($user, ['id' => FORM_ID, 'files' => true])?>

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
                    'input' => [
                        'placeholder' => _('Example: I\'m a chemical analyst with experience in catalysis.'),
                        'rows' => 3,
                    ],
                    'help'  => _('Introduce yourself to the community! Write a couple of words to help others understand who you are.')
                ])?>
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

                <?=Form::close()?>
            </div>
        </div>
        </div>
    </section>
@endsection
