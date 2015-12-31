<?php
/** @var \App\Models\User[] $users */
$class   = $class ?? 'users';
$columns = $columns ?? false;
$details = $details ?? '';
?>

<? if ($columns): ?><div class="container-fluid"><? endif ?>
    <ul class="<?=$class?> <? if($columns): ?>row<? endif ?> <? if(!$details): ?>no-details<? endif ?>">
        <? foreach($users as $id => $speaker): ?>
        <li <? if($columns): ?>class="col-md-6"<? endif ?>>
            <img src="<?=$speaker->avatar?>" alt="<?=_r('%s on Konato', $speaker->name)?>" />
            <div>
                <a href="<?=act('user@profile', $speaker->slug)?>"><?=$speaker->name?></a>
                <?//=eval($details)?>
                <?=$details?>
          </div>
        </li>
        <? endforeach ?>
    </ul>
<? if ($columns): ?></div><? endif ?>
