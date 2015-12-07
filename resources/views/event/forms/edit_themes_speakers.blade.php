<?php
/** @var \App\Models\Event $event */
Form::model($event); //TODO: find a better way to share the model through partials of forms
?>
@extends('event.forms.edit_common')

@section('css')
    <link rel="stylesheet" href="/css/select2.min.css" />
@endsection
@section('form-js')
    <script type="text/javascript" src="/js/select2.min.js"></script>
    <script type="text/javascript">
        var $speaker_ids   = $('#speaker_ids');
        var $theme_ids     = $('#theme_ids');
        var $speakers_list = $('#speakers_list');
        var $speakers_ul   = $speakers_list.find('ul');
        var fill_field     = function(id, $field) {
            $field.val($field.val() + ',' + id);
        };

        //TODO: translate the select2 components
        $('[name=speakers]').select2({
            minimumInputLength: 2,
            ajax: {
                url: '/autocomplete/users',
                cache: true, //TODO: https://github.com/select2/select2/issues/3984
                delay: 250,
                processResults: function(data) { return { results: data } }
            }
        })
        .on('select2:select', function(e) {
            var speaker = e.params.data;

            $(this).val(null).trigger('change'); //clears the list

            $speakers_list.find('h4')
                .show()
                .find('span').fadeIn(); //display the title if it's not there

            var $li = $('<li>');
            $li.data('id', speaker.id);
            $li.text(speaker.text + ' ');
//            $li.append('<i class="fa fa-remove">');
            $li.appendTo($speakers_ul); //adds the speaker to the list below

            fill_field(speaker.id, $speaker_ids); //and stores him in the hidden field
        });

        $('[name=themes_str]').select2({
            tags: true,
            multiple: true,
            tokenSeparators: [',', ';'],
            ajax: {
                url: '/autocomplete/themes',
                cache: true, //TODO: https://github.com/select2/select2/issues/3984
                delay: 250,
                processResults: function(data) { return { results: data } }
            }
        })
        .on('select2:select', function(e) {
            fill_field(e.params.data.text, $theme_ids);
        });
    </script>
@endsection

@section('form_content')
    <div class="row">

        <section id="content" class="content col-sm-12 col-md-7 col-lg-8">

            @include('components.form_errors')

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title"><?=_('Speakers')?></h4>
                </div>
                <div class="panel-body">
                    <?=Form::labelSelect('speakers', _('To add a speaker, search for a user in this list:'))?>

                    <input type="hidden" name="speaker_ids" id="speaker_ids" />
                    <div id="speakers_list">
                        <? $speakers = $event->speakers ?>
                        <h4 <? if (!sizeof($speakers)): ?>style="display:none"<? endif ?>>
                            <?=_('Speakers')?><span> (<?=_('unsaved')?>)</span>:
                        </h4>
                        <ul>
                            <? foreach ($event->speakers as $speaker): ?>
                                <li data-id="<?=$speaker->id?>">
                                    <?=$speaker->name?>
                                    {{--<i class="fa fa-remove"></i>--}}
                                </li>
                            <? endforeach ?>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <hr class="page-divider transparent visible-xs" />

        <aside id="sidebar-info" class="sidebar col-sm-12 col-md-5 col-lg-4">

            <div class="widget">
                <div class="panel panel-default">
                    <div class="panel-heading" >
                        <h4 class="panel-title"><?=_('Themes')?></h4>
                    </div>
                    <div class="panel-body">
                        <input type="hidden" name="theme_ids" id="theme_ids" />
                        <? //TODO: fix this label's font size ?>
                        <? $themes_list = $event->themes->pluck('name', 'id')->all() ?>
                        <?=Form::labelSelect('themes_str', _('Write event themes separated by commas:'), $themes_list, array_keys($themes_list), ['input' => ['class' => 'tags-input', 'multiple' => true]])?>
                    </div>
                </div>
            </div>

        </aside>

    </div>
@endsection
