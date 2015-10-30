<?php
/** @var string $date_fmt
  * @var int $id
  * @var bool  $compact
  * @var bool  $participant
  * @var bool  $participant_gender
  * @var array $themes
  * @var array $event */
use Illuminate\Support\Str;

list($img, $title, $place, $begin, $end, $desc) = $event;
$link = act('event@details', slugify($id, $title));
$compact = $compact ?? false;
$participant = $participant ?? false;

if ($participant) {
    switch ($participant) {
        case PART_ATTEND:
            $color     = 'participant';
            $part_desc = _('%s participated');
            break;
        case PART_INVOLVED:
            $color     = 'involved';
            $part_desc = _('%s was involved / volunteered');
            break;
        case PART_STAFF:
            $color     = 'staff';
            $part_desc = _('%s was part of staff');
            break;
        case PART_SPOKE:
            $color     = 'speaker';
            $part_desc = _('%s was a speaker');
            break;
    }
    $part_desc = ucfirst(sprintf($part_desc, ($participant_gender == 'M')? _('he') : _('she')));
} else {
    $color = $part_desc = false;
}
?>

<div class="thumbnail no-border no-padding <?php if($compact): ?>compact col-md-6 col-lg-6<?php endif ?>">
    <div class="row">
        <div class="col-md-3 col-sm-3 col-xs-4">
            <div class="media">
                <?php //TODO: adding a link to this image wont work ?>
                <img src="<?=$img?>" alt="<?=$title?>">

                {{--<a href="#" class="like"><i class="fa fa-heart"></i></a>--}}
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
                <h3 class="caption-title">
                    <?php if ($color): ?>
                        <i class="fa part-<?=$color?>" title="<?=$part_desc?>"
                           data-toggle="tooltip" data-trigger="hover click" data-container="body"></i>
                    <?php endif ?>
                    <a href="<?=$link?>"><?=$title?></a>
                </h3>

                <p class="caption-category">
                    <i class="fa fa-calendar"></i>
                        <?=date($date_fmt, $begin)?> <?=($end)? ' ~ '.date($date_fmt, $end) : '' ?>
                    <br/>
                    <i class="fa fa-map-marker"></i>
                        <a class="alt" href="<?=act('event@search', ['place' => $place])?>"><?=$place?></a>
                </p>

                {{--<p class="caption-price">Tickets from $49,99</p>--}}
                <?php if (!$compact): ?>
                    <p class="caption-text"><?=Str::words($desc, 15, ' [...]')?></p>

                    <div class="caption-more">
                        <ul class="piped">
                            <?php foreach (array_rand($themes, 3) as $id):
                                $link = act('event@theme', slugify($id, $themes[$id])); ?>
                                <li>
                                    <a href="{{$link}}">{{$themes[$id]}}</a>
                                </li>
                            <?php endforeach ?>
                        </ul>
                        <a href="#" class="btn btn-theme"><?=_('See more details')?></a>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
