<?php
/**
 * @var string              $date_fmt
 * @var bool                $compact
 * @var string              $participation
 * @var string              $gender
 * @var \App\Models\Theme[] $themes
 * @var \App\Models\Event   $event
 */
use App\Models\User;
use Illuminate\Support\Str;

$link = act('event@details', $event->slug);
$compact = $compact ?? false;
$participation = $participation ?? false;

if ($participation) {
    switch ($participation) {
        case User::PARTICIPANT:
            $color             = 'participant';
            $participation_str = _('%s participated');
            break;
        case User::INVOLVED:
            $color             = 'involved';
            $participation_str = _('%s was involved / volunteered');
            break;
        case User::STAFF:
            $color             = 'staff';
            $participation_str = _('%s was part of staff');
            break;
        case User::SPEAKER:
            $color             = 'speaker';
            $participation_str = _('%s was a speaker');
            break;
    }
    $participation_str = ucfirst(sprintf($participation_str, ($gender == 'M')? _('he') : _('she')));
} else {
    $color = $participation_str = false;
}
?>

<div class="thumbnail no-border no-padding <?php if($compact): ?>compact col-md-6 col-lg-6<?php endif ?>">
    <div class="row">
        <div class="col-md-3 col-sm-3 col-xs-4">
            <div class="media">
                <?php //TODO: adding a link to this image wont work ?>
                <img src="<?=$event->publicImg?>" alt="<?=$event->title?>">

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
                        <i class="fa part-<?=$color?>" title="<?=$participation_str?>"
                           data-toggle="tooltip" data-trigger="hover click" data-container="body"></i>
                    <?php endif ?>
                    <a href="<?=$link?>"><?=$event->title?></a>
                </h3>

                <p class="caption-category">
                    <i class="fa fa-calendar"></i>
                    <?=$event->begin->format($date_fmt)?>
                    <?=($event->end)? ' ~ '.$event->end->format($date_fmt) : '' ?>
                    <br/>
                    <i class="fa fa-map-marker"></i>
                    <a class="alt" href="<?=act('event@search', ['location' => $event->location])?>"><?=$event->location?></a>
                </p>

                {{--<p class="caption-price">Tickets from $49,99</p>--}}
                <?php if (!$compact): ?>
                    <p class="caption-text"><?=Str::words($event->description, 15, ' [...]')?></p>

                    <div class="caption-more">
                        <ul class="piped">
                            <? foreach ($event->themes as $ev_theme): ?>
                                <li>
                                    <a href="<?=act('theme@events', $ev_theme->slug)?>">{{$ev_theme->name}}</a>
                                </li>
                            <?php endforeach ?>
                        </ul>
                        <a href="{{$link}}" class="btn btn-theme"><?=_('See more details')?></a>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
