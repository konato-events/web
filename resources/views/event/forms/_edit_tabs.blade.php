<? /** @var \App\Models\Event $event */ ?>
<ul class="nav nav-tabs">
    <?=activableLink(_('General information'), 'event@edit', [$event->id])?>
    <?=activableLink(_('Themes'), 'event@editThemes', [$event->id])?>
    <?=activableLink(_('Speakers'), 'event@editSpeakers', [$event->id])?>
    <?=activableLink(_('Materials'), 'event@editMaterials', [$event->id])?>
    <?=activableLink(_('Schedule'), 'event@editSchedule', [$event->id])?>
</ul>
