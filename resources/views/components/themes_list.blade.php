<?php
/** @var Theme[] $themes */
/** @var bool    $speaker */
/** @var string  $gender */

$speaker = $speaker ?? false;
$gender  = $gender ?? 'M';
$route = $speaker? 'speaker@theme' : 'event@theme';
    $tooltip = _r('How many times %s has spoken about this subject', ($gender == 'M')? _('he') : _('she'));
?>
<ul class="themes">
    <?php foreach($themes as $theme): ?>
        <li<?=($speaker)? ' class="composed"':''?>>
            <a href="<?=act($route, $theme->slug)?>">
                {{$theme->name}}
                <?php if($speaker): ?>
                    <span title="{{$tooltip}}" data-toggle="tooltip">{{rand(1,20)}}</span>
                <?php endif ?>
            </a>
        </li>
    <?php endforeach ?>
</ul>
