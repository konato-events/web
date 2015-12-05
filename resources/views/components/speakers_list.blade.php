<?php
/** @var \App\Models\User[] $speakers */
/** @var bool $columns */
$columns = $columns ?? false
?>

<? if ($columns): ?><div class="container-fluid"><? endif ?>
    <ul class="speakers <? if($columns): ?>row<? endif ?>">
        <? foreach($speakers as $id => $speaker): ?>
            <li <? if($columns): ?>class="col-md-6"<? endif ?>>
                <img src="<?=$speaker->avatar?>" alt="<?=_r('%s on Konato', $speaker->name)?>" />
                <div class="speaker-details">
                    <a href="<?=act('user@profile', $speaker->slug)?>"><?=$speaker->name?></a>
                    <!--
                        <span><?//=__('%d event on theme', '%d events on theme', $on_theme)?></span>
                        <span><?//=__('%d event total', '%d events total', $total)?></span>
                    -->
                </div>
            </li>
        <? endforeach ?>
    </ul>
<? if ($columns): ?></div><? endif ?>