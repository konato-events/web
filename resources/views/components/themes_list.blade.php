<?php
/** @var App\Models\Theme[] $themes */
/** @var bool   $link_speakers */
/** @var int    $count */
/** @var string $gender */

$link_speakers = $link_speakers ?? false;
$gender = $gender ?? 'M';
$count = $count ?? 0;
$route = $link_speakers? 'user@speakers' : 'theme@events';
$tooltip = _r('How many times %s has spoken about this subject', ($gender == 'M')? _('he') : _('she'));
?>
<ul class="themes">
    <?php foreach($themes as $theme): ?>
        <li<?=($link_speakers && $count)? ' class="composed"':''?>>
            <a href="<?=act($route, $theme->slug)?>">
                {{$theme->name}}
                <?php if($link_speakers && $count): ?>
                    <span title="{{$tooltip}}" data-toggle="tooltip"><?=$count?></span>
                <?php endif ?>
            </a>
        </li>
    <?php endforeach ?>
</ul>
