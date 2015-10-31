<?php
/** @var array $speakers */
/** @var bool $columns */
$columns = $columns ?? false
?>

<? if ($columns): ?><div class="container-fluid"><? endif ?>
    <ul class="speakers <? if($columns): ?>row<? endif ?>">
        <? foreach($speakers as $id => $speaker): ?>
            <? list($img, $name, $place, $themes, $on_theme, $total, $bio) = $speaker ?>
            <li <? if($columns): ?>class="col-md-6"<? endif ?>>
                <img src="<?=$img?>" alt="<?=_r('%s on Konato', $name)?>" />
                <div class="speaker-details">
                    <a href="<?=act('user@speaker', slugify($id, $name))?>"><?=$name?></a>
                    <span><?=__('%d event on theme', '%d events on theme', $on_theme)?></span>
                    <span><?=__('%d event total', '%d events total', $total)?></span>
                </div>
            </li>
        <? endforeach ?>
    </ul>
<? if ($columns): ?></div><? endif ?>