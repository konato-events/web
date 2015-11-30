<?=Form::labelCheckbox('free', _('This is a free event'), null, [
    'help' => _('Tell users if they have to pay to get in or not. In both cases you\'ll be able to provide a page for participants to register or buy tickets.')
])?>
<?=Form::labelCheckbox('closed', _('This is a closed-doors / invite-only event'), null, [
    'help' => _('You can inform users they cannot buy entrances to this event. Some examples: event open to institution students only; employees company meeting; etc. This is only informational: if this is a private event, you should check the next box as well.')
])?>
<?=Form::labelCheckbox('hidden', _('This event should be kept hidden for now'), null, [
    'help' => _('This can be used if it\'s private, or you\'re still planning it and don\'t want the general public to see it. It will be hidden from searches and only accessible through the URL.')
])?>
