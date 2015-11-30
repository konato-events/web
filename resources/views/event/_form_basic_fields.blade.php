<?php
use App\Models\EventType;
$fields = isset($fields)? $fields : [];
?>

<? if (!$fields || in_array('title', $fields)): ?>
    <?=Form::labelInput('title', _('Title'), 'text', null, [
        'input' => ['autofocus'],
        'help' => _("What's the event name? Probably something like 'React.js Conf' or 'International Congress of Mathematicians'?") //TODO: this would better fit a placeholder, but the placeholder style is... weirdly similar to final input
    ])?>
<? endif ?>

<? if (!$fields || in_array('location', $fields)): ?>
    <?=Form::labelInput('location', _('City'), 'text')?>
<? endif ?>

<? if (!$fields || in_array('event_type_id', $fields)): ?>
    <?=Form::labelSelect('event_type_id', _('Event type'), EventType::toTransList(_('Select an option')))?>
<? endif ?>
