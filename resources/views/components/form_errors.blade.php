<? /** @var \Illuminate\Support\MessageBag $errors */ ?>
<? if ($errors->any()): ?>
    <div class="well alert-danger">
        <p><?=_('Whoops! Some errors were found. Could you fix them before proceeding?')?></p>
        <ul>
            <? foreach($errors->toArray() as $field => $msgs): ?>
                <? foreach($msgs as $msg): ?>
                    <li><?=$field?>: <?=trans($msg, ['attribute' => _($field)])?></li>
                <? endforeach ?>
            <? endforeach ?>
        </ul>
    </div>
<? endif ?>