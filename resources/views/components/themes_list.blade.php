<?php
/** @var array $themes */
use Illuminate\Support\Str;
?>
<ul class="themes">
    <?php foreach($themes as $id => $name): ?>
        <li>
            <a href="<?=act('event@theme', "$id-".Str::slug($name))?>">
                {{$name}}
            </a>
        </li>
    <?php endforeach ?>
</ul>
