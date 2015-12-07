<?php
/** @var \App\Models\Event $event */
Form::model($event); //TODO: find a better way to share the model through partials of forms
?>
@extends('event.forms.edit_common')

@section('form_content')
    <div class="row">

        <section id="content" class="content col-sm-12 col-md-8 col-lg-9">

            @include('components.form_errors')

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title"><?=_('Instructions')?></h4>
                </div>
                <div class="panel-body">
                    <p><?=_('To include new activities or edit the current ones in the schedule, you have to do the following:')?></p>
                    <ol>
                        <li><?=_('Download the template file, located just at the right')?>;</li>
                        <li><?=_('Open it in your spreadsheet editor (Microsoft Excel, LibreOffice Calc, etc)')?>;</li>
                        <li><?=_('There are some columns, each with a title. Leave the headers there;')?>;</li>
                        <li><?=_('The second line contains a sample activity. You should fill the cells accordingly')?>;</li>
                        <li><?=_('Pay attention so all cells keep their "text" format! If needed, you can change that selecting all the cells and going to Format > Cells, and changing the format to "text"')?>;</li>
                        <li><?=_('Save the file and select it in the field below')?>;</li>
                        <li><?=_('Submit the file and you\'re done!')?></li>
                    </ol>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-body">
                    <?=Form::labelInput('schedule_file', 'Schedule file', 'file')?>
                </div>
            </div>
        </section>

        <hr class="page-divider transparent visible-xs"/>

        <aside id="sidebar-info" class="sidebar col-sm-12 col-md-4 col-lg-3">

            <div class="widget">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><?=_('Schedule file')?></h4>
                    </div>
                    <div class="panel-body">
                        <a class="btn btn-theme" href="<?=act('event@scheduleTemplateFile')?>">
                            <span class="fa fa-download"></span>
                            <?=_('Get the template')?>
                        </a>
                    </div>
                </div>
            </div>

        </aside>

    </div>
@endsection
