<?php
/** @var array $themes */
/** @var bool $link_speakers */

$link_speakers = $link_speakers ?? false;
$route = $link_speakers? 'speaker@theme' : 'event@theme';
?>
<ul class="themes">
    <?php foreach($themes as $id => $name): ?>
        <li>
            <a href="<?=act($route, slugify($id, $name))?>">
                <?=$name?>
            </a>
        </li>
    <?php endforeach ?>
</ul>
