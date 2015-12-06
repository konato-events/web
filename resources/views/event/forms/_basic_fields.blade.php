<?php
/** @var \App\Models\Event $event */
Form::model($event); //TODO: find a better way to share the model through partials of forms
use App\Models\EventType;
$fields = isset($fields)? $fields : [];
$showField = function(string $name) use ($fields):bool {
    return !$fields || in_array($name, $fields);
}
?>

<? if ($showField('title')): ?>
    <?=Form::labelInput('title', _('Title'), 'text', null, [
        'input' => ['autofocus'],
        'help' => _("What's the event name? Probably something like 'React.js Conf' or 'International Congress of Mathematicians'?") //TODO: this would better fit a placeholder, but the placeholder style is... weirdly similar to final input
    ])?>
<? endif ?>

<? if ($showField('location')): ?>
    <?=Form::labelInput('location', _('City'), 'text')?>
<? endif ?>

<? if ($showField('event_type_id')): ?>
    <?=Form::labelSelect('event_type_id', _('Event type'), EventType::toTransList(_('Select an option')))?>
<? endif ?>

<? if ($showField('begin')): ?>
    <?=Form::labelInput('begin', _('Begin'), 'date', $event->begin? $event->begin->format('Y-m-d') : null)?>
<? endif ?>

<? if ($showField('end')): ?>
    <?=Form::labelInput('end', _('End'), 'date', $event->end? $event->end->format('Y-m-d') : null, [
        'help' => _('You only need to fill this field if the event lasts for more than one day.')
    ])?>
<? endif ?>
