<?php
/** @var string $date_fmt
  * @var int $id
  * @var array $event */
use Illuminate\Support\Str;

list($img, $title, $place, $begin, $end, $desc) = $event;
$slug = Str::slug($title);
$link = action('EventController@getDetails', ["$id-$slug"]);
?>
<div class="thumbnail no-border no-padding">
    <div class="row">
        <div class="col-md-3 col-sm-3 col-xs-4">
            <div class="media">
                <a href="<?=$link?>">
                    <img src="<?=$img?>" alt="<?=$title?>"><!-- TODO: adding a link to this image wont work -->
                </a>

                <a href="#" class="like"><i class="fa fa-heart"></i></a>
                {{--<a href="#" class="like"><i class="fa fa-heart-o"></i></a>--}}
            </div>
        </div>

        <div class="col-md-9 col-sm-9 col-xs-8">
            <div class="caption">
                {{-- TIP: this is a share button... for what exactly? --}}
                {{--<a href="#" class="pull-right">--}}
                {{--<span class="fa-stack fa-lg">--}}
                {{--<i class="fa fa-stack-2x fa-circle-thin"></i>--}}
                {{--<i class="fa fa-stack-1x fa-share-alt"></i>--}}
                {{--</span>--}}
                {{--</a>--}}
                <h3 class="caption-title"><a href="<?=$link?>"><?=$title?></a></h3>

                <p class="caption-category">
                    <i class="fa fa-calendar"></i>
                    <?=date($date_fmt, $begin)?> <?=($end)? ' ~ '.date($date_fmt, $end) : '' ?>
                    <br/>
                    <i class="fa fa-map-marker"></i> <?=$place?>
                </p>

                {{--<p class="caption-price">Tickets from $49,99</p>--}}
                <p class="caption-text"><?=partial_text($desc, 15)?></p>
                <div class="caption-more">
                    <ul class="piped">
                        <?php foreach (array_rand($themes, 3) as $id):
                        $link = act('event@theme', "$id-".Str::slug($themes[$id])); ?>
                        <li>
                            <a href="{{$link}}">{{$themes[$id]}}</a>
                        </li>
                        <?php endforeach ?>
                    </ul>
                    <a href="#" class="btn btn-theme"><?=_('See more details')?></a>
                </div>
            </div>
        </div>
    </div>
</div>
