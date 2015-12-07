<?php namespace App\Models;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int  id
 * @property int  event_id
 * @property int  user_id
 * @property bool important
 *
 * @property Collection|Session[] sessions
 * @property User user
 *
 * @method BelongsToMany sessions
 * @method BelongsTo user
 */
class EventSpeaker extends Base {

    protected     $table         = 'event_speaker';

    public static $relationsData = [
        'sessions' => [self::BELONGS_TO_MANY, Session::class, 'table' => 'session_speaker'], //FIXME: seems wrong
        'speaker'  => [self::BELONGS_TO, User::class]
    ];
}
